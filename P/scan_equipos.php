<?php
// scan_equipos.php (paralelizado + nmap por subred + batch update)
header('Content-Type: application/json');
date_default_timezone_set('America/Lima');
error_reporting(E_ERROR | E_PARSE);

require_once __DIR__ . '/../AD/ad.php';
$mysqli = conectar();

// --------------- CONFIG ---------------
$CONCURRENCY = 20;            // procesos paralelos para ping
$PING_TIMEOUT_MS = 500;      // timeout de ping (ms) para fping/fallback
$NMAP_AVAILABLE = (trim(shell_exec('which nmap 2>/dev/null')) !== '');
$FPING_AVAILABLE = (trim(shell_exec('which fping 2>/dev/null')) !== '');
// --------------------------------------

// ---------- helpers ----------
function commandExists($cmd) {
    return trim(shell_exec('which ' . escapeshellarg($cmd) . ' 2>/dev/null')) !== '';
}

function ipTo24($ip) {
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return null;
    $p = explode('.', $ip);
    return "{$p[0]}.{$p[1]}.{$p[2]}.0/24";
}

function nmapScanSubnet($subnet) {
    $res = ['up_ips' => [], 'macs' => []];
    if (!commandExists('nmap')) return $res;
    $esc = escapeshellarg($subnet);
    exec("nmap -sn -n $esc -oG - 2>&1", $out, $rc);
    $txt = implode("\n", $out);

    // Hosts UP
    if (preg_match_all('/Host:\s*([\d\.]+).*Status:\s*Up/i', $txt, $m)) {
        foreach ($m[1] as $ip) $res['up_ips'][$ip] = true;
    }

    // MACs (buscar línea previa con Host)
    $lines = explode("\n", $txt);
    $lastIp = null;
    foreach ($lines as $ln) {
        if (preg_match('/Host:\s*([\d\.]+).*Status:\s*Up/i', $ln, $mi)) {
            $lastIp = $mi[1];
        }
        if ($lastIp && preg_match('/MAC Address:\s*([0-9A-Fa-f:]{17})/i', $ln, $ma)) {
            $res['macs'][$lastIp] = strtolower($ma[1]);
            $lastIp = null;
        }
    }

    return $res;
}

function checkMacArp($mac) {
    if (empty($mac)) return false;
    exec("arp -a 2>&1", $out, $rc);
    $txt = implode("\n", $out);
    return (stripos($txt, strtolower($mac)) !== false);
}

// Ejecuta pings en paralelo usando fping si está disponible,
// si no, usa proc_open con ping por IP (Linux/Windows compatible).
// Retorna array de ips vivas => true.
function parallelPing(array $ips, $concurrency = 20, $timeout_ms = 500) {
    $alive = [];

    // Si fping disponible, usarlo (muy eficiente)
    if (trim(shell_exec('which fping 2>/dev/null')) !== '') {
        // -a muestra solo vivos, -r 1 retry 1, -t timeout en ms
        $cmd = "fping -a -r 1 -t " . intval($timeout_ms) . " " . implode(' ', array_map('escapeshellarg', $ips)) . " 2>/dev/null";
        exec($cmd, $out, $rc);
        foreach ($out as $line) {
            $l = trim($line);
            if (filter_var($l, FILTER_VALIDATE_IP)) $alive[$l] = true;
        }
        return $alive;
    }

    // Fallback sin fping -> proc_open por lotes
    $isWindows = stripos(PHP_OS, 'WIN') === 0;
    $queue = array_values($ips);
    $running = [];

    while (!empty($queue) || !empty($running)) {
        // arrancar nuevos procesos hasta concurrency
        while (count($running) < $concurrency && !empty($queue)) {
            $ip = array_shift($queue);
            if ($isWindows) {
                // Windows ping: -n 1 -w timeout(ms)
                $cmd = "ping -n 1 -w " . intval($timeout_ms) . " " . escapeshellarg($ip);
            } else {
                // Linux ping: -c 1 -W timeout(secs) -> convertir ms->s (usar 1s min)
                $w = max(1, intval(ceil($timeout_ms / 1000)));
                $cmd = "ping -c 1 -W $w " . escapeshellarg($ip);
            }
            $descriptors = [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w']
            ];
            $proc = proc_open($cmd, $descriptors, $pipes);
            if (is_resource($proc)) {
                stream_set_blocking($pipes[1], false);
                stream_set_blocking($pipes[2], false);
                $running[] = ['proc' => $proc, 'pipes' => $pipes, 'ip' => $ip, 'start' => microtime(true)];
            } else {
                // si no se pudo abrir, saltarlo
            }
        }

        // revisar procesos en ejecución
        foreach ($running as $k => $r) {
            $status = proc_get_status($r['proc']);
            $stdout = stream_get_contents($r['pipes'][1]);
            $stderr = stream_get_contents($r['pipes'][2]);

            // si proceso terminó
            if ($status['running'] === false) {
                // code de retorno
                $exitcode = $status['exitcode'];
                // en muchos sistemas exitcode 0 => alive
                if ($exitcode === 0) {
                    $alive[$r['ip']] = true;
                } else {
                    // fallback: parsear stdout para tener mayor seguridad (opcional)
                    if (stripos($stdout, 'ttl') !== false || stripos($stdout, 'TTL') !== false) {
                        $alive[$r['ip']] = true;
                    }
                }
                // cerrar pipes y proceso
                foreach ($r['pipes'] as $p) @fclose($p);
                proc_close($r['proc']);
                unset($running[$k]);
            } else {
                // kill procesos que exceden cierto tiempo (ej 5s) para evitar bloqueos
                if ((microtime(true) - $r['start']) > 10) {
                    // forzar cierre
                    foreach ($r['pipes'] as $p) @fclose($p);
                    proc_terminate($r['proc']);
                    proc_close($r['proc']);
                    unset($running[$k]);
                }
            }
        }

        // pequeña pausa para evitar busy loop
        usleep(50000);
    }

    return $alive;
}

// ---------- obtener equipos ----------
$sql = "SELECT id_ubicacion_equipos, ip_ubicacion_equipos, mac_ubicacion_equipos, estado_conexion
        FROM ubicacion_equipos";
$res = $mysqli->query($sql);
if (!$res) {
    echo json_encode(['ok' => false, 'error' => "Error SELECT: " . $mysqli->error]);
    exit;
}
$equipos = $res->fetch_all(MYSQLI_ASSOC);

// Agrupar subredes /24 únicas
$subnets = [];
foreach ($equipos as $e) {
    $ip = trim($e['ip_ubicacion_equipos']);
    $s = ipTo24($ip);
    if ($s) $subnets[$s] = true;
}

// 1) Intentar nmap por subredes (rápido)
$globalUp = [];  // ip => true
$globalMac = []; // ip => mac
if ($NMAP_AVAILABLE && !empty($subnets)) {
    foreach (array_keys($subnets) as $sn) {
        $out = nmapScanSubnet($sn);
        foreach ($out['up_ips'] as $ip => $_) $globalUp[$ip] = true;
        foreach ($out['macs'] as $ip => $mac) $globalMac[$ip] = $mac;
    }
}

// 2) Para los IPs que nmap NO marcó como up, hacemos pings paralelos
$ipsToPing = [];
foreach ($equipos as $e) {
    $ip = trim($e['ip_ubicacion_equipos']);
    if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) continue;
    if (!isset($globalUp[$ip])) $ipsToPing[$ip] = true;
}

$pingAlive = [];
if (!empty($ipsToPing)) {
    $pingAlive = parallelPing(array_keys($ipsToPing), $CONCURRENCY, $PING_TIMEOUT_MS);
}

// 3) Evaluar cada equipo y preparar updates (solo si cambió estado)
$now = date('Y-m-d H:i:s');
$results = [];
$updates = []; // tuples (id, estado, ultima_deteccion_or_NULL)

foreach ($equipos as $eq) {
    $id = (int)$eq['id_ubicacion_equipos'];
    $ip = trim($eq['ip_ubicacion_equipos']);
    $mac = strtolower(trim($eq['mac_ubicacion_equipos']));
    $estado_actual = (int)$eq['estado_conexion'];
    $online = false;

    // 1) si nmap detectó -> online
    if (!empty($ip) && isset($globalUp[$ip])) {
        $online = true;
    } elseif (!empty($ip) && isset($pingAlive[$ip])) {
        // 2) si ping paralelo detectó -> online
        $online = true;
    } elseif (!empty($mac) && checkMacArp($mac)) {
        // 3) fallback por ARP
        $online = true;
    } else {
        $online = false;
    }

    $estado_nuevo = $online ? 1 : 0;

    if ($estado_nuevo !== $estado_actual) {
        $ultima = $online ? $now : null;
        // escapar valores para insert masivo
        $idEsc = intval($id);
        if ($ultima === null) $updates[] = "($idEsc, 0, NULL)";
        else $updates[] = "($idEsc, 1, '" . $mysqli->real_escape_string($ultima) . "')";
    }

    $results[] = [
        'id' => $id,
        'ip' => $ip,
        'mac' => $mac,
        'estado' => $estado_nuevo,
        'ultima_deteccion' => $online ? $now : null
    ];
}

// 4) Ejecutar UPDATE masivo si hay cambios (usa INSERT ... ON DUPLICATE KEY UPDATE)
// Nota: asume que id_ubicacion_equipos es PRIMARY KEY o UNIQUE.
if (!empty($updates)) {
    $values = implode(",", $updates);
    $sqlUpdate = "
        INSERT INTO ubicacion_equipos (id_ubicacion_equipos, estado_conexion, ultima_deteccion)
        VALUES $values
        ON DUPLICATE KEY UPDATE 
            estado_conexion = VALUES(estado_conexion),
            ultima_deteccion = VALUES(ultima_deteccion)";
    $mysqli->query($sqlUpdate);
    if ($mysqli->errno) {
        // fallback: intentar updates individuales si algo sale mal
        error_log("scan_equipos: error batch update: " . $mysqli->error);
        foreach ($updates as $v) {
            // $v tiene la forma "(id, estado, 'ts')" o "(id, 0, NULL)"
            // reconstruir UPDATE simple
            if (preg_match('/^\((\d+),\s*(\d),\s*(NULL|\'(.+)\')\)$/', $v, $m)) {
                $id0 = intval($m[1]);
                $estado0 = intval($m[2]);
                if ($m[3] === 'NULL') {
                    $u = "UPDATE ubicacion_equipos SET estado_conexion = $estado0, ultima_deteccion = NULL WHERE id_ubicacion_equipos = $id0";
                } else {
                    $ts = $mysqli->real_escape_string($m[4]);
                    $u = "UPDATE ubicacion_equipos SET estado_conexion = $estado0, ultima_deteccion = '$ts' WHERE id_ubicacion_equipos = $id0";
                }
                $mysqli->query($u);
            }
        }
    }
}

// 5) Retornar resultados
echo json_encode(['ok' => true, 'scanned' => count($equipos), 'changes' => count($updates), 'data' => $results]);
exit;

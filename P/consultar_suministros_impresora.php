<?php
// consultar_suministros_impresora.php
// Script optimizado para consultar suministros de impresoras via SNMP en LAN
// Versión mejorada con descubrimiento dinámico de consumibles

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('America/Lima');

// Configuración de errores
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('log_errors', '1');

require_once __DIR__ . '/../AD/ad.php';

// Verificar extensión SNMP
if (!function_exists('snmp2_get')) {
    echo json_encode([
        'ok' => false,
        'error' => 'Extensión SNMP no disponible. Instalar: sudo apt-get install php-snmp'
    ]);
    exit;
}

// ===== CONFIGURACIÓN SNMP =====
define('SNMP_COMMUNITY', 'public');
define('SNMP_TIMEOUT', 3000000);    // 3 segundos (microsegundos)
define('SNMP_RETRIES', 2);          // 2 reintentos
define('MAX_TIME_PER_PRINTER', 15); // Máximo 15 segundos por impresora

// ===== OIDs ESTÁNDAR (RFC 3805) =====
define('OID_SYS_DESCR', '1.3.6.1.2.1.1.1.0');
define('OID_SYS_NAME', '1.3.6.1.2.1.1.5.0');

// OIDs base para consumibles (se concatenará el índice dinámico)
define('OID_SUPPLY_DESC', '1.3.6.1.2.1.43.11.1.1.6.1');
define('OID_SUPPLY_MAX', '1.3.6.1.2.1.43.11.1.1.8.1');
define('OID_SUPPLY_CURRENT', '1.3.6.1.2.1.43.11.1.1.9.1');

// Silenciar warnings de SNMP
set_error_handler(function($errno, $errstr) {
    if (strpos($errstr, 'snmp') !== false) {
        return true;
    }
    return false;
});

/**
 * Realiza consulta SNMP GET con soporte para v1 y v2c
 */
function snmpGetValue($ip, $oid) {
    // Intentar SNMP v2c primero
    $result = @snmp2_get($ip, SNMP_COMMUNITY, $oid, SNMP_TIMEOUT, SNMP_RETRIES);

    // Si falla, intentar SNMP v1
    if ($result === false) {
        $result = @snmpget($ip, SNMP_COMMUNITY, $oid, SNMP_TIMEOUT, SNMP_RETRIES);
    }

    if ($result === false) {
        return null;
    }

    // Limpiar el valor (remover comillas y tipos SNMP)
    $value = trim($result);
    $value = preg_replace('/^(STRING|INTEGER|Counter32|Gauge32|Timeticks):\s*/', '', $value);
    $value = trim($value, '"');

    return $value;
}

/**
 * Descubre todos los consumibles disponibles mediante SNMP WALK
 * Esta es la clave para que funcione con impresoras reales
 */
function descubrirConsumibles($ip) {
    $consumibles = [];

    // Walk por las descripciones de suministros
    $descripciones = @snmp2_real_walk(
        $ip,
        SNMP_COMMUNITY,
        OID_SUPPLY_DESC,
        SNMP_TIMEOUT,
        SNMP_RETRIES
    );

    // Si falla con v2c, intentar v1
    if (!$descripciones) {
        $descripciones = @snmprealwalk(
            $ip,
            SNMP_COMMUNITY,
            OID_SUPPLY_DESC,
            SNMP_TIMEOUT,
            SNMP_RETRIES
        );
    }

    if (!$descripciones || !is_array($descripciones)) {
        return $consumibles;
    }

    foreach ($descripciones as $oid => $valor) {
        // Extraer el índice del OID (último número después del último punto)
        if (preg_match('/\.(\d+)$/', $oid, $matches)) {
            $indice = intval($matches[1]);

            // Limpiar descripción
            $descripcion = trim($valor);
            $descripcion = preg_replace('/^STRING:\s*/', '', $descripcion);
            $descripcion = trim($descripcion, '"');

            // Solo agregar si tiene una descripción válida
            if (!empty($descripcion) && strlen($descripcion) > 0) {
                $consumibles[$indice] = [
                    'descripcion' => $descripcion,
                    'indice' => $indice
                ];
            }
        }
    }

    return $consumibles;
}

/**
 * Clasifica un consumible por su descripción
 */
function clasificarConsumible($descripcion) {
    $desc_lower = strtolower($descripcion);

    // Patrones para Toner
    $patrones_toner = ['toner', 'black cartridge', 'negro', 'black toner', 'bk'];
    foreach ($patrones_toner as $patron) {
        if (strpos($desc_lower, $patron) !== false) {
            return 'toner';
        }
    }

    // Patrones para Kit de Mantenimiento
    $patrones_kit = ['maintenance', 'mantenimiento', 'fuser', 'transfer', 'waste'];
    foreach ($patrones_kit as $patron) {
        if (strpos($desc_lower, $patron) !== false) {
            return 'kit_mantenimiento';
        }
    }

    // Patrones para Unidad de Imagen
    $patrones_unidad = ['drum', 'imagen', 'imaging', 'photoconductor', 'pc unit'];
    foreach ($patrones_unidad as $patron) {
        if (strpos($desc_lower, $patron) !== false) {
            return 'unidad_imagen';
        }
    }

    return null; // No clasificado
}

/**
 * Consulta todos los consumibles de una impresora con descubrimiento dinámico
 */
function consultarConsumiblesDirecto($ip) {
    $resultado = [
        'ip' => $ip,
        'conectada' => false,
        'fabricante' => 'unknown',
        'modelo' => '',
        'toner' => null,
        'kit_mantenimiento' => null,
        'unidad_imagen' => null,
        'error' => null,
        'consumibles_encontrados' => 0,
        'detalles' => []
    ];

    // Verificar conectividad
    $sysDescr = snmpGetValue($ip, OID_SYS_DESCR);

    if ($sysDescr === null) {
        $resultado['error'] = 'No se pudo conectar via SNMP';
        return $resultado;
    }

    $resultado['conectada'] = true;
    $resultado['modelo'] = $sysDescr;

    // Detectar fabricante
    $desc_lower = strtolower($sysDescr);
    if (strpos($desc_lower, 'lexmark') !== false) {
        $resultado['fabricante'] = 'Lexmark';
    } elseif (strpos($desc_lower, 'kyocera') !== false) {
        $resultado['fabricante'] = 'Kyocera';
    } elseif (strpos($desc_lower, 'hp') !== false || strpos($desc_lower, 'hewlett') !== false) {
        $resultado['fabricante'] = 'HP';
    } elseif (strpos($desc_lower, 'ricoh') !== false) {
        $resultado['fabricante'] = 'Ricoh';
    } elseif (strpos($desc_lower, 'canon') !== false) {
        $resultado['fabricante'] = 'Canon';
    } elseif (strpos($desc_lower, 'brother') !== false) {
        $resultado['fabricante'] = 'Brother';
    } elseif (strpos($desc_lower, 'epson') !== false) {
        $resultado['fabricante'] = 'Epson';
    } else {
        $resultado['fabricante'] = 'Generic';
    }

    // DESCUBRIMIENTO DINÁMICO: buscar todos los consumibles
    $consumibles = descubrirConsumibles($ip);

    if (empty($consumibles)) {
        $resultado['error'] = 'No se encontraron consumibles SNMP';
        return $resultado;
    }

    $resultado['consumibles_encontrados'] = count($consumibles);

    // Consultar cada consumible encontrado
    foreach ($consumibles as $indice => $info) {
        $max_capacity = snmpGetValue($ip, OID_SUPPLY_MAX . ".$indice");
        $current_level = snmpGetValue($ip, OID_SUPPLY_CURRENT . ".$indice");

        $detalle = [
            'indice' => $indice,
            'descripcion' => $info['descripcion'],
            'capacidad_maxima' => $max_capacity,
            'nivel_actual' => $current_level,
            'porcentaje' => null,
            'tipo' => null
        ];

        // Calcular porcentaje si tenemos datos válidos
        if ($max_capacity !== null && $current_level !== null &&
            is_numeric($max_capacity) && is_numeric($current_level) &&
            intval($max_capacity) > 0) {

            $max = intval($max_capacity);
            $current = intval($current_level);

            $porcentaje = round(($current / $max) * 100);
            $porcentaje = max(0, min(100, $porcentaje)); // Limitar 0-100

            $detalle['porcentaje'] = $porcentaje;

            // Clasificar el consumible
            $tipo = clasificarConsumible($info['descripcion']);
            $detalle['tipo'] = $tipo;

            // Asignar al resultado principal (solo si no está ya asignado)
            if ($tipo === 'toner' && $resultado['toner'] === null) {
                $resultado['toner'] = $porcentaje;
            }
            elseif ($tipo === 'kit_mantenimiento' && $resultado['kit_mantenimiento'] === null) {
                $resultado['kit_mantenimiento'] = $porcentaje;
            }
            elseif ($tipo === 'unidad_imagen' && $resultado['unidad_imagen'] === null) {
                $resultado['unidad_imagen'] = $porcentaje;
            }
        }

        $resultado['detalles'][] = $detalle;
    }

    // Verificar si se obtuvo al menos un valor
    if ($resultado['toner'] === null &&
        $resultado['kit_mantenimiento'] === null &&
        $resultado['unidad_imagen'] === null) {
        $resultado['error'] = 'No se pudieron calcular niveles de suministros';
    }

    return $resultado;
}

/**
 * Actualiza los niveles en la base de datos
 */
function actualizarNivelesBD($id, $toner, $kit, $unidad) {
    $mysqli = conectar();
    $now = date('Y-m-d H:i:s');

    $sql = "UPDATE ubicacion_equipos 
            SET nivel_toner = ?, 
                nivel_kit_mantenimiento = ?, 
                nivel_unidad_imagen = ?,
                ultima_lectura_suministros = ?
            WHERE id_ubicacion_equipos = ?";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Error preparando UPDATE: " . $mysqli->error);
        $mysqli->close();
        return false;
    }

    $stmt->bind_param('iiisi', $toner, $kit, $unidad, $now, $id);
    $success = $stmt->execute();

    $stmt->close();
    $mysqli->close();

    return $success;
}

// ====== EJECUCIÓN PRINCIPAL ======

$inicio = microtime(true);

$mysqli = conectar();

// Obtener solo impresoras (id_categoria = 5) que están conectadas
$sql = "SELECT id_ubicacion_equipos, ip_ubicacion_equipos 
        FROM ubicacion_equipos 
        WHERE id_categoria = 5 
        AND ip_ubicacion_equipos IS NOT NULL 
        AND ip_ubicacion_equipos != '' 
        AND ip_ubicacion_equipos != '-'
        AND estado_conexion = 1
        ORDER BY ip_ubicacion_equipos";

$result = $mysqli->query($sql);

if (!$result) {
    echo json_encode([
        'ok' => false,
        'error' => 'Error en consulta DB: ' . $mysqli->error
    ]);
    exit;
}

$impresoras = $result->fetch_all(MYSQLI_ASSOC);
$mysqli->close();

$resultados = [];
$actualizadas = 0;
$errores = 0;
$no_conectadas = 0;

foreach ($impresoras as $impresora) {
    // Límite de tiempo por impresora
    set_time_limit(MAX_TIME_PER_PRINTER);

    $id = intval($impresora['id_ubicacion_equipos']);
    $ip = trim($impresora['ip_ubicacion_equipos']);

    // Validar IP
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $resultados[] = [
            'id' => $id,
            'ip' => $ip,
            'error' => 'IP inválida',
            'actualizado' => false
        ];
        $errores++;
        continue;
    }

    // Consultar impresora via SNMP
    $info = consultarConsumiblesDirecto($ip);

    $resultado_item = [
        'id' => $id,
        'ip' => $ip,
        'conectada' => $info['conectada'],
        'fabricante' => $info['fabricante'],
        'modelo' => substr($info['modelo'], 0, 100), // Limitar longitud
        'toner' => $info['toner'],
        'kit_mantenimiento' => $info['kit_mantenimiento'],
        'unidad_imagen' => $info['unidad_imagen'],
        'consumibles_encontrados' => $info['consumibles_encontrados'],
        'error' => $info['error'],
        'actualizado' => false
    ];

    // Si conectó y obtuvo al menos un valor, actualizar BD
    if ($info['conectada'] &&
        ($info['toner'] !== null ||
            $info['kit_mantenimiento'] !== null ||
            $info['unidad_imagen'] !== null)) {

        $success = actualizarNivelesBD(
            $id,
            $info['toner'],
            $info['kit_mantenimiento'],
            $info['unidad_imagen']
        );

        if ($success) {
            $resultado_item['actualizado'] = true;
            $actualizadas++;
        } else {
            $resultado_item['error'] = ($resultado_item['error'] ?? '') . ' Error actualizando BD';
            $errores++;
        }
    } else {
        if (!$info['conectada']) {
            $no_conectadas++;
        } else {
            $errores++;
        }
    }

    $resultados[] = $resultado_item;
}

$tiempo_total = round(microtime(true) - $inicio, 2);

// Respuesta final
echo json_encode([
    'ok' => true,
    'timestamp' => date('Y-m-d H:i:s'),
    'tiempo_ejecucion' => $tiempo_total . 's',
    'resumen' => [
        'total_impresoras' => count($impresoras),
        'actualizadas' => $actualizadas,
        'no_conectadas' => $no_conectadas,
        'errores' => $errores
    ],
    'detalles' => $resultados
]);
exit;
?>
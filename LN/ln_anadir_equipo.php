<?php
// ===== ln_anadir_equipo.php CORREGIDO =====
session_start();
header('Content-Type: application/json');

// Incluir archivo de acceso a datos
include_once '../AD/ad.php';

// Categorías que requieren validación de IP/MAC
define('CATEGORIAS_REQUIEREN_NETWORK', [1, 4, 5]); // CPU, Laptop, Impresora

function categoriaRequiereNetwork($id_categoria) {
    return in_array((int)$id_categoria, CATEGORIAS_REQUIEREN_NETWORK);
}

try {
    // Verificar que sea POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Recibir y validar datos
    $ip = trim($_POST['ip_ubicacion_equipos'] ?? '');
    $mac = trim($_POST['mac_ubicacion_equipos'] ?? '');
    $id_categoria = intval($_POST['id_categoria'] ?? 0);
    $id_bien = intval($_POST['id_bien'] ?? 0);
    $id_persona = intval($_POST['id_persona'] ?? 0);
    $id_area = intval($_POST['id_area'] ?? 0);
    $estado_conexion = intval($_POST['estado_conexion'] ?? 1);
    $ultima_deteccion = $_POST['ultima_deteccion'] ?? null;
    $piso = intval($_POST['piso'] ?? 1);
    $pos_x = intval($_POST['pos_x'] ?? 100);
    $pos_y = intval($_POST['pos_y'] ?? 100);

    // Validaciones básicas
    $errores = [];

    if ($id_categoria <= 0) {
        $errores[] = "Debe seleccionar una categoría válida";
    }

    // CAMBIO PRINCIPAL: Validaciones condicionales solo para categorías específicas
    if (categoriaRequiereNetwork($id_categoria)) {
        // Para CPU, Laptop, Impresora: IP y MAC son obligatorias y deben ser válidas
        if (empty($ip)) {
            $errores[] = "La IP es requerida para esta categoría";
        } elseif (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $errores[] = "La IP no tiene un formato válido";
        }

        if (empty($mac)) {
            $errores[] = "La MAC es requerida para esta categoría";
        } elseif (!preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $mac)) {
            $errores[] = "La MAC no tiene un formato válido (ejemplo: AA:BB:CC:DD:EE:FF)";
        }
    } else {
        // Para otras categorías: establecer valores por defecto si están vacíos
        if (empty($ip) || trim($ip) === '') {
            $ip = '-';
        }
        if (empty($mac) || trim($mac) === '') {
            $mac = '-';
        }

        // Si se proporcionaron valores, validar formato (aunque no sean obligatorios)
        if ($ip !== '-' && !filter_var($ip, FILTER_VALIDATE_IP)) {
            $errores[] = "La IP no tiene un formato válido";
        }
        if ($mac !== '-' && !preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $mac)) {
            $errores[] = "La MAC no tiene un formato válido (ejemplo: AA:BB:CC:DD:EE:FF)";
        }
    }

    if ($piso < 1 || $piso > 3) {
        $errores[] = "El piso debe ser entre 1 y 3";
    }

    if ($pos_x < 0 || $pos_x > 5000 || $pos_y < 0 || $pos_y > 5000) {
        $errores[] = "Las coordenadas deben estar entre 0 y 5000";
    }

    // Si hay errores, retornar
    if (!empty($errores)) {
        echo json_encode([
            'success' => false,
            'message' => implode(', ', $errores)
        ]);
        exit;
    }

    // Convertir fecha si existe
    if (!empty($ultima_deteccion)) {
        $ultima_deteccion = date('Y-m-d H:i:s', strtotime($ultima_deteccion));
    } else {
        $ultima_deteccion = null;
    }

    // Si no se seleccionó bien, ponerlo como NULL
    $id_bien = ($id_bien > 0) ? $id_bien : null;
    $id_persona = ($id_persona > 0) ? $id_persona : null;
    $id_area = ($id_area > 0) ? $id_area : null;

    // Normalizar MAC solo si no es el valor por defecto
    if ($mac !== '-') {
        $mac = strtoupper(str_replace('-', ':', $mac));
    }

    // CORRECCIÓN: Pasar id_categoria como parámetro
    $resultado = insertarUbicacionEquipo(
        $ip,
        $mac,
        $id_categoria, // AGREGADO: pasar la categoría
        $id_bien,
        $id_persona,
        $id_area,
        $estado_conexion,
        $ultima_deteccion,
        $piso,
        $pos_x,
        $pos_y
    );

    if ($resultado['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Equipo agregado correctamente',
            'id_nuevo' => $resultado['id']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $resultado['message'],
            'type' => 'duplicate'
        ]);
    }

} catch (Exception $e) {
    error_log("Error en ln_anadir_equipo.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor: ' . $e->getMessage(),
        'type' => 'system'
    ]);
}
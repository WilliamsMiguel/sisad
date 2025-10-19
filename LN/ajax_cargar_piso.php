<?php
// Archivo: ajax_cargar_piso.php
session_start();

// Incluir archivo de acceso a datos
include_once '../AD/ad.php';

// Establecer header para respuesta JSON
header('Content-Type: application/json; charset=utf-8');

/**
 * Valida el método HTTP de la petición
 */
function validarMetodoHTTP() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido. Solo se acepta POST.',
            'equipos' => []
        ]);
        exit;
    }
}

/**
 * Valida y obtiene el piso solicitado
 */
function validarPiso() {
    if (!isset($_POST['piso'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'No se especificó el piso a cargar.',
            'equipos' => []
        ]);
        exit;
    }

    $piso = (int)$_POST['piso'];

    if (!in_array($piso, [1, 2, 3])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Piso inválido. Debe ser 1, 2 o 3.',
            'equipos' => []
        ]);
        exit;
    }

    return $piso;
}

/**
 * Carga los equipos del piso especificado
 */
function cargarEquiposPiso($piso) {
    try {
        // Registrar solicitud de carga
        registrarLogCoordenadas(
            'CARGA_PISO',
            "Solicitando equipos del piso {$piso}"
        );

        // Obtener equipos del piso
        $result = obtenerEquiposConUbicacionPorPiso($piso);

        $equipos = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $equipos[] = $row;
            }
        }

        // Preparar respuesta exitosa
        $response = [
            'success' => true,
            'message' => "Equipos del piso {$piso} cargados correctamente.",
            'equipos' => $equipos,
            'data' => [
                'piso' => $piso,
                'total_equipos' => count($equipos),
                'equipos_conectados' => count(array_filter($equipos, function($e) {
                    return $e['estado_conexion'] == '1';
                })),
                'equipos_desconectados' => count(array_filter($equipos, function($e) {
                    return $e['estado_conexion'] == '0';
                })),
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ];

        // Registrar éxito
        registrarLogCoordenadas(
            'CARGA_PISO_EXITOSA',
            "Piso {$piso}: {$response['data']['total_equipos']} equipos cargados. " .
            "Conectados: {$response['data']['equipos_conectados']}, " .
            "Desconectados: {$response['data']['equipos_desconectados']}"
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        // Registrar error
        registrarLogCoordenadas(
            'ERROR_CARGA_PISO',
            "Piso {$piso}: " . $e->getMessage(),
            'ERROR'
        );

        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error interno al cargar equipos del piso.',
            'equipos' => [],
            'error_details' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
}

/**
 * Obtiene estadísticas adicionales del piso (opcional)
 */
function obtenerEstadisticasAdicionales($piso) {
    try {
        $estadisticas = obtenerEstadisticasEquiposPorPiso();
        return $estadisticas[$piso] ?? [
            'total_equipos' => 0,
            'equipos_conectados' => 0,
            'equipos_desconectados' => 0
        ];
    } catch (Exception $e) {
        return [
            'total_equipos' => 0,
            'equipos_conectados' => 0,
            'equipos_desconectados' => 0
        ];
    }
}

// ===== FLUJO PRINCIPAL =====

try {
    // Validar método HTTP
    validarMetodoHTTP();

    // Validar y obtener piso
    $piso = validarPiso();

    // Cargar equipos del piso
    cargarEquiposPiso($piso);

} catch (Throwable $e) {
    // Capturar cualquier error fatal
    registrarLogCoordenadas(
        'ERROR_FATAL_CARGA',
        "Error fatal en carga de piso: " . $e->getMessage(),
        'FATAL'
    );

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error crítico al cargar el piso.',
        'equipos' => []
    ], JSON_UNESCAPED_UNICODE);
}

?>

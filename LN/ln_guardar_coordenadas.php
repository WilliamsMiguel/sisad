<?php
session_start();

// Incluir archivo de acceso a datos
include_once '../AD/ad.php';

// Establecer header para respuesta JSON
header('Content-Type: application/json');

/**
 * Valida el método HTTP de la petición
 */
function validarMetodoHTTP() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido. Solo se acepta POST.'
        ]);
        exit;
    }
}

/**
 * Valida los datos recibidos en la petición
 */
function validarDatosRecibidos() {
    if (!isset($_POST['coordinates'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'No se recibieron coordenadas en la petición'
        ]);
        exit;
    }

    return $_POST['coordinates'];
}

/**
 * Decodifica y valida el JSON de coordenadas
 */
function decodificarCoordenadas($coordinatesJson) {
    $coordinates = json_decode($coordinatesJson, true);

    if ($coordinates === null) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'JSON de coordenadas inválido. Verifique el formato.'
        ]);
        exit;
    }

    return $coordinates;
}

/**
 * Procesa las coordenadas y las guarda en la base de datos
 */
function procesarCoordenadas($coordinates) {
    try {
        // Llamar función del AD para actualizar múltiples coordenadas
        $resultado = actualizarMultiplesCoordenadas($coordinates);

        // Preparar respuesta según el resultado
        if ($resultado['success']) {
            $response = [
                'success' => true,
                'message' => $resultado['message'],
                'updated_count' => $resultado['updated_count']
            ];

            // Agregar warnings si hay errores parciales
            if (!empty($resultado['errors'])) {
                $response['warnings'] = $resultado['errors'];
            }

            // Log para auditoría (opcional)
            logDebugCoordenadas("Coordenadas actualizadas - Count: {$resultado['updated_count']}, Errores: " . count($resultado['errors']));

        } else {
            http_response_code(400);
            $response = [
                'success' => false,
                'message' => $resultado['message'],
                'errors' => $resultado['errors']
            ];
        }

        echo json_encode($response);

    } catch (Exception $e) {
        // Log del error para debugging
        error_log("Error en ln_guardar_coordenadas.php: " . $e->getMessage());

        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error interno del servidor'
        ]);
    }
}

// ===== FLUJO PRINCIPAL =====

// Validar método HTTP
validarMetodoHTTP();

// Validar datos recibidos
$coordinatesJson = validarDatosRecibidos();

// Decodificar coordenadas
$coordinates = decodificarCoordenadas($coordinatesJson);

// Procesar coordenadas
procesarCoordenadas($coordinates);
?>
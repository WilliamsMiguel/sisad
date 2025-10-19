<?php
// Archivo: ../LN/ln_validar_duplicados.php
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

    // Recibir datos
    $ip = trim($_POST['ip'] ?? '');
    $mac = trim($_POST['mac'] ?? '');
    $id_bien = intval($_POST['id_bien'] ?? 0);
    $id_categoria = intval($_POST['id_categoria'] ?? 0);
    $excluir_id = intval($_POST['excluir_id'] ?? 0);

    // Si no se proporciona un bien válido, ponerlo como null
    $id_bien = ($id_bien > 0) ? $id_bien : null;
    $excluir_id = ($excluir_id > 0) ? $excluir_id : null;

    // CAMBIO PRINCIPAL: Si la categoría no requiere network, skip validación completamente
    if ($id_categoria > 0 && !categoriaRequiereNetwork($id_categoria)) {
        echo json_encode([
            'success' => true,
            'message' => 'Validación omitida para esta categoría',
            'type' => 'conditional_skip'
        ]);
        exit;
    }

    // Si no se proporcionó categoría pero se están validando campos, asumir que sí requiere validación
    if ($id_categoria == 0 && (empty($ip) && empty($mac))) {
        echo json_encode([
            'success' => true,
            'message' => 'Sin datos para validar',
            'type' => 'no_data'
        ]);
        exit;
    }

    // Normalizar MAC si se proporciona
    if (!empty($mac)) {
        $mac = strtoupper(str_replace('-', ':', $mac));
    }

    // Validar formato básico antes de verificar duplicados (solo si los campos no están vacíos)
    $errores_formato = [];

    if (!empty($ip) && $ip !== '-' && !filter_var($ip, FILTER_VALIDATE_IP)) {
        $errores_formato[] = "Formato de IP inválido";
    }

    if (!empty($mac) && $mac !== '-' && !preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $mac)) {
        $errores_formato[] = "Formato de MAC inválido";
    }

    // Si hay errores de formato, retornar sin verificar duplicados
    if (!empty($errores_formato)) {
        echo json_encode([
            'success' => false,
            'errors' => $errores_formato,
            'type' => 'format'
        ]);
        exit;
    }

    // CAMBIO: Solo realizar validación de duplicados si es una categoría que requiere network
    // y los valores no son por defecto
    if (($id_categoria == 0 || categoriaRequiereNetwork($id_categoria)) &&
        (($ip && $ip !== '-') || ($mac && $mac !== '-'))) {

        $resultado = validarDuplicadosAjax($ip, $mac, $id_bien, $excluir_id);
        echo json_encode($resultado);
    } else {
        // Para categorías que no requieren network o valores por defecto
        echo json_encode([
            'success' => true,
            'message' => 'Validación no requerida',
            'type' => 'skip'
        ]);
    }

} catch (Exception $e) {
    error_log("Error en ln_validar_duplicados.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor',
        'type' => 'system'
    ]);
}
?>
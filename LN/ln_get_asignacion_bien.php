<?php
include '../AD/ad.php';
header('Content-Type: application/json');

if (!isset($_GET['id_bien'])) {
    echo json_encode(['success' => false, 'message' => 'ID de bien no proporcionado']);
    exit;
}

$id_bien = intval($_GET['id_bien']);

// Llamada a la función en AD
$info = obtener_asignacion_bien($id_bien);

if ($info) {
    echo json_encode([
        'success' => true,
        'transferente' => $info['transferente'],
        'receptor' => $info['receptor'],
        'dependencia_transferente' => $info['dependencia_transferente'],
        'dependencia_receptora' => $info['dependencia_receptora'],
        'area_transferente' => $info['area_transferente'],
        'area_receptora' => $info['area_receptora'],
        'fecha_movimiento' => $info['fecha_movimiento'],
        'archivo_movimiento' => $info['archivo_movimiento']
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>


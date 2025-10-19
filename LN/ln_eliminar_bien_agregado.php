<?php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bien = $_POST['id_bien'] ?? null;

    if ($id_bien) {
        $resultado = eliminarBienPorId($id_bien);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al eliminar el bien']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de bien no proporcionado']);
    }
}

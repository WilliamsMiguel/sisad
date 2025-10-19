<?php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = trim($_POST['des_nombre_bien']);

    if ($descripcion !== '') {
        $resultado = agregar_nombre_bien($descripcion);
        echo json_encode(['success' => $resultado]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Descripción vacía']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>


<?php
require_once '../AD/ad.php';

header('Content-Type: application/json');

if (isset($_POST['id_nombre_bien']) && isset($_POST['des_nombre_bien'])) {
    $id = $_POST['id_nombre_bien'];
    $descripcion = $_POST['des_nombre_bien'];

    $conn = conectar(); // asegúrate de tener esta función

    $stmt = $conn->prepare("UPDATE nombre_bien SET des_nombre_bien = ? WHERE id_nombre_bien = ?");
    $stmt->bind_param("si", $descripcion, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
}



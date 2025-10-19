<?php
require_once '../AD/ad.php';
header('Content-Type: application/json');

if (isset($_POST['tabla']) && isset($_POST['id'])) {
    $tabla = $_POST['tabla'];
    $id = $_POST['id'];

    $id_columna = 'id_' . $tabla;

    $conn = conectar();

    // Seguridad mínima para evitar inyección
    $tablasPermitidas = ['nombre_bien']; // Agrega más si deseas reutilizarlo
    if (!in_array($tabla, $tablasPermitidas)) {
        echo json_encode(['success' => false, 'message' => 'Tabla no permitida.']);
        exit;
    }

    $query = "DELETE FROM $tabla WHERE $id_columna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}


<?php
require_once("../AD/ad.php");
// Establecer zona horaria de Lima
date_default_timezone_set('America/Lima');

function obtener_archivo_movimiento($id_movimiento) {
    $conn = conectar();
    $stmt = $conn->prepare("SELECT archivo_movimiento FROM movimiento WHERE id_movimiento = ?");
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();
    $stmt->bind_result($archivo_movimiento);
    $stmt->fetch();
    $stmt->close();
    return $archivo_movimiento;
}

$id_movimiento = $_POST['id_movimiento'];
$id_transferente = $_POST['id_transferente_movimiento'];
$id_receptor = $_POST['id_receptor_movimiento'];
$id_dep_trans = $_POST['id_dependencia_transferente_movimiento'];
$id_dep_recep = $_POST['id_dependencia_receptor_movimiento'];
$id_area_trans = $_POST['id_area_transferente_movimiento'];
$id_area_recep = $_POST['id_area_receptor_movimiento'];
$fecha_movimiento = $_POST['fecha_movimiento'];
$fecha_actual = $_POST['fecha_actual'];
$ids_bienes = $_POST['ids_bienes']; // array
$archivo_movimiento = $_POST['archivo_movimiento']; // nombre ya existente

// Procesar archivo nuevo
$archivo_actual = null;
if (isset($_FILES['archivo_actual']) && $_FILES['archivo_actual']['error'] == 0) {
    $nombre_base = pathinfo($_FILES["archivo_actual"]["name"], PATHINFO_FILENAME);
    $extension = pathinfo($_FILES["archivo_actual"]["name"], PATHINFO_EXTENSION);

    $timestamp = date("d_m_Y_H-i"); // Ejemplo: 06_08_2025_14-25
    $nuevo_nombre = $nombre_base . '_' . $timestamp . '.' . $extension;

    $ruta_destino = "../DOCS_REASIGNACIONES/" . $nuevo_nombre;

    if (move_uploaded_file($_FILES["archivo_actual"]["tmp_name"], $ruta_destino)) {
        $archivo_actual = $nuevo_nombre;
    }
}
$archivo_movimiento = obtener_archivo_movimiento($id_movimiento);


// Llamar a la función
guardar_desvinculacion(
    $id_movimiento,
    $id_transferente,
    $id_receptor,
    $id_dep_trans,
    $id_dep_recep,
    $id_area_trans,
    $id_area_recep,
    $fecha_movimiento,
    $fecha_actual,
    $archivo_movimiento,
    $archivo_actual,
    $ids_bienes
);

echo "ok";



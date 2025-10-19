<?php
// LN/ln_movimiento.php
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transferente = $_POST['id_transferente_movimiento'];
    $id_receptor = $_POST['id_receptor_movimiento'];
    $id_dependencia_transferente = $_POST['id_dependencia_transferente_movimiento'];
    $id_dependencia_receptora = $_POST['id_dependencia_receptor_movimiento'];
    $id_area_transferente = $_POST['id_area_transferente_movimiento'];
    $id_area_receptora = $_POST['id_area_receptor_movimiento'];
    $fecha_movimiento = $_POST['fecha_movimiento'];

    // Subir archivo
    if (isset($_FILES['archivo_movimiento']) && $_FILES['archivo_movimiento']['error'] === UPLOAD_ERR_OK) {
        $archivo_tmp = $_FILES['archivo_movimiento']['tmp_name'];
        $archivo_nombre = basename($_FILES['archivo_movimiento']['name']);
        $ruta_archivo = '../archivos/' . $archivo_nombre;

        if (move_uploaded_file($archivo_tmp, $ruta_archivo)) {
            // Llamar a la función para registrar movimiento en AD
            registrar_movimiento($id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptora, $id_area_transferente, $id_area_receptora, $fecha_movimiento, $ruta_archivo);
            header('Location: movimiento_exito.php');
        } else {
            echo "Error al subir el archivo.";
        }
    }
}

<?php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nueva_contrasena = trim($_POST['nueva_contrasena'] ?? '');

    if ($id_usuario > 0 && !empty($nueva_contrasena)) {
        if (restablecer_contrasena($id_usuario, $nueva_contrasena)) {
            echo "✅ Contraseña actualizada correctamente.";
        } else {
            echo "❌ Error al actualizar la contraseña.";
        }
    } else {
        echo "❌ Datos inválidos.";
    }
}
?>

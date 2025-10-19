<?php

session_start();
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario']);
    $modulos = isset($_POST['modulos']) ? $_POST['modulos'] : [];

    if (asignar_modulos_a_usuario($id_usuario, $modulos,  $_SESSION['id_persona_usuario'])) {
        echo "Módulos actualizados correctamente.";
    } else {
        echo "Error al actualizar módulos.";
    }
} else {
    echo "Solicitud no válida.";
}

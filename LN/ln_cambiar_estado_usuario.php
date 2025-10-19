<?php
session_start();
// LN/ln_cambiar_estado_usuario.php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $estado_usuario = $_POST['estado_usuario'];

    if (cambiar_estado_usuario($id_usuario, $estado_usuario,  $_SESSION['id_persona_usuario'])) {
        echo "Estado actualizado correctamente.";
    } else {
        echo "Error al actualizar estado.";
    }
}


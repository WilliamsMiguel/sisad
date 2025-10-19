<?php
// LN/ln_actualizar_estadoListaR.php

include_once '../AD/ad.php'; // Incluye el acceso a datos

// Procesar la solicitud de cambio de estado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tabla = $_POST['tabla'];
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    // Llamar a la función de AD para cambiar el estado
    $resultado = cambiar_estado_registro($tabla, $estado, $id);

    echo $resultado;
}
?>

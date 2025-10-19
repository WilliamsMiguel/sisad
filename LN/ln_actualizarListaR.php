<?php
// LN/ln_actualizarListaR.php

include_once '../AD/ad.php'; // Incluye el acceso a datos

// Procesar la solicitud de actualización de un campo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tabla = $_POST['tabla'];
    $id = $_POST['id'];
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];

echo $id;
echo $campo;
echo $tabla;
echo $valor;

    // Llamar a la función de AD para actualizar el registro
    $resultado = actualizar_registro($tabla, $campo, $valor, $id);

    echo $resultado;
}
?>

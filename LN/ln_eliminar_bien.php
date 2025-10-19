<?php
include '../AD/ad.php';

$id_bien = $_POST['bienID'];
$id_movimiento = $_POST['id_movimiento'];

// Llamar a la función para eliminar el bien del detalle del movimiento
eliminar_bien_detalle($id_bien, $id_movimiento);
?>

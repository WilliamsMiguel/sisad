<?php
include '../AD/ad.php';

$id_bien = $_POST['id_bien'];
$id_movimiento = $_POST['id_movimiento'];

registrar_detalle_movimiento($id_movimiento, $id_bien);
?>

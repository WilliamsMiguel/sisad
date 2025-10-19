<?php
// ln_eliminar_movimiento.php
include '../AD/ad.php';

$id_movimiento = $_POST['idMovimiento'];

// Llamada a la capa AD para eliminar el movimiento y sus detalles
$eliminado = eliminar_movimiento($id_movimiento);

if ($eliminado) {
    echo 'success';
} else {
    echo 'error';
}
?>
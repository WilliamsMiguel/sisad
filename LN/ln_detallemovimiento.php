<?php
// ln_detallemovimiento.php
include '../AD/ad.php';

// Verificar si se ha pasado el ID del movimiento
$id_movimientoDetalle = isset($_POST['id_movimientoDetalle']) ? intval($_POST['id_movimientoDetalle']) : 0;

if ($id_movimientoDetalle > 0) {
    // Obtener los detalles del movimiento desde la base de datos
    $detalles = obtener_detalle_movimiento($id_movimientoDetalle);

    // Generar la salida para el detalle
    $output = '';
    foreach ($detalles as $detalle) {
        $output .= '<li class="list-group-item">';
        $output .= '-: ' . htmlspecialchars($detalle['des_nombre_bien']).' '.htmlspecialchars($detalle['marca_bien']).' '.htmlspecialchars($detalle['numdeserie_bien']).' '.htmlspecialchars($detalle['numcontropatri_bien']).' '.htmlspecialchars($detalle['numdeordendecom_bien']).'  S/'.htmlspecialchars($detalle['costo_bien']);
        $output .= '</li>';
    }

    echo $output;
} else {
    echo 'No se encontró el detalle del movimiento.';
}
?>

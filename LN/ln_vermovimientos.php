<?php
// ln_vermovimientos.php
require_once '../AD/ad.php';

// Verificar la cantidad de filas a mostrar
$cantidadActualVer = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 5;

// Obtener los movimientos desde la base de datos 
//$movimientosActualVer = obtener_ultimos_movimientos($cantidadActualVer);
$movimientosActualVer = obtener_ultimos_movimientosX();
$movimientosHistorial = obtenerHistorialMovimientos();

?>

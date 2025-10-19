<?php
require_once '../AD/ad.php';

$menus = obtener_menus(); // ya devuelve id_menu y descripcion_menu
header('Content-Type: application/json');
echo json_encode($menus);


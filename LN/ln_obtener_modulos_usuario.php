<?php
// LN/ln_obtener_modulos_usuario.php

include '../AD/ad.php';

if (isset($_GET['id_usuario'])) {
    $id_usuario = intval($_GET['id_usuario']);
    $modulos = obtener_modulos_de_usuario($id_usuario);
    echo json_encode($modulos);
} else {
    echo json_encode([]);
}

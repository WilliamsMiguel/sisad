<?php
include_once '../AD/ad.php';

if (isset($_POST['id_categoria'])) {
    $idCategoria = intval($_POST['id_categoria']);
    $bienes = obtenerBienesPorCategoria($idCategoria);
    echo json_encode($bienes);
} else {
    echo json_encode([]);
}


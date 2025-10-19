<?php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_bien'])) {
    $id = $_POST['id_bien'];
    $bien = obtenerBienPorId($id);
    echo json_encode($bien);
}

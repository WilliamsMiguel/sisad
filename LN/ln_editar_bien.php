<?php
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si solo llega el id_bien, significa que es para obtener datos
    if (isset($_POST['id_bien']) && count($_POST) === 1) {
        $id_bien = $_POST['id_bien'];
        $bien = obtenerBienPorId($id_bien);
        echo json_encode($bien);
        exit;
    }

    // Si llegan más datos, es una solicitud para actualizar
    $datos = [
        'id_bien' => $_POST['id_bien'] ?? null,
        'equipo_bien' => $_POST['equipo_bien'] ?? '',
        'marca_bien' => $_POST['marca_bien'] ?? '',
        'modelo_bien' => $_POST['modelo_bien'] ?? '',
        'procesador_bien' => $_POST['procesador_bien'] ?? '',
        'numdeserie_bien' => $_POST['numdeserie_bien'] ?? '',
        'numcontropatri_bien' => $_POST['numcontropatri_bien'] ?? '',
        'estado_bien' => $_POST['estado_bien'] ?? '',
        'añodeadqs_bien' => $_POST['añodeadqs_bien'] ?? '',
        'numdeordendecom_bien' => $_POST['numdeordendecom_bien'] ?? '',
        'observacion_bien' => $_POST['observacion_bien'] ?? '',
        'color_bien' => $_POST['color_bien'] ?? '', // 🔹 Nuevo campo agregado
        'costo_bien' => $_POST['costo_bien'] ?? '',
        'funcionamiento' => $_POST['funcionamiento'] ?? '',
        'pcasignada' => $_POST['pcasignada'] ?? null, // 🔹 nuevo campo
        'piso_bien' => $_POST['piso_bien'] ?? '',  // ← Agregar esta línea
    ];

    $resultado = actualizarBien($datos);

    if ($resultado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el bien']);
    }
}

<?php
include '../AD/ad.php';

// Asegúrate de que el método sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar la entrada
    $id_movimiento = isset($_POST['id_movimientoEdi']) ? intval($_POST['id_movimientoEdi']) : 0;
    
    if (isset($_POST['bienes']) && is_array($_POST['bienes'])) {
        $bienesAgregados = $_POST['bienes'];

        // Insertar los bienes en la base de datos
        foreach ($bienesAgregados as $bien) {
            // Asegúrate de que $bien sea un entero
            $bienId = intval($bien);
            registrar_detalle_movimiento($id_movimiento, $bienId);
        }

        echo 'success';
    } else {
        echo 'error: No se recibieron bienes.';
    }
} else {
    echo 'error: Método no permitido.';
}
?>

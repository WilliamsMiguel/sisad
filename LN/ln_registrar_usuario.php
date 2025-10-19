<?php
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Verificar si cada campo fue llenado antes de intentar registrarlo
    $id_persona_usuario = !empty($_POST['id_persona']) ? $_POST['id_persona'] : null;
    $nombre_usuario = !empty($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : null;
    $clave_usuario = !empty($_POST['clave_usuario']) ? $_POST['clave_usuario'] : null;
    $estado_usuario = !empty($_POST['estado_usuario']) ? $_POST['estado_usuario'] : null;

    // Validar que todos los campos tengan valores
    if ($id_persona_usuario && $nombre_usuario && $clave_usuario && $estado_usuario) {
        // Registrar usuario en la base de datos
        $resultado = registrar_usuario($id_persona_usuario, $nombre_usuario, $clave_usuario, $estado_usuario);
        
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario registrado exitosamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al registrar el usuario.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, complete todos los campos.']);
    }
}
?>

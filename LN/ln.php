<?php
// LN/ln.php
session_start();
include '../AD/ad.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nombre_u = $_POST['nombre_usuario'];
    $clave_u = md5($_POST['clave_usuario']);

    // Validar credenciales
    $usuario = validar_usuario($nombre_u, $clave_u);

    if ($usuario)
    {
        $_SESSION['usuario'] = $usuario['nombre_usuario'];
        $_SESSION['id_persona_usuario'] = $usuario['id_persona_usuario'];  // Almacena id_id_p_u en la sesión

        header('Location: ../P/principal.php');


    } else {
        // Redirigir a login con mensaje de error
        header('Location: ../index.php?error=1');
    }
    exit();
}

function obtener_datos_personaLN($id_persona_usuario)
{
    return obtener_datos_persona($id_persona_usuario);
}

function listar_menus_activos() 
{
    return obtener_menus();
}


?>

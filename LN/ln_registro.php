<?php
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Verificar si cada campo fue llenado antes de intentar registrarlo
    $descripcion_area = !empty($_POST['descripcion_area']) ? $_POST['descripcion_area'] : null;
    $descripcion_depen = !empty($_POST['descripcion_dependencia']) ? $_POST['descripcion_dependencia'] : null;

    $equipo_bien = !empty($_POST['equipo_bien']) ? $_POST['equipo_bien'] : null;
    $marca_bien = !empty($_POST['marca_bien']) ? $_POST['marca_bien'] : null;
    $modelo_bien = !empty($_POST['modelo_bien']) ? $_POST['modelo_bien'] : null;
    $procesador_bien = !empty($_POST['procesador_bien']) ? $_POST['procesador_bien'] : null;

    $serie_bien = !empty($_POST['numdeserie_bien']) ? $_POST['numdeserie_bien'] : null;
    $cp_bien = !empty($_POST['numcontropatri_bien']) ? $_POST['numcontropatri_bien'] : null;
    $estado_bien = !empty($_POST['estado_bien']) ? $_POST['estado_bien'] : null;
    $añodeadqs_bien = !empty($_POST['añodeadqs_bien']) ? $_POST['añodeadqs_bien'] : null;
    $numdeordendecom_bien = !empty($_POST['numdeordendecom_bien']) ? $_POST['numdeordendecom_bien'] : null;
    $observacion_bien = !empty($_POST['observacion_bien']) ? $_POST['observacion_bien'] : null;

    $nomyap_p = !empty($_POST['nomyap_persona']) ? $_POST['nomyap_persona'] : null;
    $dni_p = !empty($_POST['dni_persona']) ? $_POST['dni_persona'] : null;
    $cell_persona = !empty($_POST['cell_persona']) ? $_POST['cell_persona'] : null;
    $correo_persona = !empty($_POST['correo_persona']) ? $_POST['correo_persona'] : null;
    $dir_persona = !empty($_POST['dir_persona']) ? $_POST['dir_persona'] : null;

    $descripcion_menu = !empty($_POST['descripcion_menu']) ? $_POST['descripcion_menu'] : null;
    $nombrearchivo_menu = !empty($_POST['nombrearchivo_menu']) ? $_POST['nombrearchivo_menu'] : null;

    $resultado = registrar_datos($descripcion_area, $descripcion_depen, $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien, $numdeserie_bien, $numcontropatri_bien, $estado_bien, $añodeadqs_bien, $numdeordendecom_bien, $observacion_bien, $nomyap_p, $dni_p, $cell_persona, $correo_persona, $dir_persona, $descripcion_menu, $nombrearchivo_menu);

    if ($resultado) 
    {
        echo '<p>Datos registrados exitosamente.</p>';
    } else {
        echo '<p>Error al registrar los datos.</p>';
    }
}
?>

<?php
session_start();
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
    $funcionamiento = !empty($_POST['funcionamiento']) ? $_POST['funcionamiento'] : null;
    $costo_bien = !empty($_POST['costo_bien']) ? $_POST['costo_bien'] : null;
    $añodeadqs_bien = !empty($_POST['añodeadqs_bien']) ? $_POST['añodeadqs_bien'] : null;
    $numdeordendecom_bien = !empty($_POST['numdeordendecom_bien']) ? $_POST['numdeordendecom_bien'] : null;
    $observacion_bien = !empty($_POST['observacion_bien']) ? $_POST['observacion_bien'] : null;
    // Nuevo campo
    $color_bien = !empty($_POST['color_bien']) ? $_POST['color_bien'] : null;
    $piso_bien = !empty($_POST['piso_bien']) ? $_POST['piso_bien'] : null;

    $nomyap_p = !empty($_POST['nomyap_persona']) ? $_POST['nomyap_persona'] : null;
    $dni_p = !empty($_POST['dni_persona']) ? $_POST['dni_persona'] : null;
    $cell_persona = !empty($_POST['cell_persona']) ? $_POST['cell_persona'] : null;
    $correo_persona = !empty($_POST['correo_persona']) ? $_POST['correo_persona'] : null;
    $cargo_persona = !empty($_POST['cargo_persona']) ? $_POST['cargo_persona'] : null;

    $descripcion_menu = !empty($_POST['descripcion_menu']) ? $_POST['descripcion_menu'] : null;

    // NUEVOS CAMPOS
    $organo = !empty($_POST['organo']) ? $_POST['organo'] : null;
    $especialidad = !empty($_POST['especialidad']) ? $_POST['especialidad'] : null;

    $nombrearchivo_menu = null;
    $nombrearchivo_img = null;

    function procesar_archivos($campo, $ruta_destino) {
        $nombres = [];

        if (!isset($_FILES[$campo]['name']) || empty($_FILES[$campo]['name'][0])) {
            return null;
        }

        foreach ($_FILES[$campo]['name'] as $index => $nombre_original) {
            $tmp = $_FILES[$campo]['tmp_name'][$index];
            $nombre_original = basename($nombre_original);
            $ruta_final = $ruta_destino . $nombre_original;

            if (is_uploaded_file($tmp)) {
                move_uploaded_file($tmp, $ruta_final);
                $ruta_relativa = str_replace(__DIR__ . '/../', '', $ruta_destino);
                $nombres[] = $ruta_relativa . $nombre_original;
            }
        }

        return implode(',', $nombres);
    }


    date_default_timezone_set('America/Lima');

    // Procesar archivos con respaldo
    $nombrearchivo_menu = procesar_archivos('nombrearchivo_menu', __DIR__ . '/../P/');
    procesar_archivos('nombrearchivo_ln', __DIR__ . '/../LN/');
    procesar_archivos('nombrearchivo_ad', __DIR__ . '/../AD/');
    procesar_archivos('nombrearchivo_libreria', __DIR__ . '/../libreria/');
    $nombrearchivo_img = procesar_archivos('nombrearchivo_img', __DIR__ . '/../P/img/');



    
    $resultado = registrar_datos(
        $descripcion_area,
        $descripcion_depen,
        $equipo_bien,
        $marca_bien,
        $modelo_bien,
        $procesador_bien,
        $serie_bien,
        $cp_bien,
        $estado_bien,
        $funcionamiento,
        $añodeadqs_bien,
        $numdeordendecom_bien,
        $observacion_bien,
        $color_bien, // Campo agregado aquí
        $piso_bien,
        $costo_bien,
        $nomyap_p,
        $dni_p,
        $cell_persona,
        $correo_persona,
        $cargo_persona,
        $descripcion_menu,
        $nombrearchivo_menu,
        $nombrearchivo_img,
        $organo,
        $especialidad,
        $_SESSION['id_persona_usuario']
    );

    // No pongas etiquetas HTML aquí
    if ($resultado === 'duplicado_menu') {
        echo 'duplicado_menu';
    } elseif ($resultado === 'duplicado_area') {
        echo 'duplicado_area';
    } elseif ($resultado === 'ok') {
        echo 'ok';
    } else {
        echo 'error';
    }
}
?>

<?php 
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'] ?? null;
    $descripcion_menu = $_POST['descripcion_menu'] ?? null;
    $nombrearchivo_menu = null;
    $nombrearchivo_ln = null;
    $nombrearchivo_ad = null;
    $nombrearchivo_img = null;
    $nombrearchivo_js = null;

    if (!$id_menu || !$descripcion_menu) {
        echo "❌ Faltan datos.";
        exit;
    }

    date_default_timezone_set('America/Lima');

    // Si se envía archivo
    if (isset($_FILES['nombrearchivo_menu']) && $_FILES['nombrearchivo_menu']['error'] === 0) {
        $archivo = $_FILES['nombrearchivo_menu'];
        $nombrearchivo_menu = basename($archivo['name']);

        // Rutas principales
        $ruta_origen = "../P/" . $nombrearchivo_menu;
        $ruta_destino = "../P/" . $nombrearchivo_menu;

        // Crear carpeta backup si no existe
        $ruta_backup_folder = "../P/backup_menu/";
        if (!is_dir($ruta_backup_folder)) {
            mkdir($ruta_backup_folder, 0777, true);
        }



        // Si existe el archivo original, guardar respaldo con fecha y hora
        if (file_exists($ruta_origen)) {
            $fecha_hora = date("d-m-Y_H-i");
            $ruta_backup = $ruta_backup_folder . $fecha_hora . "_" . $nombrearchivo_menu;

            if (!copy($ruta_origen, $ruta_backup)) {
                echo "❌ Error al crear backup del archivo.";
                exit;
            }
        }

        // Subir archivo nuevo y reemplazar el original
        if (!move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            echo "❌ Error al subir el archivo.";
            exit;
        }
    }

    // Procesar archivo LN
    if (isset($_FILES['nombrearchivo_ln']) && $_FILES['nombrearchivo_ln']['error'] === 0) {
        $archivo_ln = $_FILES['nombrearchivo_ln'];
        $nombrearchivo_ln = basename($archivo_ln['name']);
        $ruta_origen_ln = "./" . $nombrearchivo_ln;
        $ruta_destino_ln = $ruta_origen_ln;
        $ruta_backup_ln = "./backup_menu/";

        if (!is_dir($ruta_backup_ln)) mkdir($ruta_backup_ln, 0777, true);

        if (file_exists($ruta_origen_ln)) {
            $fecha_hora = date("d-m-Y_H-i");
            $ruta_backup = $ruta_backup_ln . $fecha_hora . "_" . $nombrearchivo_ln;
            if (!copy($ruta_origen_ln, $ruta_backup)) {
                echo "❌ Error al crear backup del archivo LN.";
                exit;
            }
        }

        if (!move_uploaded_file($archivo_ln['tmp_name'], $ruta_destino_ln)) {
            echo "❌ Error al subir el archivo LN.";
            exit;
        }
    }

    // Procesar archivo AD
    if (isset($_FILES['nombrearchivo_ad']) && $_FILES['nombrearchivo_ad']['error'] === 0) {
        $archivo_ad = $_FILES['nombrearchivo_ad'];
        $nombrearchivo_ad = basename($archivo_ad['name']);
        $ruta_origen_ad = "../AD/" . $nombrearchivo_ad;
        $ruta_destino_ad = $ruta_origen_ad;
        $ruta_backup_ad = "../AD/backup_menu/";

        if (!is_dir($ruta_backup_ad)) mkdir($ruta_backup_ad, 0777, true);

        if (file_exists($ruta_origen_ad)) {
            $fecha_hora = date("d-m-Y_H-i");
            $ruta_backup = $ruta_backup_ad . $fecha_hora . "_" . $nombrearchivo_ad;
            if (!copy($ruta_origen_ad, $ruta_backup)) {
                echo "❌ Error al crear backup del archivo AD.";
                exit;
            }
        }

        if (!move_uploaded_file($archivo_ad['tmp_name'], $ruta_destino_ad)) {
            echo "❌ Error al subir el archivo AD.";
            exit;
        }
    }

    // Procesar archivo IMG
    if (isset($_FILES['nombrearchivo_img']) && $_FILES['nombrearchivo_img']['error'] === 0) {
        $archivo_img = $_FILES['nombrearchivo_img'];
        $nombrearchivo_img = basename($archivo_img['name']);
        $ruta_origen_img = "../P/img/" . $nombrearchivo_img;
        $ruta_destino_img = $ruta_origen_img;
        $ruta_backup_img = "../P/img/backup_menu/";

        if (!is_dir($ruta_backup_img)) mkdir($ruta_backup_img, 0777, true);

        if (file_exists($ruta_origen_img)) {
            $fecha_hora = date("d-m-Y_H-i");
            $ruta_backup = $ruta_backup_img . $fecha_hora . "_" . $nombrearchivo_img;
            if (!copy($ruta_origen_img, $ruta_backup)) {
                echo "❌ Error al crear backup del archivo IMG.";
                exit;
            }
        }

        if (!move_uploaded_file($archivo_img['tmp_name'], $ruta_destino_img)) {
            echo "❌ Error al subir el archivo IMG.";
            exit;
        }
    }

    // Procesar archivo JS
    if (isset($_FILES['nombrearchivo_js']) && $_FILES['nombrearchivo_js']['error'] === 0) {
        $archivo_js = $_FILES['nombrearchivo_js'];
        $nombrearchivo_js = basename($archivo_js['name']);

        $ruta_base_js = realpath(__DIR__ . '/../libreria/css-y-js-listarR');
        $ruta_origen_js = $ruta_base_js . DIRECTORY_SEPARATOR . $nombrearchivo_js;
        $ruta_backup_js = $ruta_base_js . DIRECTORY_SEPARATOR . 'backup_menu';

        if (!is_dir($ruta_backup_js)) mkdir($ruta_backup_js, 0777, true);

        if (file_exists($ruta_origen_js)) {
            $fecha_hora = date("d-m-Y_H-i");
            $ruta_backup = $ruta_backup_js . DIRECTORY_SEPARATOR . $fecha_hora . "_" . $nombrearchivo_js;
            if (!copy($ruta_origen_js, $ruta_backup)) {
                echo "❌ Error al crear backup del archivo JS.";
                exit;
            }
        }

        if (!move_uploaded_file($archivo_js['tmp_name'], $ruta_origen_js)) {
            echo "❌ Error al subir el archivo JS.";
            exit;
        }
    }






    // Actualizar base de datos
    $resultado = actualizar_menu($id_menu, $descripcion_menu, $nombrearchivo_menu, $nombrearchivo_img);
    echo $resultado ? "✅ Menú actualizado correctamente." : "❌ Error al actualizar.";
}
?>

<?php
session_start();
require_once '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = isset($_POST['id_menu']) ? intval($_POST['id_menu']) : 0;
    $id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;

    if ($id_menu <= 0) {
        echo '❌ ID inválido.';
        exit;
    }

    if ($id_usuario <= 0) {
        echo '❌ Usuario no autenticado.';
        exit;
    }

    // Verificar si está asignado a algún usuario
    if (menu_asignado_a_usuario($id_menu)) {
        echo '❌ No se puede eliminar: el menú está asignado a un usuario.';
        exit;
    }

    $menu = obtener_menu_por_id($id_menu);
    if (!$menu) {
        echo '❌ Menú no encontrado.';
        exit;
    }

    $archivo_menu = $menu['nombrearchivo_menu'];

    // Eliminar archivo físico
    if (!empty($archivo_menu)) {
        $ruta_archivo = "../" . $archivo_menu;
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
    }

    // Eliminar registro
    $resultado = eliminar_menu($id_menu);

    if ($resultado) {
        // Registrar acción en log
        $detalles = 'Se eliminó el menú: ' . $menu['descripcion_menu'] . ' con archivo ' . $archivo_menu;
        registrarAccion($id_usuario, 'eliminar', 'menu', $id_menu, $detalles);

        echo '✅ Menú eliminado exitosamente.';
    } else {
        echo '❌ Error al eliminar el menú.';
    }
} else {
    echo '❌ Método de solicitud no permitido.';
}

// Lógica de consulta
function obtener_menu_por_id($id_menu) {
    return obtener_menu_bd($id_menu);
}

function eliminar_menu($id_menu) {
    return eliminar_menu_bd($id_menu);
}

function menu_asignado_a_usuario($id_menu) {
    return verificar_menu_asignado_bd($id_menu);
}
?>

<?php
// Archivo: LN/ln_eliminar_equipo.php
session_start();
header('Content-Type: application/json');

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Verificar que se haya enviado el ID del equipo
if (!isset($_POST['id_ubicacion_equipos']) || empty($_POST['id_ubicacion_equipos'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID del equipo es requerido'
    ]);
    exit;
}

try {
    // Incluir archivo de acceso a datos
    include_once '../AD/ad.php';

    $id_ubicacion_equipos = intval($_POST['id_ubicacion_equipos']);

    // Validar que el ID sea válido
    if ($id_ubicacion_equipos <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'ID del equipo inválido'
        ]);
        exit;
    }

    // Verificar que el equipo existe antes de eliminarlo
    $equipoExiste = verificarExistenciaEquipo($id_ubicacion_equipos);

    if (!$equipoExiste) {
        echo json_encode([
            'success' => false,
            'message' => 'El equipo no existe o ya fue eliminado'
        ]);
        exit;
    }

    // Intentar eliminar el equipo
    $resultado = eliminarUbicacionEquipo($id_ubicacion_equipos);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Equipo eliminado correctamente',
            'id_eliminado' => $id_ubicacion_equipos
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al eliminar el equipo de la base de datos'
        ]);
    }

} catch (Exception $e) {
    error_log("Error en ln_eliminar_equipo.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}
?>

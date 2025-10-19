<?php
// Capturar cualquier output no deseado
ob_start();

try {
    require_once '../AD/ad.php';
} catch (Exception $e) {
    ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
}

// Limpiar cualquier output del require
ob_end_clean();

// Solo ahora enviar headers
header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Verificar duplicados
        if (isset($_POST['action']) && $_POST['action'] === 'verificar_duplicado') {
            $id_bien = $_POST['id_bien'] ?? null;
            $nombre = trim($_POST['nombre_pcasignada'] ?? '');

            if (!$id_bien || !$nombre) {
                echo json_encode(['existe' => false]);
                exit;
            }

            $existe = verificarDuplicadoPcasignada($id_bien, $nombre);
            echo json_encode(['existe' => $existe]);
            exit;
        }

        // Registrar nueva PC asignada
        $id_bien = $_POST['id_bien'] ?? null;
        $nombre = trim($_POST['nombre_pcasignada'] ?? '');

        if (!$id_bien || !$nombre) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        if (strlen($nombre) < 15) {
            echo json_encode(['success' => false, 'error' => 'El nombre debe tener mínimo 15 caracteres']);
            exit;
        }

        if (verificarDuplicadoPcasignada($id_bien, $nombre)) {
            echo json_encode(['success' => false, 'error' => 'Este nombre ya está registrado para este bien']);
            exit;
        }

        $resultado = registrarPcasignada($id_bien, $nombre);

        if ($resultado) {
            echo json_encode(['success' => true, 'id' => $resultado, 'nombre' => $nombre]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo registrar']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error interno del servidor']);
}

exit;
?>
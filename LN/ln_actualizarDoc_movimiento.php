<?php
session_start();
include '../AD/ad.php';

header('Content-Type: application/json'); // Encabezado para JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $id_movimientoA = $_POST['id_movimientoA'];
    $id_personaAccionX = $_SESSION['id_persona_usuario'];

    // Procesar archivo PDF
    if (isset($_FILES['archivo_movimiento']) && $_FILES['archivo_movimiento']['error'] == 0)
    {
        $archivo = $_FILES['archivo_movimiento'];
        if ($archivo['type'] == 'application/pdf')
        {
            $nombre_unico = uniqid('mov_', true) . '.pdf';
            $ruta_destino = '../DOCS/' . $nombre_unico;

            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino))
            {
                $ruta_completa = 'DOCS/' . $nombre_unico;

                // Actualizar movimiento con la nueva ruta del archivo
                $resultado = actualizarDoc_movimiento($id_movimientoA, $ruta_completa);

                if ($resultado === "Actualizado correctamente.") {
                    registrarAccion($id_personaAccionX, 'Actualizar', 'movimiento', $id_movimientoA, 'Se ha actualizado el PDF del movimiento.');
                    echo json_encode(['status' => 'success', 'message' => $resultado]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $resultado]);
                }

            }
            else
            {
                echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El archivo debe ser un PDF.']);
        }
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo.']);
    }
}
?>

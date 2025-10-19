<?php
session_start();
// LN/ln_movimiento.php
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transferente = $_POST['id_transferente_movimiento'];
    $id_receptor = $_POST['id_receptor_movimiento'];
    $id_dependencia_transferente = $_POST['id_dependencia_transferente_movimiento'];
    $id_dependencia_receptor = $_POST['id_dependencia_receptor_movimiento'];
    $id_area_transferente = $_POST['id_area_transferente_movimiento'];
    $id_area_receptor = $_POST['id_area_receptor_movimiento'];
    $fecha_movimiento = $_POST['fecha_movimiento'];
    $bienes = $_POST['bienes'];
    $estado_movimiento = isset($_POST['en_tramite']) ? $_POST['en_tramite'] : 0;

    $id_personaAccionX = $_SESSION['id_persona_usuario'];

        if($estado_movimiento==0)
        {
                // Insertar movimiento
                $id_movimiento = registrar_movimiento($id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptor, $id_area_transferente, $id_area_receptor, $fecha_movimiento,"--",$estado_movimiento);
                registrarAccion($id_personaAccionX, 'Insertar', 'movimiento', $id_movimiento, 'Se ha registrado un nuevo movimiento.');

                if ($id_movimiento) 
                {
                    
                    // Insertar detalle de bienes
                    foreach ($bienes as $id_bien) 
                    {
                        registrar_detalle_movimiento($id_movimiento, $id_bien);
                    }
                    echo json_encode(['status' => 'success', 'message' => 'Movimiento registrado correctamente.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al registrar el movimiento.']);
                }

        }
        else
        {

            // Procesar archivo PDF
            if (isset($_FILES['archivo_movimiento']) && $_FILES['archivo_movimiento']['error'] == 0) {
                $archivo = $_FILES['archivo_movimiento'];
                if ($archivo['type'] == 'application/pdf') {
                    $nombre_unico = uniqid('mov_', true) . '.pdf';
                    $ruta_destino = '../DOCS/' . $nombre_unico;

                    if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                        $ruta_completa = 'DOCS/' . $nombre_unico;

                        // Insertar movimiento
                        $id_movimiento = registrar_movimiento($id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptor, $id_area_transferente, $id_area_receptor, $fecha_movimiento, $ruta_completa,1);
                        registrarAccion($id_personaAccionX, 'Insertar', 'movimiento', $id_movimiento, 'Se ha registrado un nuevo movimiento.');

                        if ($id_movimiento) 
                        {
                            
                            // Insertar detalle de bienes
                            foreach ($bienes as $id_bien) 
                            {
                                registrar_detalle_movimiento($id_movimiento, $id_bien);
                            }
                            echo json_encode(['status' => 'success', 'message' => 'Movimiento registrado correctamente.']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Error al registrar el movimiento.']);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo.']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'El archivo debe ser un PDF.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo.']);
            }
        }
}
?>

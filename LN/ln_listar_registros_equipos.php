<?php
/**
 * Archivo: LN/ln_listar_registros_equipos.php
 * Descripción: Lista los registros de equipos con información detallada
 */

session_start();
header('Content-Type: application/json');

// Incluir archivo de acceso a datos
require_once '../AD/ad.php';

try {
    // CORRECCIÓN: Usar la función conectar() en lugar de variable $conexion
    $conexion = conectar();

    if (!$conexion) {
        throw new Exception('Error de conexión: ' . mysqli_connect_error());
    }

    // Verificar que la conexión esté activa
    if (mysqli_ping($conexion) === false) {
        throw new Exception('La conexión a la base de datos se ha perdido');
    }

    // Obtener todos los registros de ubicacion_equipos con información relacionada
    $query = "
        SELECT 
            ue.id_ubicacion_equipos,
            ue.ip_ubicacion_equipos,
            ue.mac_ubicacion_equipos,
            ue.piso,
            ue.estado_conexion,
            ue.ultima_deteccion,
            ue.pos_x,
            ue.pos_y,
            ue.nivel_toner,
            ue.nivel_kit_mantenimiento,
            ue.nivel_unidad_imagen,
            ue.ultima_lectura_suministros,
            
            -- Información de categoría
            nb.id_nombre_bien as id_categoria,
            nb.des_nombre_bien as categoria,
            
            -- Información de bien
            b.id_bien,
            b.marca_bien,
            b.modelo_bien,
            b.numcontropatri_bien,
            
            -- Información de persona
            p.id_persona,
            p.nomyap_persona as persona,
            p.dni_persona,
            
            -- Información de área
            a.id_area,
            a.descripcion_area,
            a.organo
            
        FROM ubicacion_equipos ue
        LEFT JOIN bien b ON ue.id_bien = b.id_bien
        LEFT JOIN nombre_bien nb ON b.equipo_bien = nb.id_nombre_bien
        LEFT JOIN persona p ON ue.id_persona = p.id_persona
        LEFT JOIN area a ON ue.id_area = a.id_area
        ORDER BY ue.piso ASC, ue.ip_ubicacion_equipos ASC
    ";

    $result = mysqli_query($conexion, $query);

    if (!$result) {
        throw new Exception('Error al ejecutar consulta: ' . mysqli_error($conexion));
    }

    $registros = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // Formatear el nombre del bien
        $bienNombre = 'No asignado';
        if ($row['id_bien']) {
            $bienNombre = trim($row['marca_bien'] . ' - ' . $row['modelo_bien']);
            if ($row['numcontropatri_bien']) {
                $bienNombre .= ' (' . $row['numcontropatri_bien'] . ')';
            }
        }

        // Formatear área
        $areaNombre = 'Sin área';
        if ($row['id_area']) {
            $areaNombre = $row['descripcion_area'];
            if ($row['organo']) {
                $areaNombre .= ' - ' . $row['organo'];
            }
        }

        // Formatear persona
        $personaNombre = 'Sin asignar';
        if ($row['id_persona']) {
            $personaNombre = $row['persona'];
            if ($row['dni_persona']) {
                $personaNombre .= ' (DNI: ' . $row['dni_persona'] . ')';
            }
        }

        $registros[] = [
            'id_ubicacion_equipos' => $row['id_ubicacion_equipos'],
            'ip_ubicacion_equipos' => $row['ip_ubicacion_equipos'] ?: 'Sin IP',
            'mac_ubicacion_equipos' => $row['mac_ubicacion_equipos'] ?: 'Sin MAC',
            'piso' => $row['piso'] ?: 'N/A',
            'estado_conexion' => $row['estado_conexion'],
            'ultima_deteccion' => $row['ultima_deteccion'],
            'pos_x' => $row['pos_x'],
            'pos_y' => $row['pos_y'],

            // Información de categoría
            'id_categoria' => $row['id_categoria'],
            'categoria' => $row['categoria'] ?: 'Sin categoría',

            // Información de bien
            'id_bien' => $row['id_bien'],
            'bien' => $bienNombre,
            'marca_bien' => $row['marca_bien'],
            'modelo_bien' => $row['modelo_bien'],
            'numcontropatri_bien' => $row['numcontropatri_bien'],

            // Información de persona
            'id_persona' => $row['id_persona'],
            'persona' => $personaNombre,
            'dni_persona' => $row['dni_persona'],

            // Información de área
            'id_area' => $row['id_area'],
            'area' => $areaNombre,
            'descripcion_area' => $row['descripcion_area'],
            'organo' => $row['organo'],

            // Suministros (para impresoras)
            'nivel_toner' => $row['nivel_toner'],
            'nivel_kit_mantenimiento' => $row['nivel_kit_mantenimiento'],
            'nivel_unidad_imagen' => $row['nivel_unidad_imagen'],
            'ultima_lectura_suministros' => $row['ultima_lectura_suministros']
        ];
    }

    mysqli_free_result($result);
    mysqli_close($conexion); // Cerrar la conexión

    // Registrar en log (opcional)
    error_log("Registros listados: " . count($registros) . " equipos");

    echo json_encode([
        'success' => true,
        'registros' => $registros,
        'total' => count($registros),
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    error_log("Error en ln_listar_registros_equipos.php: " . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'registros' => [],
        'total' => 0
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>
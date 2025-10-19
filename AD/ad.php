<?php
// AD/ad.php
function conectar() {
    $servername = "sql300.infinityfree.com";
    $username = "if0_40201895";
    $password = "KRHGqJ1K040d1E";
    $dbname = "if0_40201895_sisad";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // ✅ AGREGAR ESTA LÍNEA:
    $conn->set_charset("utf8mb4");

    return $conn;
}

function validar_usuario($nombre_usuario, $clave_usuario) {
    $conn = conectar();
    //$sql = "SELECT * FROM usuario WHERE nombre_u = ? AND clave_u = ? AND estado_u = 1";
    $sql = "SELECT id_usuario, nombre_usuario, id_persona_usuario, estado_usuario 
        FROM usuario 
        WHERE nombre_usuario = ? AND clave_usuario = ? AND estado_usuario IN (1, 2)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_usuario, $clave_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return false;
    }

    $stmt->close();
    $conn->close();
}

// Función para obtener los datos de la persona usando id_id_p_u
function obtener_datos_persona($id_persona_usuario) {
    $conn = conectar();
    $sql = "SELECT * FROM persona WHERE id_persona = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_persona_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return false;
    }

    $stmt->close();
    $conn->close();
}

function obtener_menus() {
    $conn = conectar();
    $sql = "SELECT id_menu, descripcion_menu, estado_menu FROM menu WHERE estado_menu = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $menus = array();
    while ($fila = $resultado->fetch_assoc()) {
        $menus[] = $fila;
    }

    $stmt->close();
    $conn->close();

    return $menus;
}

// función corregida para guardar la ruta relativa en la base de datos
function actualizar_menu($id_menu, $descripcion_menu, $nombrearchivo_menu = null, $nombrearchivo_img = null) {
    $conn = conectar();

    // Agregar la ruta relativa solo si se ha subido un archivo
    if ($nombrearchivo_menu) {
        $nombrearchivo_menu = "P/" . $nombrearchivo_menu;
    }
    if ($nombrearchivo_img) {
        $nombrearchivo_img = "P/img/" . $nombrearchivo_img;
    }

    if ($nombrearchivo_menu && $nombrearchivo_img) {
        $sql = "UPDATE menu SET descripcion_menu = ?, nombrearchivo_menu = ?, nombrearchivo_img = ? WHERE id_menu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $descripcion_menu, $nombrearchivo_menu, $nombrearchivo_img, $id_menu);
    } elseif ($nombrearchivo_menu) {
        $sql = "UPDATE menu SET descripcion_menu = ?, nombrearchivo_menu = ? WHERE id_menu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $descripcion_menu, $nombrearchivo_menu, $id_menu);
    } elseif ($nombrearchivo_img) {
        $sql = "UPDATE menu SET descripcion_menu = ?, nombrearchivo_img = ? WHERE id_menu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $descripcion_menu, $nombrearchivo_img, $id_menu);
    } else {
        $sql = "UPDATE menu SET descripcion_menu = ? WHERE id_menu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $descripcion_menu, $id_menu);
    }

    $exito = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $exito;
}


function get_lista_nombre_bien() {
    $conn = conectar();

    $sql = "SELECT id_nombre_bien, des_nombre_bien FROM nombre_bien WHERE estado_nombre_bien = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $lista = array();
    while ($fila = $resultado->fetch_assoc()) {
        $lista[] = $fila;
    }

    $stmt->close();  // ❗CIERRA el statement
    $conn->close();  // ❗CIERRA la conexión
    return $lista;
}


function registrar_datos(
    $descripcion_area, $descripcion_depen,
    $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien,
    $numdeserie_bien, $numcontropatri_bien, $estado_bien, $funcionamiento,
    $añodeadqs_bien, $numdeordendecom_bien, $observacion_bien, $color_bien, $piso_bien, $costo_bien,
    $nomyap_p, $dni_p, $cell_persona, $correo_persona, $cargo_persona,
    $descripcion_menu,
    $nombrearchivo_menu, $nombrearchivo_img, $organo, $especialidad,
    $id_persona_resgistrox
)
{
    $conn = conectar();

    // Verificar duplicado SIEMPRE que $nombrearchivo_menu exista
    if ($nombrearchivo_menu) {
        $archivos = explode(',', $nombrearchivo_menu);
        $placeholders = implode(',', array_fill(0, count($archivos), '?'));
        $tipos_arch = str_repeat('s', count($archivos));

        $sql_check_archivos = "SELECT nombrearchivo_menu FROM menu WHERE nombrearchivo_menu IN ($placeholders)";
        $stmt_check = $conn->prepare($sql_check_archivos);
        $stmt_check->bind_param($tipos_arch, ...$archivos);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();
            $conn->close();
            return 'duplicado_area';
        }
        $stmt_check->close();
    }

    if ($descripcion_area) {
        $sql_area = "INSERT INTO area (descripcion_area, estado_area, organo, especialidad) VALUES (?, 1, ?, ?)";
        $stmt_area = $conn->prepare($sql_area);
        $stmt_area->bind_param('sss', $descripcion_area, $organo, $especialidad);
        if ($stmt_area->execute()) {
            $id_area_insertada = $conn->insert_id;
            registrarAccion($id_persona_resgistrox, 'insertar', 'area', $id_area_insertada, "Nueva área: $descripcion_area");
        }
    }

    if ($descripcion_depen) {
        $sql_depen = "INSERT INTO dependencia (descripcion_dependencia, estado_dependencia) VALUES (?, 1)";
        $stmt_depen = $conn->prepare($sql_depen);
        $stmt_depen->bind_param('s', $descripcion_depen);
        if ($stmt_depen->execute()) {
            $id_dependencia_insertada = $conn->insert_id;
            registrarAccion($id_persona_resgistrox, 'insertar', 'dependencia', $id_dependencia_insertada, "Nueva dependencia: $descripcion_depen");
        }
    }

    if ($equipo_bien && $marca_bien && $modelo_bien && $procesador_bien && $numdeserie_bien &&
        $numcontropatri_bien && $estado_bien && $funcionamiento && $añodeadqs_bien &&
        $numdeordendecom_bien && $observacion_bien && $piso_bien && $costo_bien !== null) {

        $sql_bien = "INSERT INTO bien (
        equipo_bien, marca_bien, modelo_bien, procesador_bien,
        numdeserie_bien, numcontropatri_bien, estado_bien, funcionamiento,
        añodeadqs_bien, numdeordendecom_bien, observacion_bien, color_bien, piso_bien, costo_bien
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_bien = $conn->prepare($sql_bien);
        $stmt_bien->bind_param(
            'ssssssiiissiid',
            $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien,
            $numdeserie_bien, $numcontropatri_bien, $estado_bien, $funcionamiento,
            $añodeadqs_bien, $numdeordendecom_bien, $observacion_bien, $color_bien, $piso_bien, $costo_bien
        );

        if ($stmt_bien->execute()) {
            $id_bien_insertada = $conn->insert_id;
            registrarAccion($id_persona_resgistrox, 'insertar', 'bien', $id_bien_insertada, "Bien: $equipo_bien, $numdeserie_bien");
        }
    }


    if ($nomyap_p && $dni_p && $cell_persona && $correo_persona && $cargo_persona) {
        $sql_persona = "INSERT INTO persona (nomyap_persona, dni_persona, cell_persona, correo_persona, cargo_persona, estado_persona) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bind_param('sssss', $nomyap_p, $dni_p, $cell_persona ,$correo_persona ,$cargo_persona);
        if ($stmt_persona->execute()) {
            $id_persona_insertada = $conn->insert_id;
            registrarAccion($id_persona_resgistrox, 'insertar', 'persona', $id_persona_insertada, "Persona: $nomyap_p, $dni_p");
        }
    }

    if ($descripcion_menu) {
        $sql_verificar = "SELECT id_menu FROM menu WHERE descripcion_menu = ?";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bind_param("s", $descripcion_menu);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows > 0) {
            $stmt_verificar->close();
            $conn->close();
            return 'duplicado_menu'; // 👈 NUEVO RETORNO
        } else {
            $stmt_verificar->close();
            $sql_insert = "INSERT INTO menu (descripcion_menu, nombrearchivo_menu, nombrearchivo_img, estado_menu) VALUES (?, ?, ?, 1)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('sss', $descripcion_menu, $nombrearchivo_menu, $nombrearchivo_img);
            if ($stmt_insert->execute()) {
                $id = $conn->insert_id;
                registrarAccion($id_persona_resgistrox, 'insertar', 'menu', $id, "Nuevo menú: $descripcion_menu");
            }
            $stmt_insert->close();
        }
    }



    $conn->close();

    return 'ok';

}

// eliminar menu
function obtener_menu_bd($id_menu) {
    $conn = conectar();
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id_menu = ?");
    $stmt->bind_param("i", $id_menu);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $resultado ?: false;
}

function eliminar_menu_bd($id_menu) {
    $conn = conectar();
    $stmt = $conn->prepare("DELETE FROM menu WHERE id_menu = ?");
    $stmt->bind_param("i", $id_menu);
    $res = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $res;
}

function verificar_menu_asignado_bd($id_menu) {
    $conn = conectar();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario_menu WHERE id_menu_usuario_menu = ?");
    $stmt->bind_param("i", $id_menu);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count > 0;
}






// Función para listar todas las áreas
function listar_areas() {
    $conn = conectar();
    $sql = "SELECT * FROM area";
    $resultado = $conn->query($sql);

    $areas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $areas[] = $fila;
    }
    $conn->close();
    return $areas;
}

// Función para listar todas las dependencias
function listar_dependencias() {
    $conn = conectar();
    $sql = "SELECT * FROM dependencia";
    $resultado = $conn->query($sql);

    $dependencias = [];
    while ($fila = $resultado->fetch_assoc()) {
        $dependencias[] = $fila;
    }
    $conn->close();
    return $dependencias;
}

// Función para listar todos los bienes
function listar_bienes() {
    $conn = conectar();

    $sql = "
        SELECT 
            b.id_bien,
            nb.des_nombre_bien AS equipo_bien,
            b.marca_bien,
            b.numdeserie_bien,
            b.numcontropatri_bien
        FROM bien b
        LEFT JOIN nombre_bien nb 
            ON b.equipo_bien = nb.id_nombre_bien
        LEFT JOIN detallemovimiento dm 
            ON b.id_bien = dm.id_bien_detmov
        WHERE dm.id_bien_detmov IS NULL 
              OR dm.estado_detalle_movimiento = 2
    ";

    $resultado = $conn->query($sql);

    $bienes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $bienes[] = $fila;
    }

    $conn->close();
    return $bienes;
}


// Función para listar todas las personas
function listar_personas() 
{
    $conn = conectar();
    $sql = "SELECT * FROM persona";
    $resultado = $conn->query($sql);

    $personas = [];
    while ($fila = $resultado->fetch_assoc()) 
    {
        $personas[] = $fila;
    }
    $conn->close();
    return $personas;
}

// Función para listar todos los menús
function listar_menuss()
{
    $conn = conectar();
    $sql = "SELECT m.*, 
                   (SELECT COUNT(*) FROM usuario_menu um WHERE um.id_menu_usuario_menu = m.id_menu) AS asignado 
            FROM menu m";
    $resultado = $conn->query($sql);

    $menuss = [];
    while ($fila = $resultado->fetch_assoc())
    {
        $menuss[] = $fila;
    }
    $conn->close();
    return $menuss;
}

// Función para listar todos los usuarios
function listar_usuarios()
{
    $conn = conectar();
    $sql = "SELECT * FROM usuario";
    $resultado = $conn->query($sql);

    $listarusuarios = [];
    while ($fila = $resultado->fetch_assoc())
    {
        $listarusuarios[] = $fila;
    }
    $conn->close();
    return $listarusuarios;
}

function listar_nombre_bien() {
    $conn = conectar();
    $sql = "SELECT * FROM nombre_bien";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function actualizar_nombre_bien($id, $descripcion) {
    global $conn;
    $stmt = $conn->prepare("UPDATE nombre_bien SET des_nombre_bien = ? WHERE id_nombre_bien = ?");
    $stmt->bind_param("si", $descripcion, $id);
    return $stmt->execute();
}

function agregar_nombre_bien($descripcion) {
    $conn = conectar();
    $stmt = $conn->prepare("INSERT INTO nombre_bien (des_nombre_bien, estado_nombre_bien) VALUES (?, 1)");
    $stmt->bind_param("s", $descripcion);
    return $stmt->execute();
}




// Función para cambiar estado de los usuarios
function cambiar_estado_usuario($id_usuario, $nuevo_estado, $id_persona_resgistrox) {
    $conn = conectar();
    $sql = "UPDATE usuario SET estado_usuario = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $nuevo_estado, $id_usuario);
    $success = $stmt->execute();

    if ($success) {
        // Datos para el log de acciones
        $accion = 'actualiza el estado de usuario';
        $tabla_afectada = 'usuario';
        $id_fila_afectada = $id_usuario; // Usar directamente el ID que se actualizó
        $detalles = "Se actualizó el estado del usuario con ID = $id_usuario a estado = $nuevo_estado";

        // Registrar la acción en el log
        registrarAccion($id_persona_resgistrox, $accion, $tabla_afectada, $id_fila_afectada, $detalles);
    }

    $stmt->close();
    $conn->close();

    return $success;
}


// Función para asignar o quitar módulos a usuario editor
// ✅ CORRECTO:
function asignar_modulos_a_usuario($id_usuario, $id_persona_resgistrox, $modulos = []) {
    $conn = conectar();

    // Obtener los módulos actuales antes de eliminarlos (para el log)
    $modulos_anteriores = [];
    $query_prev = $conn->prepare("SELECT id_menu_usuario_menu FROM usuario_menu WHERE id_usuario_menu = ?");
    $query_prev->bind_param("i", $id_usuario);
    $query_prev->execute();
    $result_prev = $query_prev->get_result();
    while ($row = $result_prev->fetch_assoc()) {
        $modulos_anteriores[] = $row['id_menu_usuario_menu'];
    }
    $query_prev->close();

    // Eliminar los módulos previos
    $stmt_delete = $conn->prepare("DELETE FROM usuario_menu WHERE id_usuario_menu = ?");
    $stmt_delete->bind_param("i", $id_usuario);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Insertar nuevos módulos seleccionados
    $modulos_nuevos = [];
    if (!empty($modulos)) {
        $stmt_insert = $conn->prepare("INSERT INTO usuario_menu (id_usuario_menu, id_menu_usuario_menu) VALUES (?, ?)");

        foreach ($modulos as $id_menu) {
            $id_menu = intval($id_menu);
            $stmt_insert->bind_param("ii", $id_usuario, $id_menu);
            $stmt_insert->execute();
            $modulos_nuevos[] = $id_menu;
        }

        $stmt_insert->close();
    }

    // Registrar acción en el log
    $accion = 'asigna módulos a usuario';
    $tabla_afectada = 'usuario_menu';
    $id_fila_afectada = $id_usuario;
    $detalles = "Módulos anteriores: [" . implode(', ', $modulos_anteriores) . "], nuevos módulos asignados: [" . implode(', ', $modulos_nuevos) . "]";

    registrarAccion($id_persona_resgistrox, $accion, $tabla_afectada, $id_fila_afectada, $detalles);

    $conn->close();
    return true;
}


function obtener_modulos_de_usuario($id_usuario, $id_persona_resgistrox = null) {
    $conn = conectar();
    $sql = "SELECT id_menu_usuario_menu FROM usuario_menu WHERE id_usuario_menu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $modulos = [];
    while ($row = $result->fetch_assoc()) {
        $modulos[] = $row['id_menu_usuario_menu'];
    }

    $stmt->close();
    $conn->close();

    // Opcional: registrar acceso solo si se proporcionó quien hizo la consulta
    if ($id_persona_resgistrox !== null) {
        $accion = 'consulta módulos del usuario';
        $tabla_afectada = 'usuario_menu';
        $id_fila_afectada = $id_usuario;
        $detalles = "Se consultaron los módulos asignados al usuario con ID = $id_usuario";

        registrarAccion($id_persona_resgistrox, $accion, $tabla_afectada, $id_fila_afectada, $detalles);
    }

    return $modulos;
}


// Función para obtener menus asignados a los usuarios
function obtener_menus_por_usuario($id_usuario) {
    $conn = conectar();

    $sql = "SELECT m.id_menu, m.descripcion_menu 
            FROM usuario_menu um 
            JOIN menu m ON um.id_menu_usuario_menu = m.id_menu 
            WHERE um.id_usuario_menu = ? AND m.estado_menu = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $menus = [];

    while ($fila = $resultado->fetch_assoc()) {
        $menus[] = $fila;
    }

    $stmt->close();
    $conn->close();

    return $menus;
}






// Función para actualizar un campo específico en una tabla
function actualizar_registro($tabla, $campo, $valor, $id) {
    $conn = conectar();
    $sql = "UPDATE $tabla SET $campo = ? WHERE id_$tabla = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $valor, $id);

    if ($stmt->execute()) {
        $respuesta = "Registro actualizado correctamente.";
    } else {
        $respuesta = "Error al actualizar el registro.";
    }

    $stmt->close();
    $conn->close();

    return $respuesta;
}

// Función para cambiar el estado de un registro
function cambiar_estado_registro($tabla, $estado, $id) {
    $conn = conectar();
    $sql = "UPDATE $tabla SET estado_$tabla = ? WHERE id_$tabla = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $estado, $id);

    if ($stmt->execute()) {
        $respuesta = "Estado cambiado correctamente.";
    } else {
        $respuesta = "Error al cambiar el estado.";
    }

    $stmt->close();
    $conn->close();

    return $respuesta;
}


function usuario_existente($id_persona_usuario) {
    // Conexión a la base de datos y verificar si la persona ya está asociada a un usuario
    $conexion = conectar();
    $query = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE id_persona_usuario = ?");
    $query->execute([$id_persona_usuario]);
    return $query->fetchColumn() > 0;
}


function registrar_usuario($id_persona_usuario, $nombre_usuario, $clave_usuario, $estado_usuario, $id_persona_resgistrox)
{
    $conn = conectar();
    $clave_md5 = md5($clave_usuario);

    $sql = "INSERT INTO usuario (id_persona_usuario, nombre_usuario, clave_usuario, estado_usuario) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('issi', $id_persona_usuario, $nombre_usuario, $clave_md5, $estado_usuario);
        if ($stmt->execute())
        {
            $id_usuario_nuevo = $conn->insert_id;

            // Registrar log
            $accion = 'insertar';
            $tabla_afectada = 'usuario';
            $id_fila_afectada = $id_usuario_nuevo;
            $detalles = "Nuevo usuario agregado: $nombre_usuario, Estado = $estado_usuario";
            registrarAccion($id_persona_resgistrox, $accion, $tabla_afectada, $id_fila_afectada, $detalles);

            // Si es Super Usuario (estado_usuario == 1), registrar todos los menús
            if ($estado_usuario == 1) {
                $sql_menus = "SELECT id_menu FROM menu";
                $result_menus = $conn->query($sql_menus);

                if ($result_menus && $result_menus->num_rows > 0) {
                    $stmt_insert_menu = $conn->prepare("INSERT INTO usuario_menu (id_usuario_menu, id_menu_usuario_menu) VALUES (?, ?)");

                    while ($row = $result_menus->fetch_assoc()) {
                        $id_menu = $row['id_menu'];
                        $stmt_insert_menu->bind_param('ii', $id_usuario_nuevo, $id_menu);
                        $stmt_insert_menu->execute();
                    }

                    $stmt_insert_menu->close();
                }
            }
        }

        $stmt->close();
    }

    $conn->close();

    return true;
}



 
function obtener_personas_sin_usuario() 
{

    $conn = conectar();
    $sql = "SELECT id_persona, nomyap_persona FROM persona WHERE id_persona NOT IN (SELECT id_persona_usuario FROM usuario)";
    $resultado = $conn->query($sql);

    $personax = [];
    while ($fila = $resultado->fetch_assoc()) 
    {
        $personax[] = $fila;
    }
    $conn->close();
    return $personax;
}

function registrar_movimiento($id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptor, $id_area_transferente, $id_area_receptor, $fecha_movimiento, $ruta_archivo, $estado_movimiento) 
{
    // Obtener la conexión a la base de datos
    $conn = conectar();
    
    // Preparar la consulta SQL para insertar el movimiento
    $sql = "INSERT INTO movimiento (
                id_transferente_movimiento, 
                id_receptor_movimiento, 
                id_dependencia_transferente_movimiento, 
                id_dependencia_receptor_movimiento, 
                id_area_transferente_movimiento, 
                id_area_receptor_movimiento, 
                fecha_movimiento, 
                archivo_movimiento,
                estado_movimiento

            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
    
    // Preparar el statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        // Si hubo un error preparando la consulta, devolver false
        return false;
    }
    
    // Asignar los parámetros: 6 enteros y 2 cadenas de texto
    $stmt->bind_param("iiiiiissi", 
        $id_transferente, 
        $id_receptor, 
        $id_dependencia_transferente, 
        $id_dependencia_receptor, 
        $id_area_transferente, 
        $id_area_receptor, 
        $fecha_movimiento, 
        $ruta_archivo,
        $estado_movimiento
    );
    
    // Ejecutar la consulta y verificar el resultado
    $resultado = $stmt->execute();
    
    if ($resultado) 
    {
        
        // Si la inserción fue exitosa, devolver el ID del movimiento recién insertado
        $id_movimiento = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return $id_movimiento;
    } else {
        // Si hubo un error, devolver false
        $stmt->close();
        $conn->close();
        return false;
    }
}

function registrar_detalle_movimiento( $id_movimiento, $id_bien) {
    // Obtener la conexión a la base de datos
    $conn = conectar();
    
    // Preparar la consulta SQL para insertar el detalle del movimiento
    $sql = "INSERT INTO detallemovimiento (id_bien_detmov, id_mov_detallemovimiento) VALUES (?, ?)";
    
    // Preparar el statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        // Si hubo un error preparando la consulta, devolver false
        return false;
    }
    
    // Asignar los parámetros: ambos son enteros
    $stmt->bind_param("ii", $id_bien, $id_movimiento);
    
    // Ejecutar la consulta y verificar el resultado
    $resultado = $stmt->execute();
    
    if ($resultado) {
        $stmt->close();
        $conn->close();
        return true; // Si se insertó correctamente
    } else {
        $stmt->close();
        $conn->close();
        return false; // Si hubo un error
    }
}



function obtener_ultimos_movimientosX() 
{
    $conn = conectar();
    $sql = "SELECT 
                m.id_movimiento, 
                t.nomyap_persona AS transferente, 
                r.nomyap_persona AS receptor, 
                d.descripcion_dependencia AS dependencia, 
                destino.descripcion_dependencia AS dependencia_destino,
                aenvio.descripcion_area AS area_trans,
                adestino.descripcion_area AS area_des,
                m.fecha_movimiento,
                archivo_movimiento,
                estado_movimiento,
                (
                    SELECT COUNT(*) 
                    FROM detallemovimiento 
                    WHERE detallemovimiento.id_mov_detallemovimiento = m.id_movimiento 
                    AND detallemovimiento.estado_detalle_movimiento = 2
                ) AS tiene_desvinculado
            FROM movimiento m
            JOIN persona t ON m.id_transferente_movimiento = t.id_persona
            JOIN persona r ON m.id_receptor_movimiento = r.id_persona
            JOIN dependencia d ON m.id_dependencia_transferente_movimiento = d.id_dependencia
            JOIN dependencia destino ON m.id_dependencia_receptor_movimiento = destino.id_dependencia
            JOIN area aenvio ON m.id_area_transferente_movimiento = aenvio.id_area
            JOIN area adestino ON m.id_area_receptor_movimiento = adestino.id_area
            ORDER BY m.fecha_movimiento DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $movimientos = [];

    while ($row = $result->fetch_assoc()) {
        $movimientos[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $movimientos;
}

function listar_bienes_all() {
    $conn = conectar();

    $sql = "SELECT 
                b.id_bien,
                nb.des_nombre_bien AS nombre_equipo,
                b.marca_bien,
                b.modelo_bien,
                b.procesador_bien,
                b.numdeserie_bien,
                b.numcontropatri_bien,
                CASE b.estado_bien
                    WHEN 1 THEN 'Bueno'
                    WHEN 2 THEN 'Regular'
                    WHEN 3 THEN 'Malo'
                    WHEN 4 THEN 'Baja'
                    ELSE 'Desconocido'
                END AS estado_bien,
                b.añodeadqs_bien,
                b.numdeordendecom_bien,
                b.observacion_bien,
                b.costo_bien,
                CASE b.funcionamiento
                    WHEN 1 THEN 'Operativo'
                    WHEN 2 THEN 'Inoperativo'
                    WHEN 3 THEN 'Regular'
                    ELSE 'Desconocido'
                END AS funcionamiento
            FROM bien b
            INNER JOIN nombre_bien nb 
                ON b.equipo_bien = nb.id_nombre_bien
            ORDER BY b.id_bien DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $bienes = [];

    while ($fila = $resultado->fetch_assoc()) {
        $bienes[] = $fila;
    }

    return $bienes;
}



function actualizarDoc_movimiento($id_movimientoA, $archivo_movimiento) {
    $conn = conectar();
    $sql = "UPDATE movimiento SET archivo_movimiento = ?, estado_movimiento = 1 WHERE id_movimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $archivo_movimiento, $id_movimientoA);

    if ($stmt->execute()) {
        $respuesta = "Actualizado correctamente.";
    } else {
        // Mostrar error en caso de fallo de ejecución
        $respuesta = "Error al actualizar el registro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    return $respuesta;
}




//Listar un movimiento con limite muesstra
function obtener_ultimos_movimientos($cantidad) {
    $conn = conectar();
    $sql = "SELECT 
                m.id_movimiento, 
                t.nomyap_persona AS transferente, 
                r.nomyap_persona AS receptor, 
                d.descripcion_dependencia AS dependencia, 
                destino.descripcion_dependencia AS dependencia_destino,
                aenvio.descripcion_area AS area_trans,
                adestino.descripcion_area AS area_des,
                m.fecha_movimiento,
                archivo_movimiento,
                estado_movimiento

            FROM movimiento m
            JOIN persona t ON m.id_transferente_movimiento = t.id_persona
            JOIN persona r ON m.id_receptor_movimiento = r.id_persona
            JOIN dependencia d ON m.id_dependencia_transferente_movimiento = d.id_dependencia
            JOIN dependencia destino ON m.id_dependencia_receptor_movimiento = destino.id_dependencia
            JOIN area aenvio ON m.id_area_transferente_movimiento = aenvio.id_area
            JOIN area adestino ON m.id_area_receptor_movimiento = adestino.id_area
            ORDER BY m.fecha_movimiento DESC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cantidad);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $movimientos = [];

    while ($row = $result->fetch_assoc()) {
        $movimientos[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $movimientos;
}

//lista el movimiento por el tipeo
function obtener_movimientos_por_receptor($search) {
    $conn = conectar();

    $sql = "SELECT m.id_movimiento, 
                   t.nomyap_persona AS transferente, 
                   r.nomyap_persona AS receptor,
                   dt.descripcion_dependencia AS dependencia,
                   dr.descripcion_dependencia AS dependencia_destino,
                   at.descripcion_area AS area_trans,
                   ar.descripcion_area AS area_des,
                   m.fecha_movimiento,
                   m.archivo_movimiento,
                   m.estado_movimiento
            FROM movimiento m
            LEFT JOIN persona t ON m.id_transferente_movimiento = t.id_persona
            LEFT JOIN persona r ON m.id_receptor_movimiento = r.id_persona
            LEFT JOIN dependencia dt ON m.id_dependencia_transferente_movimiento = dt.id_dependencia
            LEFT JOIN dependencia dr ON m.id_dependencia_receptor_movimiento = dr.id_dependencia
            LEFT JOIN area at ON m.id_area_transferente_movimiento = at.id_area
            LEFT JOIN area ar ON m.id_area_receptor_movimiento = ar.id_area
            WHERE ? = '' 
               OR m.id_movimiento LIKE ? 
               OR t.nomyap_persona LIKE ? 
               OR r.nomyap_persona LIKE ? 
               OR dt.descripcion_dependencia LIKE ? 
               OR dr.descripcion_dependencia LIKE ? 
               OR at.descripcion_area LIKE ? 
               OR ar.descripcion_area LIKE ? 
               OR m.fecha_movimiento LIKE ?";

    $stmt = $conn->prepare($sql);
    $param = "%" . $search . "%";
    $stmt->bind_param("sssssssss", $search, $param, $param, $param, $param, $param, $param, $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();

    $movimientos = [];
    while ($row = $result->fetch_assoc()) {
        $movimientos[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $movimientos;
}



function obtener_detalle_movimiento($id_movimiento) {
    $conn = conectar();
    $sql = "SELECT 
        d.id_detallemovimiento, 
        nb.des_nombre_bien,
        b.equipo_bien, 
        b.marca_bien,
        b.modelo_bien,
        b.procesador_bien,
        b.numdeserie_bien,
        b.numcontropatri_bien,
        b.estado_bien,
        b.añodeadqs_bien,
        b.numdeordendecom_bien,
        b.color_bien,
        b.observacion_bien,
        d.id_bien_detmov,
        b.costo_bien,
        b.funcionamiento
    FROM detallemovimiento d
    JOIN bien b ON d.id_bien_detmov = b.id_bien
    JOIN nombre_bien nb ON b.equipo_bien = nb.id_nombre_bien
    WHERE d.id_mov_detallemovimiento = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();

    $result = $stmt->get_result();
    $detalles = [];

    while ($row = $result->fetch_assoc()) {
        $detalles[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $detalles;
}


function eliminar_bien_detalle($id_bien, $id_movimiento) {
    $conn = conectar();

    $sql = "DELETE FROM detallemovimiento WHERE id_bien_detmov = ? AND id_mov_detallemovimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $id_bien, $id_movimiento);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
   
}
function eliminar_movimiento($id_movimiento) {
    $conn = conectar();

    // 1. Verificar si el movimiento tiene un archivo asociado
    $sql = "SELECT archivo_movimiento FROM movimiento WHERE id_movimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_movimiento);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row && !empty($row['archivo_movimiento'])) {
        // 2. Si tiene un archivo, eliminarlo del sistema de archivos
        $archivo = '../' . $row['archivo_movimiento']; // Ajusta la ruta si es necesario
        if (file_exists($archivo)) {
            unlink($archivo); // Elimina el archivo
        }
    }

    // 3. Ahora eliminar el movimiento y sus detalles
    $sql = "DELETE FROM movimiento WHERE id_movimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_movimiento);
    
    // Ejecutar la consulta y devolver el resultado como true o false
    return $stmt->execute();
}





function obtener_detalle_movimiento_bien_noAsociado()
{
    $conn = conectar();
    //$sql = "SELECT * FROM bien WHERE id_bien NOT IN (SELECT id_bien_detmov FROM detallemovimiento)";
    $sql = "SELECT b.*, nb.des_nombre_bien FROM bien b JOIN nombre_bien nb ON b.equipo_bien = nb.id_nombre_bien WHERE b.id_bien NOT IN ( SELECT id_bien_detmov FROM detallemovimiento)";
    $resultado = $conn->query($sql);

    $bienNoasiciado= [];
    while ($fila = $resultado->fetch_assoc()) 
    {
        $bienNoasiciado[] = $fila;
    }
    $conn->close();
    return $bienNoasiciado;

}




function registrarAccion($id_usuario, $accion, $tabla_afectada, $id_fila_afectada, $detalles) {
    
    // Conectar a la base de datos
    $conn = conectar();
    
    // Verificar que la conexión fue exitosa
    if ($conn->connect_error) 
    {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Prepara el SQL para insertar en el log
    $sql = "INSERT INTO log_acciones (id_usuario_log, accion_log, tabla_afectada_log, id_fila_afectada_log, detalles_log)
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    // Verificar si la preparación del statement fue exitosa
    if ($stmt === false) 
    {
        die("Error en la preparación del statement: " . $conn->error);
    }

    // Bind de parámetros
    $stmt->bind_param("issis", $id_usuario, $accion, $tabla_afectada, $id_fila_afectada, $detalles);
    $stmt->execute();
    // Ejecutar y comprobar si la inserción fue exitosa
   /* if ($stmt->execute()) {
        echo "Acción registrada en el log.";
    } else {
        echo "Error al registrar la acción: " . $stmt->error;
    }
    */
    // Cerrar el statement y la conexión
    $stmt->close();
    $conn->close();
}



// Obtener movimiento por ID
function obtenerMovimientoPorId($id_movimiento) {
    $conn = conectar();
    $query = "SELECT 
                m.id_movimiento, 
                t.nomyap_persona AS transferente,
                t.dni_persona AS dnit,
                t.cargo_persona AS cargo_t,
                r.nomyap_persona AS receptor, 
                r.dni_persona AS dnir,
                r.cargo_persona AS cargo_r,
                d.descripcion_dependencia AS dependencia, 
                destino.descripcion_dependencia AS dependencia_destino,
                aenvio.descripcion_area AS area_trans,
                adestino.descripcion_area AS area_des,
                m.fecha_movimiento,
                archivo_movimiento,
                estado_movimiento

            FROM movimiento m
            JOIN persona t ON m.id_transferente_movimiento = t.id_persona
            JOIN persona r ON m.id_receptor_movimiento = r.id_persona
            JOIN dependencia d ON m.id_dependencia_transferente_movimiento = d.id_dependencia
            JOIN dependencia destino ON m.id_dependencia_receptor_movimiento = destino.id_dependencia
            JOIN area aenvio ON m.id_area_transferente_movimiento = aenvio.id_area
            JOIN area adestino ON m.id_area_receptor_movimiento = adestino.id_area
            WHERE  m.id_movimiento =?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();
    $result = $stmt->get_result();
    $movimiento = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $movimiento;
}

function listar_bienes_con_personas()
{
    $conn = conectar();
    $sql = "SELECT dm.id_detallemovimiento, 
                'CORTE SUPERIOR DE JUSTICIA DE LORETO' AS SEDE,
                a.descripcion_area AS DEPENDENCIA,
                a.organo AS ORGANO,
                a.especialidad AS ESPECIALIDAD,
                p.nomyap_persona AS USUARIO,
                p.correo_persona AS CORREO,
                nb.des_nombre_bien AS EQUIPO,
                b.marca_bien AS MARCA,
                b.modelo_bien AS MODELO,
                b.procesador_bien AS PROCESADOR,
                pc.nombre_pcasignada AS NOMBRE_PC,
                b.numdeserie_bien AS `NUMERO DE SERIE`,
                b.numcontropatri_bien AS `NUMERO DE CONTROL PATRIMONIAL`,
                CASE 
                    WHEN b.estado_bien = 1 THEN 'BUENO'
                    WHEN b.estado_bien = 2 THEN 'REGULAR'
                    WHEN b.estado_bien = 3 THEN 'MALO'
                    ELSE 'DESCONOCIDO'
                END AS ESTADO,
                b.añodeadqs_bien AS `AÑO DE ADQUISICIÓN`,
                b.numdeordendecom_bien AS `NUMERO DE ORDEN DE COMPRA`,
                b.funcionamiento AS FUNCIONAMIENTO,
                b.observacion_bien AS OBSERVACIÓN,
                CASE 
                    WHEN nb.des_nombre_bien IN ('UNIDAD CENTRAL DE PROCESO - CPU', 'LAPTOP') THEN 'WINDOWS 10 PRO'
                    ELSE NULL
                END AS WINDOWS,
                CASE 
                    WHEN nb.des_nombre_bien IN ('UNIDAD CENTRAL DE PROCESO - CPU', 'LAPTOP') THEN 'Office Professional Plus 2016'
                    ELSE NULL
                END AS OFFICE,
                CASE 
                    WHEN nb.des_nombre_bien IN ('UNIDAD CENTRAL DE PROCESO - CPU', 'LAPTOP') THEN 'KasperkyEndpoint Security 12.6.0.438'
                    ELSE NULL
                END AS ANTIVIRUS
            FROM 
                movimiento m
            JOIN 
                detallemovimiento dm ON m.id_movimiento = dm.id_mov_detallemovimiento
            JOIN 
                bien b ON dm.id_bien_detmov = b.id_bien
            JOIN 
                nombre_bien nb ON b.equipo_bien = nb.id_nombre_bien
            LEFT JOIN 
                pcasignada pc ON b.id_pcasignada = pc.id_pcasignada
            JOIN         
                persona p ON m.id_receptor_movimiento = p.id_persona
            JOIN 
                area a ON m.id_area_receptor_movimiento = a.id_area
            WHERE 
                m.estado_movimiento = 1
            ORDER BY 
                p.nomyap_persona ASC,
                CASE 
                    WHEN b.equipo_bien = 'CPU' THEN 1
                    WHEN b.equipo_bien = 'MONITOR' THEN 2
                    WHEN b.equipo_bien = 'TECLADO' THEN 3
                    ELSE 4
                END ASC, 
                b.equipo_bien ASC";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $bienes= [];
    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row;
    }

    $conn->close();

    return $bienes;
}

function listar_bienes_con_personas_tipeo($letra) 
{
    $conn = conectar(); // Asumiendo que esta función retorna una conexión válida.
    
    // Agregar filtro por número de serie
    $sql = "SELECT 
                dm.id_detallemovimiento, 
                'CORTE SUPERIOR DE JUSTICIA DE LORETO' AS SEDE,
                a.descripcion_area AS DEPENDENCIA,
                p.nomyap_persona AS USUARIO,
                b.equipo_bien AS EQUIPO,
                b.marca_bien AS MARCA,
                b.modelo_bien AS MODELO,
                b.procesador_bien AS PROCESADOR,
                b.numdeserie_bien AS `NUMERO DE SERIE`,
                b.numcontropatri_bien AS `NUMERO DE CONTROL PATRIMONIAL`,
                CASE 
                    WHEN b.estado_bien = 1 THEN 'BUENO'
                    WHEN b.estado_bien = 2 THEN 'REGULAR'
                    WHEN b.estado_bien = 3 THEN 'MALO'
                    ELSE 'DESCONOCIDO'
                END AS ESTADO,
                b.añodeadqs_bien AS `AÑO DE ADQUISICIÓN`,
                b.numdeordendecom_bien AS `NUMERO DE ORDEN DE COMPRA`,
                CASE
                    WHEN b.estado_bien IN (1, 2) THEN 'Funcional'
                    ELSE 'No funcional'
                END AS FUNCIONAMIENTO,
                b.observacion_bien AS OBSERVACIÓN
            FROM 
                movimiento m
            JOIN 
                detallemovimiento dm ON m.id_movimiento = dm.id_mov_detallemovimiento
            JOIN 
                bien b ON dm.id_bien_detmov = b.id_bien
            JOIN 
                persona p ON m.id_receptor_movimiento = p.id_persona
            JOIN 
                area a ON m.id_area_receptor_movimiento = a.id_area
            WHERE 
                m.estado_movimiento = 1
                AND b.numdeserie_bien LIKE CONCAT('%', ?, '%') -- Filtrar por serie
            ORDER BY 
                p.nomyap_persona ASC,
                CASE 
                    WHEN b.equipo_bien = 'CPU' THEN 1
                    WHEN b.equipo_bien = 'MONITOR' THEN 2
                    WHEN b.equipo_bien = 'TECLADO' THEN 3
                    ELSE 4
                END ASC, 
                b.equipo_bien ASC";
    
    // Preparar consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    
    // Bind de parámetros
    $stmt->bind_param('s', $letra);
    
    // Ejecutar consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error en la ejecución: " . $stmt->error);
    }

    $bienes = [];
    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row;
    }

    // Cerrar recursos
    $stmt->close();
    $conn->close();

    return $bienes;
}


function listar_bienes_por_dni($dni)
{
    $conn = conectar(); // Tu función de conexión
    $sql = "SELECT
                   'CORTE SUPERIOR DE JUSTICIA DE LORETO' AS SEDE,
                   a.descripcion_area AS AREA,
                   a.descripcion_area AS DEPENDENCIA,
                   p.nomyap_persona AS USUARIO,
                   b.equipo_bien AS EQUIPO,
                   b.marca_bien AS MARCA,
                   b.modelo_bien AS MODELO,
                   b.procesador_bien AS PROCESADOR,
                   b.numdeserie_bien AS `NUMERO DE SERIE`,
                   b.numcontropatri_bien AS `NUMERO DE CONTROL PATRIMONIAL`,
                   CASE 
                       WHEN b.estado_bien = 1 THEN 'BUENO'
                       WHEN b.estado_bien = 2 THEN 'REGULAR'
                       WHEN b.estado_bien = 3 THEN 'MALO'
                       ELSE 'DESCONOCIDO'
                   END AS ESTADO,
                   b.añodeadqs_bien AS `AÑO DE ADQUISICIÓN`,
                   b.numdeordendecom_bien AS `NUMERO DE ORDEN DE COMPRA`,
                   CASE
                       WHEN b.estado_bien IN (1, 2) THEN 'Funcional'
                       ELSE 'No funcional'
                   END AS FUNCIONAMIENTO,
                   b.observacion_bien AS OBSERVACIÓN,
                   dm.estado_detalle_movimiento
            FROM   movimiento m
            JOIN   detallemovimiento dm ON m.id_movimiento = dm.id_mov_detallemovimiento
            JOIN   bien b ON dm.id_bien_detmov = b.id_bien
            JOIN   persona p ON m.id_receptor_movimiento = p.id_persona
            JOIN   area a ON m.id_area_receptor_movimiento = a.id_area
            WHERE  m.estado_movimiento IN (0,1,2)
                   AND p.dni_persona = ?
            ORDER BY 
                   p.nomyap_persona ASC,
                   CASE 
                       WHEN b.equipo_bien = 'CPU' THEN 1
                       WHEN b.equipo_bien = 'MONITOR' THEN 2
                       WHEN b.equipo_bien = 'TECLADO' THEN 3
                       ELSE 4
                   END ASC,
                   b.equipo_bien ASC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error en la ejecución: " . $stmt->error);
    }

    $bienes = [];
    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $bienes;
}



function obtenerBienPorId($id_bien) {
    $conn = conectar();

    $sql = "SELECT b.*, nb.des_nombre_bien, b.id_pcasignada, pc.nombre_pcasignada
        FROM bien b
        INNER JOIN nombre_bien nb ON b.equipo_bien = nb.id_nombre_bien
        LEFT JOIN pcasignada pc ON b.id_pcasignada = pc.id_pcasignada
        WHERE b.id_bien = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bien);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}




function actualizarBien($datos) {
    $conn = conectar();

    // Si el equipo no es CPU (1) ni LAPTOP (4), establecer pcasignada como NULL
    $equipoId = intval($datos['equipo_bien']);
    $pcasignada = null;
    if ($equipoId === 1 || $equipoId === 4) {
        $pcasignada = !empty($datos['pcasignada']) ? $datos['pcasignada'] : null;
    }

    $sql = "UPDATE bien SET 
                equipo_bien = ?, 
                marca_bien = ?, 
                modelo_bien = ?, 
                procesador_bien = ?, 
                numdeserie_bien = ?, 
                numcontropatri_bien = ?, 
                estado_bien = ?, 
                añodeadqs_bien = ?, 
                numdeordendecom_bien = ?, 
                observacion_bien = ?, 
                color_bien = ?,
                costo_bien = ?, 
                funcionamiento = ?,
                id_pcasignada = ?,
                piso_bien = ?
            WHERE id_bien = ?";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $datos['equipo_bien'],
        $datos['marca_bien'],
        $datos['modelo_bien'],
        $datos['procesador_bien'],
        $datos['numdeserie_bien'],
        $datos['numcontropatri_bien'],
        $datos['estado_bien'],
        $datos['añodeadqs_bien'],
        $datos['numdeordendecom_bien'],
        $datos['observacion_bien'],
        $datos['color_bien'],
        $datos['costo_bien'],
        $datos['funcionamiento'],
        $pcasignada, // Cambio: usar la variable procesada en lugar de $datos['pcasignada']
        $datos['piso_bien'],
        $datos['id_bien']
    ]);
}


function registrarPcasignada($id_bien, $nombre) {
    try {
        $conn = conectar();
        $sql = "INSERT INTO pcasignada (id_pcasignada_bien, nombre_pcasignada, estado_pcasignada) 
                VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_bien, $nombre);

        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function verificarDuplicadoPcasignada($id_bien, $nombre) {
    try {
        $conn = conectar();
        $sql = "SELECT COUNT(*) as count FROM pcasignada 
                WHERE id_pcasignada_bien = ? AND nombre_pcasignada = ? AND estado_pcasignada = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_bien, $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    } catch (Exception $e) {
        return false;
    }
}

// Funciones para PC asignada
if (!function_exists('verificarDuplicadoPcasignada')) {
    function verificarDuplicadoPcasignada($id_bien, $nombre) {
        try {
            $conn = conectar();
            $sql = "SELECT COUNT(*) as count FROM pcasignada 
                    WHERE id_pcasignada_bien = ? AND nombre_pcasignada = ? AND estado_pcasignada = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $id_bien, $nombre);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('registrarPcasignada')) {
    function registrarPcasignada($id_bien, $nombre) {
        try {
            $conn = conectar();
            $sql = "INSERT INTO pcasignada (id_pcasignada_bien, nombre_pcasignada, estado_pcasignada) 
                    VALUES (?, ?, 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $id_bien, $nombre);

            if ($stmt->execute()) {
                return $conn->insert_id;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}


function eliminarBienPorId($id_bien) {
    $conn = conectar();

    $stmt = $conn->prepare("DELETE FROM bien WHERE id_bien = ?");
    if ($stmt === false) {
        return false;
    }

    return $stmt->execute([$id_bien]);
}

// Obtener detalles por ID de movimiento
/*function obtenerDetallesPorMovimientoId($id_movimiento) {
    $conn = conectar();
    $query = "SELECT * FROM detallemovimiento WHERE id_mov_detallemovimiento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();
    $result = $stmt->get_result();
    $detalles = [];
    while ($row = $result->fetch_assoc()) {
        $detalles[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $detalles;
}

SELECT dm.id_detallemovimiento, 
       'CORTE SUPERIOR DE JUSTICIA DE LORETO' AS SEDE,
       a.descripcion_area AS DEPENDENCIA,
       p.nomyap_persona AS USUARIO,
       b.equipo_bien AS EQUIPO,
       b.marca_bien AS MARCA,
       b.modelo_bien AS MODELO,
       b.procesador_bien AS PROCESADOR,
       b.numdeserie_bien AS `NUMERO DE SERIE`,
       b.numcontropatri_bien AS `NUMERO DE CONTROL PATRIMONIAL`,
       CASE 
           WHEN b.estado_bien = 1 THEN 'BUENO'
           WHEN b.estado_bien = 2 THEN 'REGULAR'
           WHEN b.estado_bien = 3 THEN 'MALO'
           ELSE 'DESCONOCIDO'
       END AS ESTADO,
       b.añodeadqs_bien AS `AÑO DE ADQUISICIÓN`,
       b.numdeordendecom_bien AS `NUMERO DE ORDEN DE COMPRA`,
       CASE
           WHEN b.estado_bien IN (1, 2) THEN 'Funcional'
           ELSE 'No funcional'
       END AS FUNCIONAMIENTO,
       b.observacion_bien AS OBSERVACIÓN
FROM   movimiento m
JOIN   detallemovimiento dm ON m.id_movimiento = dm.id_mov_detallemovimiento
JOIN   bien b ON dm.id_bien_detmov = b.id_bien
JOIN   persona p ON m.id_receptor_movimiento = p.id_persona
JOIN   area a ON m.id_area_receptor_movimiento = a.id_area
WHERE  m.estado_movimiento = 1
       AND p.dni_persona = 46081102
ORDER BY 
       p.nomyap_persona ASC,
       CASE 
           WHEN b.equipo_bien = 'CPU' THEN 1
           WHEN b.equipo_bien = 'MONITOR' THEN 2
           WHEN b.equipo_bien = 'TECLADO' THEN 3
           ELSE 4
       END ASC, 
       b.equipo_bien ASC;



*/


function obtener_areas_por_bienes($ids_bienes) {
    $conn = conectar();
    $areas = [];

    if (empty($ids_bienes)) return $areas;

    // Preparar placeholders
    $placeholders = implode(',', array_fill(0, count($ids_bienes), '?'));

    $sql = "
        SELECT dm.id_bien_detmov, m.id_area_receptor_movimiento
        FROM detallemovimiento dm
        INNER JOIN movimiento m ON dm.id_mov_detallemovimiento = m.id_movimiento
        WHERE dm.id_bien_detmov IN ($placeholders)
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $types = str_repeat('i', count($ids_bienes));
        $stmt->bind_param($types, ...$ids_bienes);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $areas[$row['id_bien_detmov']] = $row['id_area_receptor_movimiento'];
        }

        $stmt->close();
    }

    $conn->close();
    return $areas;
}

function obtener_info_completa_movimiento($id_movimiento) {
    $conn = conectar();
    $datos = [];

    $sql = "
        SELECT 
            m.id_movimiento,
            m.id_transferente_movimiento,
            m.id_receptor_movimiento,
            m.id_dependencia_transferente_movimiento,
            m.id_dependencia_receptor_movimiento,
            m.id_area_transferente_movimiento,
            m.id_area_receptor_movimiento,
            m.fecha_movimiento,

            p1.nomyap_persona AS nombre_transferente,
            p2.nomyap_persona AS nombre_receptor,
            d1.descripcion_dependencia AS dependencia_transferente,
            d2.descripcion_dependencia AS dependencia_receptor,
            a1.descripcion_area AS area_transferente,
            a2.descripcion_area AS area_receptor

        FROM movimiento m
        LEFT JOIN persona p1 ON m.id_transferente_movimiento = p1.id_persona
        LEFT JOIN persona p2 ON m.id_receptor_movimiento = p2.id_persona
        LEFT JOIN dependencia d1 ON m.id_dependencia_transferente_movimiento = d1.id_dependencia
        LEFT JOIN dependencia d2 ON m.id_dependencia_receptor_movimiento = d2.id_dependencia
        LEFT JOIN area a1 ON m.id_area_transferente_movimiento = a1.id_area
        LEFT JOIN area a2 ON m.id_area_receptor_movimiento = a2.id_area

        WHERE m.id_movimiento = ?
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $id_movimiento);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = $result->fetch_assoc();
        $stmt->close();
    }

    $conn->close();
    return $datos;
}

function guardar_desvinculacion(
    $id_movimiento, $id_transferente, $id_receptor,
    $id_dependencia_transferente, $id_dependencia_receptor,
    $id_area_transferente, $id_area_receptor,
    $fecha_movimiento, $fecha_actual,
    $archivo_movimiento, $archivo_movimiento_actual,
    $ids_bienes
) {
    $conn = conectar();

    $stmt_insert = $conn->prepare("
        INSERT INTO historial_movimiento (
            id_movimiento,
            id_transferente_movimiento,
            id_receptor_movimiento,
            id_dependencia_transferente_movimiento,
            id_dependencia_receptor_movimiento,
            id_area_transferente_movimiento,
            id_area_receptor_movimiento,
            fecha_movimiento,
            fecha_movimiento_actual,
            archivo_movimiento,
            archivo_movimiento_actual,
            id_bien_desvinculado,
            estado_movimiento
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 2)
    ");

    $stmt_update = $conn->prepare("
        UPDATE detallemovimiento 
        SET estado_detalle_movimiento = 2 
        WHERE id_bien_detmov = ? AND id_mov_detallemovimiento = ?
    ");

    // 🔹 Nuevo: Update para movimiento
    $stmt_update_movimiento = $conn->prepare("
        UPDATE movimiento
        SET estado_movimiento = 2
        WHERE id_movimiento = ?
    ");

    foreach ($ids_bienes as $id_bien) {
        $stmt_insert->bind_param(
            "iiiiiiissssi",
            $id_movimiento,
            $id_transferente,
            $id_receptor,
            $id_dependencia_transferente,
            $id_dependencia_receptor,
            $id_area_transferente,
            $id_area_receptor,
            $fecha_movimiento,
            $fecha_actual,
            $archivo_movimiento,
            $archivo_movimiento_actual,
            $id_bien
        );

        if (!$stmt_insert->execute()) {
            error_log("Error insertando historial: " . $stmt_insert->error);
            return false;
        }

        $stmt_update->bind_param("ii", $id_bien, $id_movimiento);

        if (!$stmt_update->execute()) {
            error_log("Error actualizando detallemovimiento: " . $stmt_update->error);
            return false;
        }
    }

    // ✅ Actualizar estado en movimiento
    $stmt_update_movimiento->bind_param("i", $id_movimiento);
    if (!$stmt_update_movimiento->execute()) {
        error_log("Error actualizando movimiento: " . $stmt_update_movimiento->error);
        return false;
    }

    $stmt_insert->close();
    $stmt_update->close();
    $stmt_update_movimiento->close();

    return true;
}








function obtenerHistorialMovimientos()
{
    $conn = conectar();

    $sql = "
        SELECT 
            hm.id_movimiento_historial,
            hm.id_movimiento,
            tr.nomyap_persona AS transferente,
            rc.nomyap_persona AS receptor,
            dt.descripcion_dependencia AS dependencia,
            dd.descripcion_dependencia AS dependencia_destino,
            at.descripcion_area AS area_trans,
            ad.descripcion_area AS area_des,
            hm.fecha_movimiento,
            hm.archivo_movimiento_actual AS archivo_historial
        FROM historial_movimiento hm
        LEFT JOIN persona tr ON hm.id_transferente_movimiento = tr.id_persona
        LEFT JOIN persona rc ON hm.id_receptor_movimiento = rc.id_persona
        LEFT JOIN dependencia dt ON hm.id_dependencia_transferente_movimiento = dt.id_dependencia
        LEFT JOIN dependencia dd ON hm.id_dependencia_receptor_movimiento = dd.id_dependencia
        LEFT JOIN area at ON hm.id_area_transferente_movimiento = at.id_area
        LEFT JOIN area ad ON hm.id_area_receptor_movimiento = ad.id_area
        ORDER BY hm.fecha_movimiento DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultados = [];
    while ($row = $result->fetch_assoc()) {
        $resultados[] = $row;
    }

    return $resultados;
}


function obtener_detalle_historial_reasignacion($idHistorial) {
    $conn = conectar();

    $sql = "
        SELECT 
            b.id_bien,
            b.equipo_bien,
            b.marca_bien,
            b.modelo_bien,
            b.procesador_bien,
            b.numdeserie_bien,
            b.numcontropatri_bien,
            b.funcionamiento,
            b.observacion_bien,
            b.estado_bien,
            b.costo_bien,
            b.añodeadqs_bien,
            b.numdeordendecom_bien,

            ar.descripcion_area AS area_destino,
            dp.descripcion_dependencia AS dependencia_destino,

            hm.fecha_movimiento_actual AS fecha_reasignacion,
            hm.archivo_movimiento_actual AS archivo_pdf

        FROM historial_movimiento hm
        LEFT JOIN bien b ON hm.id_bien_desvinculado = b.id_bien
        LEFT JOIN area ar ON hm.id_area_receptor_movimiento = ar.id_area
        LEFT JOIN dependencia dp ON hm.id_dependencia_receptor_movimiento = dp.id_dependencia
        WHERE hm.id_movimiento_historial = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idHistorial); // "i" indica que es un parámetro entero
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC); // Si esperas múltiples filas
}

function obtener_bienes_desvinculados($id_movimiento) {
    $conn = conectar();
    $sql = "SELECT id_bien_desvinculado 
            FROM historial_movimiento 
            WHERE id_movimiento = ? 
              AND estado_movimiento = 2";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();

    $result = $stmt->get_result();
    $bienes = [];

    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row['id_bien_desvinculado'];
    }

    $stmt->close();
    $conn->close();

    return $bienes;
}




function obtener_estado_movimiento($id_movimiento) {
    $conn = conectar();
    $sql = "SELECT estado_movimiento FROM movimiento WHERE id_movimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_movimiento);
    $stmt->execute();
    $stmt->bind_result($estado);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $estado;
}



// AD/ad.php
function obtener_asignacion_bien($id_bien) {
    $conn = conectar();

    $sql = "SELECT 
            dm.id_detallemovimiento,
            p.nomyap_persona AS transferente,
            p2.nomyap_persona AS receptor,
            d1.descripcion_dependencia AS dependencia_transferente,
            d2.descripcion_dependencia AS dependencia_receptora,
            a1.descripcion_area AS area_transferente,
            a2.descripcion_area AS area_receptora,
            m.fecha_movimiento,
            m.archivo_movimiento
        FROM detallemovimiento dm
        INNER JOIN movimiento m ON m.id_movimiento = dm.id_mov_detallemovimiento
        INNER JOIN persona p ON p.id_persona = m.id_transferente_movimiento
        INNER JOIN persona p2 ON p2.id_persona = m.id_receptor_movimiento
        INNER JOIN dependencia d1 ON d1.id_dependencia = m.id_dependencia_transferente_movimiento
        INNER JOIN dependencia d2 ON d2.id_dependencia = m.id_dependencia_receptor_movimiento
        INNER JOIN area a1 ON a1.id_area = m.id_area_transferente_movimiento
        INNER JOIN area a2 ON a2.id_area = m.id_area_receptor_movimiento
        WHERE dm.id_bien_detmov = ? 
          AND dm.estado_detalle_movimiento = 1
        ORDER BY m.fecha_movimiento DESC
        LIMIT 1";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bien);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}






function restablecer_contrasena($id_usuario, $nueva_contrasena)
{
    $conn = conectar();
    $clave_md5 = md5($nueva_contrasena);

    $sql = "UPDATE usuario SET clave_usuario = ? WHERE id_usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('si', $clave_md5, $id_usuario);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    return true;
}









function obtenerEquiposConUbicacionPorPiso($piso = 1) {
    $conn = conectar();

    // Validar el piso
    $piso = (int)$piso;
    if (!in_array($piso, [1, 2, 3])) {
        $piso = 1;
    }

    $sql = "SELECT ue.id_ubicacion_equipos,
                   ue.ip_ubicacion_equipos,
                   ue.mac_ubicacion_equipos,
                   ue.id_bien,
                   ue.id_persona,
                   ue.id_area,
                   ue.estado_conexion,
                   ue.ultima_deteccion,
                   ue.piso,
                   ue.pos_x,
                   ue.pos_y,
                   ue.nivel_toner,
                   ue.nivel_kit_mantenimiento,
                   ue.nivel_unidad_imagen,
                   ue.ultima_lectura_suministros,
                   p.nomyap_persona, 
                   a.descripcion_area,
                   b.equipo_bien,
                   b.marca_bien,
                   b.modelo_bien,
                   b.procesador_bien,
                   b.numdeserie_bien,
                   b.numcontropatri_bien,
                   b.estado_bien,
                   b.añodeadqs_bien,
                   b.numdeordendecom_bien,
                   b.observacion_bien,
                   b.costo_bien,
                   b.funcionamiento
            FROM ubicacion_equipos ue
            LEFT JOIN persona p ON ue.id_persona = p.id_persona
            LEFT JOIN area a ON ue.id_area = a.id_area
            LEFT JOIN bien b ON ue.id_bien = b.id_bien
            WHERE ue.piso = ?
            ORDER BY ue.estado_conexion DESC, b.equipo_bien ASC, ue.ip_ubicacion_equipos ASC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparando consulta por piso: " . $conn->error);
        $conn->close();
        return false;
    }

    $stmt->bind_param('i', $piso);

    if (!$stmt->execute()) {
        error_log("Error ejecutando consulta por piso: " . $stmt->error);
        $stmt->close();
        $conn->close();
        return false;
    }

    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    return $result;
}
function obtenerEstadisticasEquiposPorPiso() {
    $conn = conectar();

    $sql = "SELECT 
                piso,
                COUNT(*) as total_equipos,
                SUM(CASE WHEN estado_conexion = 1 THEN 1 ELSE 0 END) as equipos_conectados,
                SUM(CASE WHEN estado_conexion = 0 THEN 1 ELSE 0 END) as equipos_desconectados
            FROM ubicacion_equipos 
            WHERE piso IN (1, 2, 3)
            GROUP BY piso
            ORDER BY piso";

    $result = $conn->query($sql);
    $estadisticas = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $estadisticas[$row['piso']] = [
                'total_equipos' => $row['total_equipos'],
                'equipos_conectados' => $row['equipos_conectados'],
                'equipos_desconectados' => $row['equipos_desconectados']
            ];
        }
    }

    $conn->close();
    return $estadisticas;
}
function registrarLogCoordenadas($operacion, $detalles, $nivel = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario'] ?? 'Sistema';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';

    $logMessage = "[{$timestamp}] [{$nivel}] Usuario: {$usuario} | IP: {$ip} | {$operacion} | {$detalles}" . PHP_EOL;

    // Crear directorio de logs si no existe
    if (!file_exists('../logs')) {
        mkdir('../logs', 0777, true);
    }

    error_log($logMessage, 3, '../logs/coordenadas.log');
}
function actualizarMultiplesCoordenadas($coordinates) {
    $conn = conectar();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Error de conexión a la base de datos',
            'updated_count' => 0,
            'errors' => ['No se pudo conectar a la base de datos']
        ];
    }

    // Verificar que haya coordenadas para procesar
    if (empty($coordinates)) {
        $conn->close();
        return [
            'success' => true,
            'message' => 'No hay coordenadas para actualizar',
            'updated_count' => 0,
            'errors' => []
        ];
    }

    // Iniciar transacción
    $conn->autocommit(false);

    $updated_count = 0;
    $errors = [];

    try {
        $sql = "UPDATE ubicacion_equipos SET pos_x = ?, pos_y = ? WHERE id_ubicacion_equipos = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $conn->error);
        }

        foreach ($coordinates as $coord) {
            // Validar estructura de datos
            if (!isset($coord['id']) || !isset($coord['x']) || !isset($coord['y'])) {
                $errors[] = "Coordenada inválida: faltan campos requeridos";
                continue;
            }

            $equipoId = intval($coord['id']);
            $posX = intval($coord['x']);
            $posY = intval($coord['y']);

            // Validaciones
            if ($equipoId <= 0) {
                $errors[] = "ID de equipo inválido: {$equipoId}";
                continue;
            }

            if ($posX < 0 || $posY < 0) {
                $errors[] = "Coordenadas inválidas para equipo {$equipoId}: ({$posX}, {$posY})";
                continue;
            }

            // Ejecutar actualización
            $stmt->bind_param('iii', $posX, $posY, $equipoId);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $updated_count++;
                } else {
                    // Verificar si el equipo existe
                    if (existeEquipo($equipoId)) {
                        // El equipo existe pero no se actualizó (tal vez las coordenadas son las mismas)
                        $updated_count++;
                    } else {
                        $errors[] = "No se encontró el equipo con ID: {$equipoId}";
                    }
                }
            } else {
                $errors[] = "Error al actualizar equipo {$equipoId}: " . $stmt->error;
            }
        }

        $stmt->close();

        // Siempre confirmar la transacción si llegamos hasta aquí
        $conn->commit();

        $response = [
            'success' => true,
            'message' => "Se procesaron {$updated_count} coordenadas exitosamente",
            'updated_count' => $updated_count,
            'errors' => $errors
        ];

    } catch (Exception $e) {
        // Rollback en caso de error
        $conn->rollback();

        $response = [
            'success' => false,
            'message' => 'Error interno: ' . $e->getMessage(),
            'updated_count' => 0,
            'errors' => array_merge($errors, [$e->getMessage()])
        ];
    } finally {
        // Restaurar autocommit y cerrar conexión
        $conn->autocommit(true);
        $conn->close();
    }

    return $response;
}
function existeEquipo($equipoId) {
    $conn = conectar();

    $sql = "SELECT COUNT(*) as count FROM ubicacion_equipos WHERE id_ubicacion_equipos = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $conn->close();
        return false;
    }

    $stmt->bind_param('i', $equipoId);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existe = $row['count'] > 0;

    $stmt->close();
    $conn->close();

    return $existe;
}
function logDebugCoordenadas($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}\n";
    file_put_contents('coordinates_debug.log', $logMessage, FILE_APPEND | LOCK_EX);
}


// ===== FUNCIÓN EDITARUBICACIONEQUIPO CORREGIDA =====
function editarUbicacionEquipo($id_ubicacion_equipos, $ip, $mac, $id_categoria, $id_bien, $id_persona, $id_area, $estado_conexion, $ultima_deteccion, $piso, $pos_x, $pos_y) {
    $conn = conectar();

    // Verificar que el equipo existe
    if (!verificarExistenciaEquipo($id_ubicacion_equipos)) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'El equipo no existe'
        ];
    }

    // Validación de duplicados excluyendo el ID actual
    $errores = [];

    // Verificar IP duplicada (solo si tiene un valor válido)
    if (!empty($ip) && $ip !== '-' && $ip !== null) {
        $stmt_ip = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE ip_ubicacion_equipos = ? AND id_ubicacion_equipos != ?");
        $stmt_ip->bind_param("si", $ip, $id_ubicacion_equipos);
        $stmt_ip->execute();
        $result_ip = $stmt_ip->get_result();

        if ($result_ip->num_rows > 0) {
            $errores[] = "La IP {$ip} ya está registrada en otro equipo";
        }
        $stmt_ip->close();
    }

    // Verificar MAC duplicada (solo si tiene un valor válido)
    if (!empty($mac) && $mac !== '-' && $mac !== null) {
        $stmt_mac = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE mac_ubicacion_equipos = ? AND id_ubicacion_equipos != ?");
        $stmt_mac->bind_param("si", $mac, $id_ubicacion_equipos);
        $stmt_mac->execute();
        $result_mac = $stmt_mac->get_result();

        if ($result_mac->num_rows > 0) {
            $errores[] = "La MAC {$mac} ya está registrada en otro equipo";
        }
        $stmt_mac->close();
    }

    // Verificar bien duplicado (si no está vacío)
    if (!empty($id_bien)) {
        $stmt_bien = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE id_bien = ? AND id_ubicacion_equipos != ?");
        $stmt_bien->bind_param("ii", $id_bien, $id_ubicacion_equipos);
        $stmt_bien->execute();
        $result_bien = $stmt_bien->get_result();

        if ($result_bien->num_rows > 0) {
            $errores[] = "Este bien ya está asignado a otro equipo";
        }
        $stmt_bien->close();
    }

    // Si hay errores de duplicados, retornar error
    if (!empty($errores)) {
        $conn->close();
        return [
            'success' => false,
            'message' => implode(', ', $errores),
            'type' => 'duplicate'
        ];
    }

    // Usar NULL para valores vacíos o por defecto
    $ip = (empty($ip) || $ip === '-') ? null : $ip;
    $mac = (empty($mac) || $mac === '-') ? null : $mac;
    $id_categoria = empty($id_categoria) ? null : $id_categoria; // AGREGADO
    $id_bien = empty($id_bien) ? null : $id_bien;
    $id_persona = empty($id_persona) ? null : $id_persona;
    $id_area = empty($id_area) ? null : $id_area;
    $ultima_deteccion = empty($ultima_deteccion) ? null : $ultima_deteccion;

    // CORRECCIÓN: Incluir id_categoria en la actualización
    $stmt = $conn->prepare("UPDATE ubicacion_equipos SET 
        ip_ubicacion_equipos = ?, 
        mac_ubicacion_equipos = ?,
        id_categoria = ?,
        id_bien = ?, 
        id_persona = ?, 
        id_area = ?, 
        estado_conexion = ?, 
        ultima_deteccion = ?, 
        piso = ?, 
        pos_x = ?, 
        pos_y = ?
        WHERE id_ubicacion_equipos = ?");

    $stmt->bind_param("ssiiiisisiii", $ip, $mac, $id_categoria, $id_bien, $id_persona, $id_area, $estado_conexion, $ultima_deteccion, $piso, $pos_x, $pos_y, $id_ubicacion_equipos);

    $ok = $stmt->execute();

    if ($ok) {
        $stmt->close();
        $conn->close();

        return [
            'success' => true,
            'message' => 'Equipo actualizado correctamente'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();

        return [
            'success' => false,
            'message' => 'Error al actualizar: ' . $error
        ];
    }
}

function obtenerBienes() {
    $conn = conectar();
    $sql = "SELECT id_bien, equipo_bien, marca_bien, modelo_bien FROM bien WHERE estado_bien = 1";
    $result = $conn->query($sql);
    $bienes = [];
    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row;
    }
    $conn->close();
    return $bienes;
}

function obtenerPersonas() {
    $conn = conectar();
    $sql = "SELECT id_persona, nomyap_persona, dni_persona FROM persona WHERE estado_persona = 1";
    $result = $conn->query($sql);
    $personas = [];
    while ($row = $result->fetch_assoc()) {
        $personas[] = $row;
    }
    $conn->close();
    return $personas;
}

function obtenerAreas() {
    $conn = conectar();
    $sql = "SELECT id_area, descripcion_area, organo FROM area WHERE estado_area = 1";
    $result = $conn->query($sql);
    $areas = [];
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row;
    }
    $conn->close();
    return $areas;
}

function obtenerCategorias() {
    $conn = conectar();
    $sql = "SELECT id_nombre_bien, des_nombre_bien 
            FROM nombre_bien 
            WHERE estado_nombre_bien = 1";
    $result = $conn->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    $conn->close();
    return $categorias;
}

function obtenerBienesPorCategoria($idCategoria) {
    $conn = conectar();
    $stmt = $conn->prepare("SELECT id_bien, marca_bien, modelo_bien, numcontropatri_bien 
                            FROM bien 
                            WHERE equipo_bien = ? AND estado_bien = 1");
    $stmt->bind_param("i", $idCategoria);
    $stmt->execute();
    $result = $stmt->get_result();
    $bienes = [];
    while ($row = $result->fetch_assoc()) {
        $bienes[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $bienes;
}



// Agregar esta función al archivo ../AD/ad.php

// ===== FUNCIÓN INSERTARUBICACIONEQUIPO CORREGIDA =====
function insertarUbicacionEquipo($ip, $mac, $id_categoria, $id_bien, $id_persona, $id_area, $estado, $ultima, $piso, $pos_x, $pos_y) {
    $conn = conectar();

    // Validación simple de duplicados sin función externa
    $errores = [];

    // Verificar IP duplicada (solo si tiene un valor válido diferente de vacío, null, o "-")
    if (!empty($ip) && $ip !== '-' && $ip !== null) {
        $stmt_ip = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE ip_ubicacion_equipos = ?");
        $stmt_ip->bind_param("s", $ip);
        $stmt_ip->execute();
        $result_ip = $stmt_ip->get_result();

        if ($result_ip->num_rows > 0) {
            $errores[] = "La IP {$ip} ya está registrada";
        }
        $stmt_ip->close();
    }

    // Verificar MAC duplicada (solo si tiene un valor válido diferente de vacío, null, o "-")
    if (!empty($mac) && $mac !== '-' && $mac !== null) {
        $stmt_mac = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE mac_ubicacion_equipos = ?");
        $stmt_mac->bind_param("s", $mac);
        $stmt_mac->execute();
        $result_mac = $stmt_mac->get_result();

        if ($result_mac->num_rows > 0) {
            $errores[] = "La MAC {$mac} ya está registrada";
        }
        $stmt_mac->close();
    }

    // Verificar bien duplicado (si no está vacío)
    if (!empty($id_bien)) {
        $stmt_bien = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE id_bien = ?");
        $stmt_bien->bind_param("i", $id_bien);
        $stmt_bien->execute();
        $result_bien = $stmt_bien->get_result();

        if ($result_bien->num_rows > 0) {
            $errores[] = "Este bien ya está asignado a otro equipo";
        }
        $stmt_bien->close();
    }

    // Si hay errores de duplicados, retornar error
    if (!empty($errores)) {
        $conn->close();
        return [
            'success' => false,
            'message' => implode(', ', $errores),
            'type' => 'duplicate'
        ];
    }

    // Usar NULL para valores vacíos o por defecto
    $ip = (empty($ip) || $ip === '-') ? null : $ip;
    $mac = (empty($mac) || $mac === '-') ? null : $mac;
    $id_categoria = empty($id_categoria) ? null : $id_categoria; // AGREGADO
    $id_bien = empty($id_bien) ? null : $id_bien;
    $id_persona = empty($id_persona) ? null : $id_persona;
    $id_area = empty($id_area) ? null : $id_area;
    $ultima = empty($ultima) ? null : $ultima;

    // CORRECCIÓN: Incluir id_categoria en la inserción
    $stmt = $conn->prepare("INSERT INTO ubicacion_equipos (
        ip_ubicacion_equipos, 
        mac_ubicacion_equipos,
        id_categoria,
        id_bien, 
        id_persona, 
        id_area, 
        estado_conexion, 
        ultima_deteccion, 
        piso, 
        pos_x, 
        pos_y
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssiiiisisii", $ip, $mac, $id_categoria, $id_bien, $id_persona, $id_area, $estado, $ultima, $piso, $pos_x, $pos_y);

    $ok = $stmt->execute();

    if ($ok) {
        $nuevo_id = $conn->insert_id;
        $stmt->close();
        $conn->close();

        return [
            'success' => true,
            'id' => $nuevo_id,
            'message' => 'Equipo agregado correctamente'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();

        return [
            'success' => false,
            'message' => 'Error al insertar: ' . $error
        ];
    }
}



/**
 * Verifica si existe un equipo con el ID dado
 * @param int $id_ubicacion_equipos
 * @return bool
 */
function verificarExistenciaEquipo($id_ubicacion_equipos) {
    $conn = conectar();
    $stmt = $conn->prepare("SELECT id_ubicacion_equipos FROM ubicacion_equipos WHERE id_ubicacion_equipos = ?");
    $stmt->bind_param("i", $id_ubicacion_equipos);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $existe = $resultado->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $existe;
}

/**
 * Elimina un equipo de la tabla ubicacion_equipos
 * @param int $id_ubicacion_equipos
 * @return bool
 */
function eliminarUbicacionEquipo($id_ubicacion_equipos) {
    $conn = conectar();
    $stmt = $conn->prepare("DELETE FROM ubicacion_equipos WHERE id_ubicacion_equipos = ?");
    $stmt->bind_param("i", $id_ubicacion_equipos);
    $ok = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $ok;
}

/**
 * Verifica si una IP ya existe en la base de datos
 * @param string $ip - Dirección IP a verificar
 * @param int $excluir_id - ID del registro a excluir de la búsqueda (para ediciones)
 * @return bool - true si existe, false si no existe
 */
/**
 * Verifica si una IP ya existe en la base de datos
 * CORREGIDO para usar la estructura real de la BD
 */
function existeIP($ip, $excluir_id = null) {
    // Si la IP es por defecto, no validar duplicados
    if (empty($ip) || $ip === '-') {
        return false;
    }

    $conn = conectar();

    // CORRECCIÓN: usar equipo_bien en lugar de id_categoria
    $sql = "SELECT COUNT(*) as count FROM ubicacion_equipos ue 
            LEFT JOIN bien b ON ue.id_bien = b.id_bien 
            WHERE ue.ip_ubicacion_equipos = ? 
            AND (b.equipo_bien IN (1, 4, 5) OR b.equipo_bien IS NULL)";

    $params = [$ip];
    $types = "s";

    if ($excluir_id !== null) {
        $sql .= " AND ue.id_ubicacion_equipos != ?";
        $params[] = $excluir_id;
        $types .= "i";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existe = $row['count'] > 0;

    $stmt->close();
    $conn->close();

    return $existe;
}

/**
 * Verifica si una MAC ya existe en la base de datos
 * @param string $mac - Dirección MAC a verificar
 * @param int $excluir_id - ID del registro a excluir de la búsqueda (para ediciones)
 * @return bool - true si existe, false si no existe
 */
function existeMAC($mac, $excluir_id = null) {
    // Si la MAC es por defecto, no validar duplicados
    if (empty($mac) || $mac === '-') {
        return false;
    }

    $conn = conectar();

    // CORRECCIÓN: usar equipo_bien en lugar de id_categoria
    $sql = "SELECT COUNT(*) as count FROM ubicacion_equipos ue 
            LEFT JOIN bien b ON ue.id_bien = b.id_bien 
            WHERE ue.mac_ubicacion_equipos = ? 
            AND (b.equipo_bien IN (1, 4, 5) OR b.equipo_bien IS NULL)";

    $params = [$mac];
    $types = "s";

    if ($excluir_id !== null) {
        $sql .= " AND ue.id_ubicacion_equipos != ?";
        $params[] = $excluir_id;
        $types .= "i";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existe = $row['count'] > 0;

    $stmt->close();
    $conn->close();

    return $existe;
}

/**
 * Verifica si un bien ya está asignado a otro equipo
 * @param int $id_bien - ID del bien a verificar
 * @param int $excluir_id - ID del registro a excluir de la búsqueda (para ediciones)
 * @return bool - true si existe, false si no existe
 */
function existeBien($id_bien, $excluir_id = null) {
    if (!$id_bien) return false; // Si no hay bien asignado, no hay conflicto

    $conn = conectar();

    $sql = "SELECT COUNT(*) as count FROM ubicacion_equipos WHERE id_bien = ?";
    $params = [$id_bien];
    $types = "i";

    if ($excluir_id !== null) {
        $sql .= " AND id_ubicacion_equipos != ?";
        $params[] = $excluir_id;
        $types .= "i";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existe = $row['count'] > 0;

    $stmt->close();
    $conn->close();

    return $existe;
}

/**
 * Valida todos los campos únicos de una vez
 * @param string $ip - Dirección IP
 * @param string $mac - Dirección MAC
 * @param int $id_bien - ID del bien (puede ser null)
 * @param int $excluir_id - ID del registro a excluir (para ediciones)
 * @return array - Array con los errores encontrados
 */
function validarDuplicados($ip, $mac, $id_bien = null, $excluir_id = null, $id_categoria = null) {
    $errores = [];

    // Definir categorías que requieren validación de network
    $categorias_network = [1, 4, 5]; // CPU, Laptop, Impresora

    // Si se proporciona categoría y no requiere network, skip validación de IP/MAC
    if ($id_categoria !== null && !in_array((int)$id_categoria, $categorias_network)) {
        // Solo validar bien para estas categorías
        if ($id_bien && existeBien($id_bien, $excluir_id)) {
            $errores[] = "El bien seleccionado ya está asignado a otro equipo";
        }
        return $errores;
    }

    // Para categorías que sí requieren network o cuando no se especifica categoría
    // AGREGADA VALIDACIÓN: Para categorías de network, IP y MAC son OBLIGATORIOS
    if ($id_categoria !== null && in_array((int)$id_categoria, $categorias_network)) {
        if (empty($ip) || $ip === '-') {
            $errores[] = "La IP es obligatoria para este tipo de equipo";
        }
        if (empty($mac) || $mac === '-') {
            $errores[] = "La MAC es obligatoria para este tipo de equipo";
        }
    }

    // Validar duplicados si los campos tienen valores válidos
    if (!empty($ip) && $ip !== '-' && existeIP($ip, $excluir_id)) {
        $errores[] = "La dirección IP '{$ip}' ya está registrada en otro equipo";
    }

    if (!empty($mac) && $mac !== '-' && existeMAC($mac, $excluir_id)) {
        $errores[] = "La dirección MAC '{$mac}' ya está registrada en otro equipo";
    }

    if ($id_bien && existeBien($id_bien, $excluir_id)) {
        $errores[] = "El bien seleccionado ya está asignado a otro equipo";
    }

    return $errores;
}

/**
 * Función para validar en tiempo real desde AJAX (para el frontend)
 */
function validarDuplicadosAjax($ip, $mac, $id_bien = null, $excluir_id = null) {
    $conn = conectar();

    try {
        $errores = [];

        // Si ambos valores son por defecto o vacíos, no hay duplicados
        if ((empty($ip) || $ip === '-') && (empty($mac) || $mac === '-')) {
            return [
                'success' => true,
                'message' => 'Sin validaciones necesarias'
            ];
        }

        $condiciones = [];
        $params = [];
        $types = "";

        // Solo verificar duplicados si los valores no son por defecto "-"
        if (!empty($ip) && $ip !== '-') {
            $condiciones[] = "ue.ip_ubicacion_equipos = ?";
            $params[] = $ip;
            $types .= "s";
        }

        if (!empty($mac) && $mac !== '-') {
            $condiciones[] = "ue.mac_ubicacion_equipos = ?";
            $params[] = $mac;
            $types .= "s";
        }

        // Si no hay condiciones válidas, no hay duplicados
        if (empty($condiciones)) {
            return [
                'success' => true,
                'message' => 'Sin validaciones necesarias'
            ];
        }

        // CORRECCIÓN: usar equipo_bien en lugar de id_categoria
        $sql = "SELECT ue.id_ubicacion_equipos, ue.ip_ubicacion_equipos, ue.mac_ubicacion_equipos, 
                       b.equipo_bien as categoria
                FROM ubicacion_equipos ue 
                LEFT JOIN bien b ON ue.id_bien = b.id_bien
                WHERE (" . implode(" OR ", $condiciones) . ")
                AND (b.equipo_bien IN (1, 4, 5) OR b.equipo_bien IS NULL)";

        // Excluir el ID actual si se proporciona (para edición)
        if ($excluir_id > 0) {
            $sql .= " AND ue.id_ubicacion_equipos != ?";
            $params[] = $excluir_id;
            $types .= "i";
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $duplicado = $result->fetch_assoc();

            $mensajes = [];
            if (!empty($ip) && $ip !== '-' && $duplicado['ip_ubicacion_equipos'] === $ip) {
                $mensajes[] = "la IP: $ip";
            }
            if (!empty($mac) && $mac !== '-' && $duplicado['mac_ubicacion_equipos'] === $mac) {
                $mensajes[] = "la MAC: $mac";
            }

            $mensaje = "Ya existe un equipo con " . implode(" y ", $mensajes);

            return [
                'success' => false,
                'errors' => [$mensaje],
                'type' => 'duplicate',
                'duplicado_id' => $duplicado['id_ubicacion_equipos']
            ];
        }

        return [
            'success' => true,
            'message' => 'No se encontraron duplicados'
        ];

    } catch (Exception $e) {
        error_log("Error en validarDuplicadosAjax: " . $e->getMessage());
        return [
            'success' => false,
            'errors' => ['Error al validar duplicados: ' . $e->getMessage()],
            'type' => 'system'
        ];
    } finally {
        $conn->close();
    }
}

?>

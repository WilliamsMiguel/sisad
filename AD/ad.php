<?php
// AD/ad.php

function conectar() {
    $servername = "localhost";
    $username = "root";
    $password = "784512**";
    $dbname = "sisadbd";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

function validar_usuario($nombre_usuario, $clave_usuario) {
    $conn = conectar();
    //$sql = "SELECT * FROM usuario WHERE nombre_u = ? AND clave_u = ? AND estado_u = 1";
    $sql = "SELECT id_usuario, nombre_usuario, id_persona_usuario FROM usuario WHERE nombre_usuario = ? AND clave_usuario = ? AND estado_usuario = 1";
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

function registrar_datos($descripcion_area, $descripcion_depen, $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien,$numdeserie_bien, $numcontropatri_bien, $estado_bien, $añodeadqs_bien, $numdeordendecom_bien, $observacion_bien, $nomyap_p, $dni_p, $cell_persona, $correo_persona, $dir_persona, $descripcion_menu, $nombrearchivo_menu) 
{
    $conn = conectar();

    // Solo registrar las áreas si tienen datos
    if ($descripcion_area) 
    {
        $sql_area = "INSERT INTO area (descripcion_area, estado_area) VALUES (?, 1)";
        $stmt_area = $conn->prepare($sql_area);
        $stmt_area->bind_param('s', $descripcion_area);
        $stmt_area->execute();
    }

    // Registrar dependencias
    if ($descripcion_depen) 
    {
        $sql_depen = "INSERT INTO dependencia (descripcion_dependencia, estado_dependencia) VALUES (?, 1)";
        $stmt_depen = $conn->prepare($sql_depen);
        $stmt_depen->bind_param('s', $descripcion_depen);
        $stmt_depen->execute();
    }

    // Registrar bienes
    if ($equipo_bien && $marca_bien && $modelo_bien && $procesador_bien && $numdeserie_bien && $numcontropatri_bien && $estado_bien && $añodeadqs_bien && $numdeordendecom_bien && $observacion_bien) 
    {
        $sql_bien = "INSERT INTO bien (equipo_bien, marca_bien, modelo_bien, procesador_bien, numdeserie_bien, numcontropatri_bien, estado_bien, añodeadqs_bien, numdeordendecom_bien, observacion_bien) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_bien = $conn->prepare($sql_bien);
        $stmt_bien->bind_param('ssssssisss', $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien, $numdeserie_bien, $numcontropatri_bien, $estado_bien, $añodeadqs_bien, $numdeordendecom_bien, $observacion_bien);
        $stmt_bien->execute();
    }

    // Registrar personas
    if ($nomyap_p && $dni_p && $cell_persona && $correo_persona && $dir_persona) {
        $sql_persona = "INSERT INTO persona (nomyap_persona, dni_persona, cell_persona, correo_persona, dir_persona, estado_persona) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bind_param('sssss', $nomyap_p, $dni_p, $cell_persona ,$correo_persona ,$dir_persona);
        $stmt_persona->execute();
    }

    // Registrar menú
    if ($descripcion_menu && $nombrearchivo_menu) {
        $sql_menu = "INSERT INTO menu (descripcion_menu, nombrearchivo_menu, estado_menu) VALUES (?, ?, 1)";
        $stmt_menu = $conn->prepare($sql_menu);
        $stmt_menu->bind_param('ss', $descripcion_menu, $nombrearchivo_menu);
        $stmt_menu->execute();
    }

    $conn->close();

    return true;
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
    $sql = "SELECT * FROM bien";
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
    $sql = "SELECT * FROM menu";
    $resultado = $conn->query($sql);

    $menuss = [];
    while ($fila = $resultado->fetch_assoc()) 
    {
        $menuss[] = $fila;
    }
    $conn->close();
    return $menuss;
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

 
function registrar_usuario($id_persona_usuario, $nombre_usuario, $clave_usuario, $estado_usuario) 
{
    // Conexión a la base de datos
    $conn = conectar();
    $clave_md5 = md5($clave_usuario);

    // Preparar la consulta SQL e insertar el usuario
    $sql = "INSERT INTO usuario (id_persona_usuario, nombre_usuario, clave_usuario, estado_usuario) VALUES (?, ?, ?, ?)";
    
    // Usar la sentencia preparada de MySQLi
    if ($stmt = $conn->prepare($sql)) {
        // Asignar los parámetros
        $stmt->bind_param('issi', $id_persona_usuario, $nombre_usuario, $clave_md5, $estado_usuario);

        // Ejecutar y cerrar la sentencia
        $stmt->execute();
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();

    // Retornar true siempre que se intente registrar
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



function registrar_movimiento($id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptora, $id_area_transferente, $id_area_receptora, $fecha_movimiento, $archivo_movimiento) {
    $conn = conectar();

    $sql = "INSERT INTO movimiento 
                (id_transferente_movimiento, id_receptor_movimiento, id_dependencia_transferente_movimiento, id_dependencia_receptor_movimiento, id_area_transferente_movimiento, id_area_receptor_movimiento, fecha_movimiento, archivo_movimiento)
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiiiisss', $id_transferente, $id_receptor, $id_dependencia_transferente, $id_dependencia_receptora, $id_area_transferente, $id_area_receptora, $fecha_movimiento, $archivo_movimiento);
    $stmt->execute();
    $stmt->close();
}

?>

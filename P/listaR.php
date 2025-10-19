<?php
// P/listP.php

include '../LN/ln_listaR.php'; // Incluye la lógica de negocio

// Obtener las listas de registros
$areas = obtener_areas();
$dependencia = obtener_dependencias();
$bienes = obtener_bienes();
$persona = obtener_personas();
$menus = obtener_menuss();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar y Editar Registros</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function actualizarRegistro(tabla, id, campo, valor) {
            $.ajax({
               

                url: '../LN/ln_actualizarListaR.php',
                type: 'POST',
                data: { tabla: tabla, id: id, campo: campo, valor: valor },
                success: function(response) {
                    //alert('Registro actualizado correctamente.');
                    //alert(campo);
                },
                error: function() {
                    alert('Error al actualizar el registro.');
                }
            });
        }
        
        function cambiarEstado(tabla, id, estado) {
            $.ajax({
                url: '../LN/ln_actualizar_estadoListaR.php',
                type: 'POST',
                data: { tabla: tabla, id: id, estado: estado },
                success: function(response) {
                    alert('Estado cambiado correctamente.');
                },
                error: function() {
                    alert('Error al cambiar el estado.');
                }
            });
        }
    </script>
</head>
<body class="container mt-5">
    <h1 class="text-center">Listar y Editar Registros</h1>

    <!-- Listar Áreas -->
    <h2>Áreas</h2>
    <table class="table" border=0>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Estado</th>
                 
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
            <tr>
                <td contenteditable="true" onBlur="actualizarRegistro('area', '<?php echo $area['id_area']; ?>', 'descripcion_area', this.innerText)">
                    <?php echo $area['descripcion_area']; ?>
                    
                </td>
                <td><?php echo $area['estado_area'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td><button onclick="cambiarEstado('area', '<?php echo $area['id_area']; ?>', '<?php echo $area['estado_area'] == 1 ? 0 : 1; ?>')" class="btn btn-warning">
                    <?php echo $area['estado_area'] == 1 ? 'Inactivar' : 'Activar'; ?>
                </button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Repetir la misma estructura para dependencias, bienes, personas y menús -->
    <!-- Por ejemplo, aquí para Dependencias -->

    <h2>Dependencias</h2>
    <table class="table" border=0>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Estado</th>
                 
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dependencia as $dependencia): ?>
            <tr>
                <td contenteditable="true" onBlur="actualizarRegistro('dependencia', '<?php echo $dependencia['id_dependencia']; ?>', 'descripcion_dependencia', this.innerText)">
                    <?php 
                    echo $dependencia['descripcion_dependencia'];
                    
                    ?>
                     
                </td>
                <td><?php echo $dependencia['estado_dependencia'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td><button onclick="cambiarEstado('dependencia', '<?php echo $dependencia['id_dependencia']; ?>', '<?php echo $dependencia['estado_dependencia'] == 1 ? 0 : 1; ?>')" class="btn btn-warning">
                    <?php echo $dependencia['estado_dependencia'] == 1 ? 'Inactivar' : 'Activar'; ?>
                </button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Sección similar para los bienes, personas y menús -->

    <h2>Menús</h2>
    <table class="table" border=0>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Estado</th>
                 
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $menus): ?>
            <tr>
                <td contenteditable="true" onBlur="actualizarRegistro('menu', '<?php echo $menus['id_menu']; ?>', 'descripcion_menu', this.innerText)">
                    <?php echo $menus['descripcion_menu']; ?>
                </td>
                <td><?php echo $menus['estado_menu'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td><button onclick="cambiarEstado('menu', '<?php echo $menus['id_menu']; ?>', '<?php echo $menus['estado_menu'] == 1 ? 0 : 1; ?>')" class="btn btn-warning">
                    <?php echo $menus['estado_menu'] == 1 ? 'Inactivar' : 'Activar'; ?>
                </button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <!-- Sección similar para los bienes, personas y menús -->

    <h2>Personas</h2>
    <table class="table" border=0>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>DNI</th>
                <th>Estado</th>
                 
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($persona as $persona): ?>
            <tr>
                <td contenteditable="true" onBlur="actualizarRegistro('persona', '<?php echo $persona['id_persona']; ?>', 'nomyap_persona', this.innerText)">
                    <?php echo $persona['nomyap_persona']; ?>
                </td>

                <td contenteditable="true" onBlur="actualizarRegistro('persona', '<?php echo $persona['id_persona']; ?>', 'dni_persona', this.innerText)">
                    <?php echo $persona['dni_persona']; ?>
                </td>

                <td><?php echo $persona['estado_persona'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td>
                    <button onclick="cambiarEstado('persona', '<?php echo $persona['id_persona']; ?>', '<?php echo $persona['estado_persona'] == 1 ? 0 : 1; ?>')" class="btn btn-warning">
                    <?php echo $persona['estado_persona'] == 1 ? 'Inactivar' : 'Activar'; ?>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>
</html>

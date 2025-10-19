<?php 
include '../LN/ln_listarPerUserR.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .seccion {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#usuarioForm').on('submit', function(e) 
            {
                e.preventDefault(); // Evitar el envío normal del formulario
                var formData = $(this).serialize();

                $.ajax({
                    url: '../LN/ln_registrar_usuario.php',
                    type: 'POST',
                    dataType: 'json',  // Asegurar que se reciba JSON desde el servidor
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#mensaje_usuario').html('<p class="alert alert-success">' + response.message + '</p>');
                            $('#usuarioForm')[0].reset(); // Limpiar los campos del formulario
                        } else {
                            $('#mensaje_usuario').html('<p class="alert alert-danger">' + response.message + '</p>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        $('#mensaje_usuario').html('<p class="alert alert-danger">Error en el registro: ' + textStatus + '</p>');
                    }
                });
            });
        });
    </script>
</head>
<body>
<div class="container mt-5">
        <h1 class="text-center">Crear usuario</h1>

        <form id="usuarioForm">
            <!-- Vincular Persona al Usuario -->
            <div class="form-group">
                <label for="id_persona">Vincular Persona:</label>
                <select class="form-control" id="id_persona" name="id_persona">
                    <?php 
                    // Obtener la lista de personas sin usuario y mostrarlas en el select
                    $personasx = obtener_personas_disponibles();

                    foreach ($personasx as $personasx) {
                        echo "<option value='{$personasx['id_persona']}'>{$personasx['nomyap_persona']}</option>";
                        //echo $personasx['id_persona'];
                    }
                    ?>
                </select>


                

            </div>

            <div class="form-group">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>

            <div class="form-group">
                <label for="clave_usuario">Contraseña:</label>
                <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" required>
            </div>

            <div class="form-group">
                <label for="estado_usuario">Tipo de Usuario:</label>
                <select class="form-control" id="estado_usuario" name="estado_usuario">
                    <option value="1">Súper Usuario</option>
                    <option value="2">Editor</option>
                    <option value="3">Deshabilitado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar Usuario</button>
        </form>

        <div id="mensaje_usuario" class="mt-3"></div>
    </div>
</body>
</html>
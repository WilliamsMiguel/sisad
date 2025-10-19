<?php 
//include '../LN/ln_listarPerUserR.php';
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
            // Mostrar/ocultar secciones al hacer clic en el título
            $('.seccion-titulo').on('click', function() {
                $(this).next('.seccion').slideToggle();
            });

            $('#registroForm').on('submit', function(e) {
                e.preventDefault(); // Evitar el envío normal del formulario
                var formData = $(this).serialize(); // Serializar los datos del formulario

                $.ajax({
                    url: '../LN/ln_registro.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) 
                    {
                        $('#mensaje').html('<p class="alert alert-success">Registro exitoso.</p>');
                        $('#registroForm')[0].reset(); // Limpiar los campos del formulario
                    },
                    error: function() {
                        $('#mensaje').html('<p class="alert alert-danger">Error en el registro.</p>');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registro de Datos</h1>
        <form id="registroForm">

            <!-- Registrar Área -->
            <h2 class="seccion-titulo" style="Cursor: pointer;">Registrar Área</h2>
            <div class="seccion">
                <div class="form-group">
                    <label for="descripcion_area">Descripción Área:</label>
                    <input type="text" class="form-control" id="descripcion_area" name="descripcion_area">
                </div>
            </div>

            <!-- Registrar Dependencia -->
            <h2 class="seccion-titulo" style="Cursor: pointer;">Registrar Dependencia</h2>
            <div class="seccion">
                <div class="form-group">
                    <label for="descripcion_dependencia">Descripción Dependencia:</label>
                    <input type="text" class="form-control" id="descripcion_dependencia" name="descripcion_dependencia">
                </div>
            </div>

            <!-- Registrar Bien -->
<h2 class="seccion-titulo" style="Cursor: pointer;">Registrar Bien</h2>
<div class="seccion">
    <div class="form-group">
        <label for="equipo_bien">Equipo Bien:</label>
        <input type="text" class="form-control" id="equipo_bien" name="equipo_bien">
    </div>
    <div class="form-group">
        <label for="marca_bien">Marca:</label>
        <input type="text" class="form-control" id="marca_bien" name="marca_bien">
    </div>
    <div class="form-group">
        <label for="modelo_bien">Modelo:</label>
        <input type="text" class="form-control" id="modelo_bien" name="modelo_bien">
    </div>
    <div class="form-group">
        <label for="procesador_bien">Procesador:</label>
        <input type="text" class="form-control" id="procesador_bien" name="procesador_bien">
    </div>
    <div class="form-group">
        <label for="numdeserie_bien">Serie:</label>
        <input type="text" class="form-control" id="numdeserie_bien" name="numdeserie_bien">
    </div>

    <div class="form-group">
        <label for="numcontropatri_bien">Control Patrimonial:</label>
        <input type="text" class="form-control" id="numcontropatri_bien" name="numcontropatri_bien">
    </div>

    <div class="form-group">
        <label for="estado_bien">Estado del bien:</label>
        <select class="form-control" id="estado_bien" name="estado_bien">
            <option value="1">Bueno</option>
            <option value="2">Regular</option>
            <option value="3">Malo</option>
            <option value="4">Baja</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="añodeadqs_bien">Año del bien:</label>
        <input type="text" class="form-control" id="añodeadqs_bien" name="añodeadqs_bien">
    </div>

    <div class="form-group">
        <label for="numdeordendecom_bien">Orden de Compra:</label>
        <input type="text" class="form-control" id="numdeordendecom_bien" name="numdeordendecom_bien">
    </div>

    <div class="form-group">
        <label for="observacion_bien">Observación:</label>
        <input type="text" class="form-control" id="observacion_bien" name="observacion_bien">
    </div>
</div>


            <!-- Registrar Persona -->
            <h2 class="seccion-titulo" style="Cursor: pointer;">Registrar Persona</h2>
            <div class="seccion">
                <div class="form-group">
                    <label for="nomyap_persona">Nombre y Apellido:</label>
                    <input type="text" class="form-control" id="nomyap_persona" name="nomyap_persona">
                </div>
                <div class="form-group">
                    <label for="dni_persona">DNI:</label>
                    <input type="text" class="form-control" id="dni_persona" name="dni_persona">
                </div>
                <div class="form-group">
                    <label for="cell_persona">Celular:</label>
                    <input type="text" class="form-control" id="cell_persona" name="cell_persona">
                </div>

                <div class="form-group">
                    <label for="correo_persona">Correo:</label>
                    <input type="text" class="form-control" id="correo_persona" name="correo_persona">
                </div>

                <div class="form-group">
                    <label for="dir_persona">Dirección:</label>
                    <input type="text" class="form-control" id="dir_persona" name="dir_persona">
                </div>
            </div>

            <!-- Registrar Menú -->
            <h2 class="seccion-titulo" style="Cursor: pointer;">Registrar Menú</h2>
            <div class="seccion">
                <div class="form-group">
                    <label for="descripcion_menu">Descripción Menú:</label>
                    <input type="text" class="form-control" id="descripcion_menu" name="descripcion_menu">
                </div>
                <div class="form-group">
                    <label for="nombrearchivo_menu">Nombre de Archivo:</label>
                    <input type="text" class="form-control" id="nombrearchivo_menu" name="nombrearchivo_menu">
                </div>
            </div>



            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
        </form>
        <div id="mensaje" class="mt-3"></div>
    </div>
</body>
</html>

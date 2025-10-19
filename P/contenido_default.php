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
        <h1 class="text-center"> </h1>
       

         
</body>
</html>

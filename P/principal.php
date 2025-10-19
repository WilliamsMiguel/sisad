<?php
// P/principal.php
include '../LN/ln.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Listar menú
$menus = listar_menus_activos();

// Recuperar los datos de la persona
$persona = obtener_datos_personaLN($_SESSION['id_persona_usuario']);

if ($persona) {
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>SISAD - Sistema de Asignación y Despalazamiento - NCPPP</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-mQ93WzZf2fkc9ZRMyhOTRhVblHI5xCPmjLXYEu1rRXs8h5ghw5FxFZef56crroPg" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
                background-color: #f8f9fa;
            }
            .menu {
                background-color: #343a40;
                color: #fff;
                height: 100vh;
                padding: 20px;
            }
            .menu ul {
                list-style-type: none;
                padding: 0;
            }
            .menu li {
                margin-bottom: 10px;
            }
            .menu a {
                color: #ffffff;
                text-decoration: none;
                font-weight: bold;
                font-size: 1.2rem;
                display: block;
                padding: 10px;
                background-color: #495057;
                border-radius: 8px;
                transition: background-color 0.3s ease;
            }
            .menu a:hover {
                background-color: #17a2b8;
            }
            .contenido {
                padding: 20px;
                height: 100%;
                overflow-y: auto;
                background-color: #ffffff;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            .bienvenida {
                font-size: 1.2rem;
                font-weight: bold;
                color: #343a40;
            }
            .cerrar-sesion {
                text-align: right;
            }
            .cerrar-sesion a {
                color: #dc3545;
                text-decoration: none;
                font-weight: bold;
            }
            .cerrar-sesion a:hover {
                color: #c82333;
            }
        </style>
        <script>
            function cargarContenido(menu_id) {
                $.ajax({
                    url: 'contenido_menu.php',
                    type: 'POST',
                    data: { id_menu: menu_id },
                    success: function(response) {
                        $('#contenido_dinamico').html(response);
                    }
                });
            }

            // Función para cargar un contenido predeterminado al iniciar
            $(document).ready(function() {
                // Puedes cambiar este URL a uno que cargue una vista predeterminada (por ejemplo, un "Bienvenido")
                $('#contenido_dinamico').load('contenido_default.php');
            });
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar del Menú -->
                <nav class="col-md-3 col-lg-2 d-md-block menu">
                    <h4>Menú</h4>
                    <ul>
                        <?php foreach ($menus as $menu): ?>
                            <li>
                                <a href="javascript:void(0);" onclick="cargarContenido(<?php echo $menu['id_menu']; ?>)">
                                    <?php echo htmlspecialchars($menu['descripcion_menu']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <!-- Zona de Contenido -->
                <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                        <div class="bienvenida">
                            Bienvenido, <?php echo $persona['nomyap_persona']; ?>
                        </div>
                        <div class="cerrar-sesion">
                            <p><a href="logout.php">Cerrar Sesión</a></p>
                        </div>
                    </div>

                    <div class="contenido" id="contenido_dinamico">
                        <!-- Aquí se cargará el contenido dinámico -->
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php
} else {
    echo "<p>No se encontraron datos para la persona asociada.</p>";
}
?>

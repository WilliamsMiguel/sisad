<?php
// P/principal.php

include '../LN/ln.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Obtener datos del usuario
$persona = obtener_datos_personaLN($_SESSION['id_persona_usuario']);
$estado_usuario = $_SESSION['estado_usuario']; // Necesitamos agregar esto desde ln.php
$id_usuario = $_SESSION['id_usuario'];         // Necesitamos agregar esto también

// Obtener menús según el tipo de usuario
// Obtener menús según el tipo de usuario
if ($estado_usuario == 1) {
    $menus = listar_menus_activos(); // Superusuario: todos los menús
} else {
    $menus = listar_menus_por_usuarioLN($id_usuario); // Editor: solo menús asignados
}

// Recuperar los datos de la persona
$persona = obtener_datos_personaLN($_SESSION['id_persona_usuario']);

if ($persona) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SISAD - Sistema de Asignación y Desplazamiento - NCPPP</title>
    <link href="../libreria/bootstrap.min.css" rel="stylesheet">
    <script src="../libreria/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="img/pj.png" type="image/x-icon">

    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh; /* El cuerpo sigue ocupando toda la pantalla */
        }
        .container-fluid {
            height: 100vh; /* El contenedor también ocupa toda la pantalla */
        }
        .menu {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            height: 100%; /* Forzamos que el menú ocupe toda la altura */
            overflow-y: auto; /* Añade scroll si el contenido del menú es muy grande */
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
            height: 100%; /* Asegura que el contenido también ocupe toda la altura */
            background-color: #ffffff;
            overflow-y: auto; /* Añade scroll al contenido si es necesario */
        }
        .bienvenida {
            font-size: 1.2rem;
            font-weight: bold;
            color: #343a40;
        }
        .cerrar-sesion {
            text-align: left;
        }
        .cerrar-sesion a {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
        .cerrar-sesion a:hover {
            color: #c82333;
        }
        .nombre {
            font-size: 13px;
            font-weight: bold;
            color: #c6b9b6;
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

        $(document).ready(function() {
            $('#contenido_dinamico').load('contenido_default.php');
        });
    </script>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row" style="height: 100%;">
        
            <!-- Sidebar del Menú -->
            <nav class="col-md-3 col-lg-2 d-md-block menu">
                 <!-- Link de Cerrar Sesión -->
            <div class="cerrar-sesion">
                <a href="logout.php">Cerrar sesión [X] </a>
            </div>
            <div class="nombre">
            Bienvenido: 
            <?php  echo $persona["nomyap_persona"]; ?>
             
            </div>
           
<br><br><br>
                <!--h4>Menú</h4-->
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
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 contenido" id="contenido_dinamico">
                <!-- Aquí se cargará el contenido dinámico -->
            </main>
        </div>
    </div>

    <script src="../libreria/bootstrap.bundle.min.js"></script>
</body>
</html>

        <script src="../libreria/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php
} else {
    echo "<p>No se encontraron datos para la persona asociada.</p>";
}
?>

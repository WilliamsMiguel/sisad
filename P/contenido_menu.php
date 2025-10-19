<?php
// contenido_menu.php
//include '../LN/ln.php';

if (isset($_POST['id_menu'])) {
    $id_menu = $_POST['id_menu'];

    // Aquí puedes definir qué contenido mostrar dependiendo del menú
    switch ($id_menu) {
        case 1:
            include 'movimiento.php';
            break;
        case 2:
            echo "<h2>Contenido del Menú 2</h2><p>Esta es la página dinámica del menú 2.</p>";
            break;
        case 3:
            echo "<h2>Contenido del Menú 3</h2><p>Esta es la página dinámica del menú 3.</p>";
            break;
        case 4:
            include 'registrar.php';
            break;
        case 5:
            include 'listaR.php';
            break;
        case 6:
            include 'crear_usuario.php';
            break;
        default:
           // echo "<h2>Contenido por defecto</h2><p>Seleccione una opción del menú para ver el contenido.</p>";
    }
} else {
    echo "<p>Error: No se ha recibido un ID de menú válido.</p>";
}

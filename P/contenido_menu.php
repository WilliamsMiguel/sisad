<?php
// contenido_menu.php
require_once '../AD/ad.php'; // Asegúrate de tener tu función conectar() aquí

if (isset($_POST['id_menu'])) {
    $id_menu = $_POST['id_menu'];

    $conn = conectar();
    $sql = "SELECT nombrearchivo_menu FROM menu WHERE id_menu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_menu);
    $stmt->execute();
    $stmt->bind_result($archivo);

    if ($stmt->fetch() && !empty($archivo)) {
        $ruta = "../" . $archivo; // Para que funcione desde este archivo
        if (file_exists($ruta)) {
            include $ruta;
        } else {
            echo "<p>Error: El archivo '$archivo' no existe en el sistema.</p>";
        }
    } else {
        echo "<p>Error: No se encontró un menú válido con ese ID.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Error: No se ha recibido un ID de menú válido.</p>";
}
?>

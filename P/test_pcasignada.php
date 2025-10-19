<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../AD/ad.php';

// Probar conexión
try {
    $conn = conectar();
    echo "Conexión OK\n";

    // Probar si existe la tabla
    if ($conn instanceof PDO) {
        $stmt = $conn->query("DESCRIBE pcasignada");
        echo "Tabla pcasignada existe\n";
        $columns = $stmt->fetchAll();
        print_r($columns);
    } else {
        $result = $conn->query("DESCRIBE pcasignada");
        echo "Tabla pcasignada existe\n";
        while($row = $result->fetch_assoc()) {
            print_r($row);
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php
require_once '../AD/ad.php';

if (!isset($_POST['id_historial'])) {
    echo "ID de historial no proporcionado.";
    exit;
}

$idHistorial = intval($_POST['id_historial']);
$detalle = obtener_detalle_historial_reasignacion($idHistorial);

if (!$detalle) {
    echo "<p>No se encontró detalle para este historial.</p>";
    exit;
}

foreach ($detalle as $item) {
    echo "<h5>Bien ID: {$item['id_bien']}</h5>";
    echo "<ul>";
    echo "<li><strong>Equipo:</strong> {$item['equipo_bien']}</li>";
    echo "<li><strong>Marca:</strong> {$item['marca_bien']}</li>";
    echo "<li><strong>Modelo:</strong> {$item['modelo_bien']}</li>";
    echo "<li><strong>Procesador:</strong> {$item['procesador_bien']}</li>";
    echo "<li><strong>Serie:</strong> {$item['numdeserie_bien']}</li>";
    echo "<li><strong>N° Patrimonial:</strong> {$item['numcontropatri_bien']}</li>";
    echo "<li><strong>Área destino:</strong> {$item['area_destino']}</li>";
    echo "<li><strong>Dependencia destino:</strong> {$item['dependencia_destino']}</li>";
    echo "<li><strong>Fecha de reasignación:</strong> {$item['fecha_reasignacion']}</li>";
    echo "<li><strong>Archivo PDF:</strong> " . ($item['archivo_pdf'] ? "<a href='../DOCS_REASIGNACIONES/{$item['archivo_pdf']}'>Ver archivo</a>"
            : "No disponible") . "</li>";
    echo "</ul><hr>";
}
?>

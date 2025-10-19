<?php
// ===== CONFIGURACIÓN DE ERRORES =====
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// ===== HEADERS PARA DEBUGGING =====
header('Content-Type: text/html; charset=utf-8');

// ===== VALIDACIÓN DE MÉTODO =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Error: Método no permitido. Use POST.');
}

// ===== VALIDACIÓN DE PARÁMETROS =====
if (!isset($_POST['id_movimientoEdi']) || empty($_POST['id_movimientoEdi'])) {
    http_response_code(400);
    die('Error: No se recibió id_movimientoEdi');
}

// ===== INCLUIR ARCHIVO DE FUNCIONES =====
$ad_path = __DIR__ . '/../AD/ad.php';

if (!file_exists($ad_path)) {
    http_response_code(500);
    die('Error: No se encontró el archivo ad.php en: ' . $ad_path);
}

require_once $ad_path;

// ===== VERIFICAR FUNCIONES =====
$funciones_requeridas = [
    'obtener_detalle_movimiento',
    'obtener_bienes_desvinculados',
    'obtener_estado_movimiento'
];

foreach ($funciones_requeridas as $funcion) {
    if (!function_exists($funcion)) {
        http_response_code(500);
        die("Error: La función {$funcion}() no existe en ad.php");
    }
}

// ===== OBTENER DATOS =====
$id_movimientoEdi = intval($_POST['id_movimientoEdi']);

try {
    // Verificar conexión
    $conn = conectar();
    if (!$conn) {
        throw new Exception('Error al conectar con la base de datos');
    }

    // Obtener datos
    $detalleMovimientosEdi = obtener_detalle_movimiento($id_movimientoEdi);
    $bienesDesvinculados = obtener_bienes_desvinculados($id_movimientoEdi);
    $estadoMovimiento = obtener_estado_movimiento($id_movimientoEdi);

    // Validar que se obtuvieron resultados
    if ($detalleMovimientosEdi === false || $bienesDesvinculados === false || $estadoMovimiento === false) {
        throw new Exception('Error al obtener datos del movimiento');
    }

} catch (Exception $e) {
    http_response_code(500);
    die('Error: ' . $e->getMessage());
}
?>

<style>
    .fila-rojo-oscuro {
        background-color: #8B0000 !important;
        color: #fff;
    }
</style>

<?php
// ===== GENERAR HTML =====
$output = '<form id="editarMovimientoForm">';
$output .= '<input type="hidden" name="id_movimientoEdi" value="' . htmlspecialchars($id_movimientoEdi) . '">';

// Listar los bienes asociados con checkboxes
$output .= '<h5>Bienes asociados</h5>';
$output .= '<table class="table table-bordered" id="tablaBienesAsociados">';
$output .= '<thead><tr><th></th><th>Nombre</th><th>Serie</th><th>Patrimonial</th><th>Costo</th>';

if ($estadoMovimiento != 1) {
    $output .= '<th>Acción</th>';
}

$output .= '</tr></thead><tbody>';

// Validar que detalleMovimientosEdi sea un array
if (is_array($detalleMovimientosEdi) && !empty($detalleMovimientosEdi)) {
    foreach ($detalleMovimientosEdi as $bien) {
        $idBien = isset($bien['id_bien_detmov']) ? intval($bien['id_bien_detmov']) : 0;

        if ($idBien === 0) continue; // Saltar si no hay ID válido

        $claseFila = in_array($idBien, $bienesDesvinculados) ? 'fila-rojo-oscuro' : '';

        $output .= '<tr class="' . $claseFila . '">';

        if (in_array($idBien, $bienesDesvinculados)) {
            $output .= '<td></td>';
        } else {
            $output .= '<td><input type="checkbox" class="checkboxBien" value="' . $idBien . '" data-id="' . $idBien . '"></td>';
        }

        $output .= '<td>' . htmlspecialchars($bien['des_nombre_bien'] ?? 'N/A') . '</td>';
        $output .= '<td>' . htmlspecialchars($bien['numdeserie_bien'] ?? 'N/A') . '</td>';
        $output .= '<td>' . htmlspecialchars($bien['numcontropatri_bien'] ?? 'N/A') . '</td>';
        $output .= '<td>S/ ' . htmlspecialchars($bien['costo_bien'] ?? '0.00') . '</td>';

        if ($estadoMovimiento != 1) {
            $output .= '<td><button type="button" class="btn btn-danger btn-sm eliminarBien" data-id="' . $idBien . '">Eliminar</button></td>';
        }

        $output .= '</tr>';
    }
} else {
    // Si no hay bienes, mostrar mensaje
    $colspan = ($estadoMovimiento != 1) ? 6 : 5;
    $output .= '<tr><td colspan="' . $colspan . '" class="text-center">No hay bienes asociados</td></tr>';
}

$output .= '</tbody></table>';

// Determinar visibilidad de botones
$displayEliminarBtn = empty($detalleMovimientosEdi) ? 'block' : 'none';
$displayAgregarBien = ($estadoMovimiento == 0) ? 'block' : 'none';
$displayDesvincular = (empty($detalleMovimientosEdi) || $estadoMovimiento == 1) ? 'none' : 'block';

$output .= '<div id="ModalAgregarBien"></div>';

// Botones de acción
$output .= '<button type="button" id="eliminarMovimientoBtnX" class="btn btn-danger" style="display:' . $displayEliminarBtn . '; float: right;">Eliminar Movimiento</button>';
$output .= '<button type="button" id="agregarBienBtnX" class="btn btn-success" style="display:' . $displayAgregarBien . '; float: right;">Agregar bien</button>';
$output .= '<button type="button" id="guardarCambiosBtnX" class="btn btn-primary" style="display:none; float: right;">Guardar cambios</button>';
$output .= '<button type="button" id="btnDesvincular" class="btn btn-warning" style="display:' . $displayDesvincular . '; float:right; margin-right: 10px;">Desvincular</button>';

$output .= '</form>';

echo $output;
?>

<script>
    // JavaScript para manejar la visibilidad de los botones
    const agregarBienBtnN = document.getElementById('agregarBienBtnX');
    const guardarCambiosBtnN = document.getElementById('guardarCambiosBtnX');
    const eliminarMovimientoBtn = document.getElementById('eliminarMovimientoBtnX');
    const tablaBienesAsociados = document.getElementById('tablaBienesAsociados');
</script>
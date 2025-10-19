<style>
    .select-no-edit {
        pointer-events: none;
        background-color: #e9ecef; /* similar al estilo de un input readonly */
    }
</style>

<?php
include '../AD/ad.php';
require_once '../LN/ln_listaR.php'; // Se asume que ya tienes esta función para obtener listas

// Obtener listas de personas, dependencias y áreas
$personas = obtener_personas();
$dependencias = obtener_dependencias();
$areas = obtener_areas();
$ids_bienes = $_POST['ids_bienes'] ?? [];
$id_movimiento = $_POST['id_movimiento'] ?? null;

if (empty($ids_bienes)) {
    echo '<div class="alert alert-warning">No se recibieron bienes seleccionados.</div>';
    exit;
}

$datos = $id_movimiento ? obtener_info_completa_movimiento($id_movimiento) : [];
$detalles_bienes = $id_movimiento ? obtener_detalle_movimiento($id_movimiento) : [];
$ids_areas_bienes = obtener_areas_por_bienes($ids_bienes);

// Validar si todos pertenecen a Informática (ID área = 2)
$soloInformatica = !empty($ids_areas_bienes) && count(array_unique($ids_areas_bienes)) === 1 && in_array(2, $ids_areas_bienes);


date_default_timezone_set('America/Lima');

$output = '<form id="formDesvincularBienes" method="POST" enctype="multipart/form-data">';

// Mostrar nombres (pero enviar también los IDs como ocultos)
// Transferente
$output .= '<div class="row mb-2">';
$output .= '<div class="col-md-6">
                <label>Transferente:</label>
                <select name="id_transferente_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Transferente</option>';
foreach ($personas as $persona) {
    $selected = ($datos['id_transferente_movimiento'] ?? '') == $persona['id_persona'] ? 'selected' : '';
    $output .= '<option value="' . $persona['id_persona'] . '" ' . $selected . '>' . htmlspecialchars($persona['nomyap_persona']) . '</option>';
}
$output .= '</select>
            </div>';

// Receptor
$output .= '<div class="col-md-6">
                <label>Receptor:</label>
                <select name="id_receptor_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Receptor</option>';
foreach ($personas as $persona) {
    $selected = ($datos['id_receptor_movimiento'] ?? '') == $persona['id_persona'] ? 'selected' : '';
    $output .= '<option value="' . $persona['id_persona'] . '" ' . $selected . '>' . htmlspecialchars($persona['nomyap_persona']) . '</option>';
}
$output .= '</select>
            </div>';
$output .= '</div>';

// Dependencias
$output .= '<div class="row mb-2">';
$output .= '<div class="col-md-6">
                <label>Dependencia Transferente:</label>
                <select name="id_dependencia_transferente_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Dependencia</option>';
foreach ($dependencias as $dep) {
    $selected = ($datos['id_dependencia_transferente_movimiento'] ?? '') == $dep['id_dependencia'] ? 'selected' : '';
    $output .= '<option value="' . $dep['id_dependencia'] . '" ' . $selected . '>' . htmlspecialchars($dep['descripcion_dependencia']) . '</option>';
}
$output .= '</select>
            </div>';

$output .= '<div class="col-md-6">
                <label>Dependencia Receptora:</label>
                <select name="id_dependencia_receptor_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Dependencia</option>';
foreach ($dependencias as $dep) {
    $selected = ($datos['id_dependencia_receptor_movimiento'] ?? '') == $dep['id_dependencia'] ? 'selected' : '';
    $output .= '<option value="' . $dep['id_dependencia'] . '" ' . $selected . '>' . htmlspecialchars($dep['descripcion_dependencia']) . '</option>';
}
$output .= '</select>
            </div>';
$output .= '</div>';

// Áreas
$output .= '<div class="row mb-2">';
$output .= '<div class="col-md-6">
                <label>Área Transferente:</label>
                <select name="id_area_transferente_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Área</option>';
foreach ($areas as $area) {
    $selected = ($datos['id_area_transferente_movimiento'] ?? '') == $area['id_area'] ? 'selected' : '';
    $output .= '<option value="' . $area['id_area'] . '" ' . $selected . '>' . htmlspecialchars($area['descripcion_area']) . '</option>';
}
$output .= '</select>
            </div>';

$output .= '<div class="col-md-6">
                <label>Área Receptora:</label>
                <select name="id_area_receptor_movimiento" class="form-control select-no-edit" required>
                    <option value="">Seleccionar Área</option>';
foreach ($areas as $area) {
    $selected = ($datos['id_area_receptor_movimiento'] ?? '') == $area['id_area'] ? 'selected' : '';
    $output .= '<option value="' . $area['id_area'] . '" ' . $selected . '>' . htmlspecialchars($area['descripcion_area']) . '</option>';
}
$output .= '</select>
            </div>';
$output .= '</div>';


$output .= '<div class="row mb-2">';
$output .= '<div class="col-md-6">
                <label>Fecha del Movimiento:</label>
                <input type="date" class="form-control select-no-edit" name="fecha_movimiento" value="' . htmlspecialchars($datos['fecha_movimiento'] ?? '') . '" readonly>
            </div>';
$output .= '<div class="col-md-6">
                <label>Fecha Actual:</label>
                <input type="date" class="form-control select-no-edit" name="fecha_actual" value="' . date('Y-m-d') . '" readonly>
            </div>';
$output .= '</div>';

// Campo PDF condicional
$output .= '<div class="row mb-3">';
$output .= '<div class="col-md-12">';
$output .= '<label>Subir Archivo (PDF):</label>';
$output .= '<input type="file" class="form-control" name="archivo_actual" accept="application/pdf" ' . ($soloInformatica ? 'disabled' : '') . '>';
$output .= '<input type="hidden" name="archivo_movimiento" value="' . htmlspecialchars($datos['archivo_movimiento'] ?? '') . '">';
$output .= ($soloInformatica ? '<small class="text-muted">Deshabilitado porque todos los bienes pertenecen al área de Informática.</small>' : '');
$output .= '</div>';
$output .= '</div>';

// Mostrar bienes seleccionados (nombre visible + id oculto)
$output .= '<div class="mb-3"><strong>Bienes Seleccionados:</strong><ul>';

foreach ($detalles_bienes as $bien) {
    if (in_array($bien['id_bien_detmov'], $ids_bienes)) {
        $output .= '<li>' . htmlspecialchars($bien['des_nombre_bien']) . '</li>';
        $output .= '<input type="hidden" name="ids_bienes[]" value="' . htmlspecialchars($bien['id_bien_detmov']) . '">';
    }
}

$output .= '</ul></div>';

// Campo oculto para el ID del movimiento
$output .= '<input type="hidden" name="id_movimiento" value="' . htmlspecialchars($id_movimiento) . '">';

$output .= '<div id="mensajeDesvinculacion" class="mt-3"></div>';

// Botón de confirmación
$output .= '<button type="submit" class="btn btn-primary">Confirmar Desvinculacion</button>';
$output .= '</form>';

echo $output;
?>

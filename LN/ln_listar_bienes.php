<?php
include '../AD/ad.php';
$resultadoBienesNoAsociados = obtener_detalle_movimiento_bien_noAsociado();

// Mostrar los bienes en un selector o tabla

$output = '<div class="mb-3">
                <label for="bien">Bienes disponibles</label>
                <select class="form-control select2-bienes" name="id_bien_detmovAgregar" id="bienAgregar">
                    <option value="">Seleccionar Bien</option>';

    foreach ($resultadoBienesNoAsociados as $bien) {
    $output .= '<option value="'.htmlspecialchars($bien['id_bien']).'">'.
                    htmlspecialchars($bien['id_bien']).' '.
                    htmlspecialchars($bien['des_nombre_bien']).' '.
                    htmlspecialchars($bien['marca_bien']).' '.
                    htmlspecialchars($bien['numdeserie_bien']).' '.
                    htmlspecialchars($bien['numcontropatri_bien']).'  S/'.
                    htmlspecialchars($bien['costo_bien']).'
                </option>';
}

$output .= '</select>
            </div>';

$output .= '<button type="button" id="agregarBienAgregarX" class="btn btn-secondary">Aceptar</button>';
$output .= '<ul id="listaBienesAgregarX" class="list-group my-3"></ul>';

echo $output;

?>
 
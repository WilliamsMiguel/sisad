<?php
// ln_ver_movimientos.php
include '../AD/ad.php';

// Verificar la cantidad de filas a mostrar
$cantidadElegida = isset($_POST['numFilas']) ? intval($_POST['numFilas']) : 5;



// Obtener los movimientos desde la base de datos
$movimientosElegida = obtener_ultimos_movimientos($cantidadElegida);

// Generar la salida para la tabla
$output = '';
foreach ($movimientosElegida as $movimiento) 
{
    $output .= '<tr data-id="' . $movimiento['id_movimiento'] . '" class="movimiento-row">';
    $output .= '<td style="border: 1px solid #ffffff;">' . $movimiento['id_movimiento'] . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['transferente']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['receptor']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['dependencia']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['dependencia_destino']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['area_trans']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['area_des']) . '</td>';


    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($movimiento['fecha_movimiento']) . '</td>';

    if($movimiento['estado_movimiento']==0)
    {
        $output .= '<td style="border: 1px solid #ffffff;">
        <a href="../LN/ln_generar_documento.php?id_movimiento='.$movimiento['id_movimiento'].'" target="_blank">Generar documento para firmar</a><br><br>
        <input type="file" class="form-control subirArchivoFirmadoPDF" style="font-size: 8px; width: 190px" name="subirArchivoFirmadoPDF" accept=".pdf" required>
        <button class="subirArchivoFirmado">Subir Documento</button>
        </td>';   

    }
    else
    {
    $output .= '<td style="border: 1px solid #ffffff;">
    <a href="../' . $movimiento['archivo_movimiento'] . '" target="_blank">Ver archivo</a>
    </td>';
    } 
    $output .= '<td style="border: 1px solid #ffffff;">
         <button class="btn btn-danger btn-sm editar" style="font-size: 10px; width: 70px">Editar</button>
         <button class="btn btn-primary btn-sm detalleVer" style="font-size: 10px; width: 70px">Ver Detalle</button>
    </td>';
    
    $output .= '</tr>';

    $output .= '<tr class="detalle-row" id="detalle-'.$movimiento['id_movimiento'].'" style="border: #FFFFFF;">';
    $output .= '<td colspan="9" >';
    $output .= '<div class="detalleContenido" style="vertical-align: top;">';
    $output .= '</div>';
    $output .= '</td>';
    $output .= '<td>';
    $output .= ' <span class="cerrarDetalle">&times;</span>';
    $output .= '</td>';
    $output .= '</tr>';
}

echo $output;


?>

<?php
// ln_ver_bienes.php
include '../AD/ad.php';

$serieBP = isset($_POST['serieB']) ? trim($_POST['serieB']) : '';
// Obtener los movimientos desde la base de datos
$bienConPersonaTipeo = listar_bienes_con_personas_tipeo($serieBP);

// Generar la salida para la tabla
$output = '';
foreach ($bienConPersonaTipeo as $bienP) 
{
    $output .= '<tr data-id="' . $bienP['id_detallemovimiento'] . '" class="bienP-row">';
    $output .= '<td style="border: 1px solid #ffffff;">' . $bienP['SEDE'] . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['DEPENDENCIA']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['USUARIO']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['EQUIPO']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['MARCA']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['MODELO']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['PROCESADOR']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['NUMERO DE SERIE']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['NUMERO DE CONTROL PATRIMONIAL']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['ESTADO']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['AÑO DE ADQUISICIÓN']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['NUMERO DE ORDEN DE COMPRA']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['FUNCIONAMIENTO']) . '</td>';
    $output .= '<td style="border: 1px solid #ffffff;">' . htmlspecialchars($bienP['OBSERVACIÓN']) . '</td>';
    $output .= '</tr>';

   
}

echo $output;


?>

<?php
include '../vendor/autoload.php'; // Asegúrate de incluir el autoloader de Composer
include '../AD/ad.php';      // Incluir la capa de acceso a datos
use PhpOffice\PhpSpreadsheet\IOFactory;

// Verificar la acción y el ID del movimiento
if (isset($_GET['id_movimiento']))
{
    $id_movimiento = intval($_GET['id_movimiento']);

    // Obtener datos del movimiento desde la capa AD
    $movimiento = obtenerMovimientoPorId($id_movimiento);
    $detalles = obtener_detalle_movimiento($id_movimiento);

    // Verificar si el movimiento existe
    if (!$movimiento)
    {
        die("Movimiento no encontrado.");
    }

    // Cargar la plantilla de Excel
    $spreadsheet = IOFactory::load('../libreria/FA.xlsx');
    $sheet = $spreadsheet->getActiveSheet();


    // FA
    //$sheet->setCellValue('D19', $movimiento['id_movimiento']); // ID en celda B2
    $sheet->setCellValue('AL5', $movimiento['fecha_movimiento']); // Fecha en B3
    $sheet->setCellValue('AB8', $movimiento['dnir']);
    $sheet->setCellValue('AG8', $movimiento['receptor']);
    $sheet->setCellValue('AF10', $movimiento['dependencia_destino']);
    $sheet->setCellValue('AB14', $movimiento['area_des']);
    $sheet->setCellValue('AG12', $movimiento['cargo_r']);


    // FD
    $sheet->setCellValue('AQ72', $movimiento['fecha_movimiento']);
    $sheet->setCellValue('I77', $movimiento['dnit']);
    $sheet->setCellValue('N77', $movimiento['transferente']);
    $sheet->setCellValue('AG77', $movimiento['receptor']);
    $sheet->setCellValue('N81', $movimiento['dependencia']);
    $sheet->setCellValue('AF81', $movimiento['dependencia_destino']);
    $sheet->setCellValue('G85', $movimiento['area_trans']);
    $sheet->setCellValue('AB85', $movimiento['area_des']);

    // DETALLE FA
    $rowA = 19;
    foreach ($detalles as $detalle)
    {
        // Ajustar ancho de columna C
        $sheet->getColumnDimension('C')->setWidth(5);

        // Año de adquisición en columna C, vertical, como texto
        $sheet->setCellValueExplicit('C' . $rowA, $detalle['añodeadqs_bien'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('C' . $rowA)->getAlignment()->setTextRotation(90);
        $sheet->setCellValue('D' . $rowA,$detalle['numcontropatri_bien']); // ID del bien en columna A  AG12
        $sheet->setCellValue('O' . $rowA, $detalle['des_nombre_bien']); // Nombre del bien

        if($detalle['estado_bien']==1)
        {
            $sheet->setCellValue('z' . $rowA, "B"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==2)
        {
            $sheet->setCellValue('z' . $rowA, "R"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==3)
        {
            $sheet->setCellValue('z' . $rowA, "M"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==4)
        {
            $sheet->setCellValue('z' . $rowA, "TB"); // Descripción en columna B
        }

        // Recorremos columnas siguientes
        $sheet->setCellValue('AA' . $rowA, $detalle['marca_bien']);
        $sheet->setCellValue('AB' . $rowA, $detalle['modelo_bien']);
        $sheet->setCellValue('AD' . $rowA, $detalle['numdeserie_bien']);
        $sheet->setCellValue('AG' . $rowA, $detalle['color_bien']);
        $sheet->setCellValue('AH' . $rowA, $detalle['numdeordendecom_bien']);
        $sheet->setCellValue('AK' . $rowA, $detalle['costo_bien']);

        $rowA++;
    }

    //detalle FD
    $rowD = 90;
    foreach ($detalles as $detalle)
    {
        $sheet->setCellValue('C' .$rowD, $detalle['numcontropatri_bien']); // ID del bien en columna A
        $sheet->setCellValue('O' .$rowD, $detalle['des_nombre_bien']); // Nombre del bien

        if($detalle['estado_bien']==1)
        {
            $sheet->setCellValue('Y' . $rowD, "B"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==2)
        {
            $sheet->setCellValue('Y' . $rowD, "R"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==3)
        {
            $sheet->setCellValue('Y' . $rowD, "M"); // Descripción en columna B
        }
        elseif($detalle['estado_bien']==4)
        {
            $sheet->setCellValue('Y' . $rowD, "TB"); // Descripción en columna B
        }

        // Aquí va el USO justo después de estado_bien
        $sheet->setCellValue('Z' . $rowD, "SI");

        // Recorremos columnas siguientes
        $sheet->setCellValue('AA' . $rowD, $detalle['marca_bien']);
        $sheet->setCellValue('AB' . $rowD, $detalle['modelo_bien']);
        $sheet->setCellValue('AD' . $rowD, "S/T");
        $sheet->setCellValue('AF' . $rowD, $detalle['numdeserie_bien']);
        $sheet->setCellValue('AI' . $rowD, $detalle['color_bien']);
        $sheet->setCellValue('AK' . $rowD, $detalle['numdeordendecom_bien']);
        $sheet->setCellValue('AQ' . $rowD, $detalle['costo_bien']);

        $rowD++;
    }

    // Configurar el nombre del archivo de salida
    $filename = 'documento_para_firma_' . $id_movimiento . '.xlsx';


    // Configurar las cabeceras para la descarga del archivo
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Guardar el archivo y forzar la descarga
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
} else {
    die("Parámetros inválidos.");
}
?>

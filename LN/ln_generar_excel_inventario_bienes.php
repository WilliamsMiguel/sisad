<?php

// Limpiar cualquier salida previa
ob_clean();

session_start();
require_once '../vendor/autoload.php';
require_once '../AD/ad.php';

// Configurar codificación
ini_set('memory_limit', '256M');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;

// Función para traducir estado
function traducirEstado($valor) {
    switch ($valor) {
        case 1: return 'Bueno';
        case 2: return 'Regular';
        case 3: return 'Malo';
        case 4: return 'Baja';
        default: return 'No definido';
    }
}

// Función para traducir funcionamiento
function traducirFuncionamiento($valor) {
    switch ($valor) {
        case 1: return 'Operativo';
        case 2: return 'Inoperativo';
        case 3: return 'Regular';
        default: return 'No definido';
    }
}

try {
    $conn = conectar();

    // Query para obtener todos los datos de la tabla bien
    $sql = "SELECT 
                b.id_bien,
                b.equipo_bien,
                b.marca_bien,
                b.modelo_bien,
                b.procesador_bien,
                b.numdeserie_bien,
                b.numcontropatri_bien,
                b.estado_bien,
                b.añodeadqs_bien,
                b.numdeordendecom_bien,
                b.color_bien,
                b.observacion_bien,
                b.costo_bien,
                b.funcionamiento,
                b.id_pcasignada,                                         -- ✅ AGREGAR ESTA LÍNEA
                COALESCE(pc.nombre_pcasignada, '') as nombre_pcasignada
            FROM bien b
            LEFT JOIN pcasignada pc ON b.id_pcasignada = pc.id_pcasignada
            ORDER BY b.id_bien";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }

    // Crear un nuevo archivo de Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Inventario Bienes');

    // Definir encabezados con nombres exactos de la BD para facilitar la importación
    $headers = [
        'A' => 'id_bien',
        'B' => 'equipo_bien',
        'C' => 'marca_bien',
        'D' => 'modelo_bien',
        'E' => 'procesador_bien',
        'F' => 'numdeserie_bien',
        'G' => 'numcontropatri_bien',
        'H' => 'estado_bien',
        'I' => 'añodeadqs_bien',
        'J' => 'numdeordendecom_bien',
        'K' => 'color_bien',
        'L' => 'observacion_bien',
        'M' => 'costo_bien',
        'N' => 'funcionamiento',
        'O' => 'id_pcasignada'
    ];

    // Configurar encabezados
    foreach ($headers as $column => $header) {
        $sheet->setCellValue($column . '1', $header);
    }

    // Aplicar estilo a los encabezados (siguiendo el estilo del ejemplo)
    $headerRange = 'A1:O1';
    $sheet->getStyle($headerRange)->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['argb' => Color::COLOR_WHITE],
            'size' => 11,
            'name' => 'Arial'
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['argb' => 'FF1F4E79'] // Azul oscuro como en el ejemplo
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ]);

    // Ajustar altura de la fila de encabezados
    $sheet->getRowDimension('1')->setRowHeight(25);

    // Llenar datos
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id_bien'] ?? '');
        $sheet->setCellValue('B' . $row, $data['equipo_bien'] ?? '');
        $sheet->setCellValue('C' . $row, $data['marca_bien'] ?? '');
        $sheet->setCellValue('D' . $row, $data['modelo_bien'] ?? '');
        $sheet->setCellValue('E' . $row, $data['procesador_bien'] ?? '');
        $sheet->setCellValue('F' . $row, $data['numdeserie_bien'] ?? '');
        $sheet->setCellValue('G' . $row, $data['numcontropatri_bien'] ?? '');
        $sheet->setCellValue('H' . $row, $data['estado_bien'] ?? '');
        $sheet->setCellValue('I' . $row, $data['añodeadqs_bien'] ?? '');
        $sheet->setCellValue('J' . $row, $data['numdeordendecom_bien'] ?? '');
        $sheet->setCellValue('K' . $row, $data['color_bien'] ?? '');
        $sheet->setCellValue('L' . $row, $data['observacion_bien'] ?? '');
        $sheet->setCellValue('M' . $row, $data['costo_bien'] ?? '');
        $sheet->setCellValue('N' . $row, $data['funcionamiento'] ?? '');
        $sheet->setCellValue('O' . $row, $data['id_pcasignada'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheet->getStyle('A' . $row . ':O' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad (como en el ejemplo)
        if ($row % 2 == 0) {
            $sheet->getStyle('A' . $row . ':O' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8F9FA');
        }

        $row++;
    }

    // Aplicar estilo general a los datos si hay registros
    if ($row > 2) {
        $dataRange = 'A2:O' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 10
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD0D0D0'],
                ],
            ],
        ]);

        // Aplicar filtros automáticos
        $sheet->setAutoFilter('A1:O' . ($row - 1));
    }

    // Ajustar ancho de columnas automáticamente
    $columns = range('A', 'O');
    foreach ($columns as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);

        // Establecer un ancho mínimo y máximo para mejor visualización
        $currentWidth = $sheet->getColumnDimension($column)->getWidth();
        if ($currentWidth < 10) {
            $sheet->getColumnDimension($column)->setWidth(10);
        } elseif ($currentWidth > 30) {
            $sheet->getColumnDimension($column)->setWidth(30);
        }
    }

    // Congelar paneles (primera fila)
    $sheet->freezePane('A2');

    // Configurar propiedades del documento (como en el ejemplo)
    $spreadsheet->getProperties()
        ->setCreator("Sistema de Bienes Informáticos")
        ->setLastModifiedBy("Sistema Automatizado")
        ->setTitle("Inventario Bienes")
        ->setSubject("Inventario completo de bienes")
        ->setDescription("Exportación completa de la tabla bien")
        ->setKeywords("inventario, bienes, exportacion")
        ->setCategory("Inventarios");

    $conn->close();

    // Configurar el nombre del archivo de salida
    $filename = 'Inventario_Bienes_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Limpiar buffer de salida
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Configurar las cabeceras para la descarga del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Crear el writer y guardar
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (Exception $e) {
    // En caso de error, mostrar mensaje
    header('Content-Type: text/html; charset=utf-8');
    echo "Error al generar el archivo Excel: " . $e->getMessage();
    exit;
}
?>
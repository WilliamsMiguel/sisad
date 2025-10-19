<?php
include '../vendor/autoload.php'; // Asegúrate de incluir el autoloader de Composer
include '../AD/ad.php';          // Incluir la capa de acceso a datos
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;

// Función auxiliar para traducir funcionamiento
function traducirFuncionamiento($valor) {
    switch ($valor) {
        case 1:
            return 'Operativo';
        case 2:
            return 'Inoperativo';
        case 3:
            return 'Regular';
        default:
            return 'Desconocido';
    }
}

// Obtener datos del movimiento desde la capa AD
$bienPersonaX = listar_bienes_con_personas();

// Verificar si se obtuvieron bienes
if (!$bienPersonaX) {
    echo "No se encontraron bienes registrados.";
    exit;
}

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();

// Remover la hoja por defecto
$spreadsheet->removeSheetByIndex(0);

// Crear la hoja "PCs 01-2025"
$sheetPCs = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'PCs 01-2025');
$spreadsheet->addSheet($sheetPCs, 0);

// Crear la hoja "LAPTOPS 01-2025"
$sheetLaptops = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'LAPTOPS 01-2025');
$spreadsheet->addSheet($sheetLaptops, 1);

// Crear la hoja "ESTABILIZADORES"
$sheetEstabilizadores = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'ESTABILIZADORES');
$spreadsheet->addSheet($sheetEstabilizadores, 2);

// Crear la hoja "CAMARA WEB"
$sheetCamaraWeb = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'CAMARA WEB');
$spreadsheet->addSheet($sheetCamaraWeb, 3);

// ===============================
// CONFIGURAR HOJA "PCs 01-2025"
// ===============================

// Definir encabezados específicos para PCs (CPU, Monitor LED, Teclado)
$headers = [
    'A' => 'DEPENDENCIA',
    'B' => 'ESPECIALIDAD',
    'C' => 'ÓRGANO',
    'D' => 'USUARIO',
    'E' => 'EQUIPO',
    'F' => 'MARCA',
    'G' => 'MODELO',
    'H' => 'PROCESADOR',
    'I' => 'WINDOWS',
    'J' => 'OFFICE',
    'K' => 'ANTIVIRUS',
    'L' => 'NUMERO DE SERIE',
    'M' => 'NUMERO DE CONTROL PATRIMONIAL',
    'N' => 'ESTADO',
    'O' => 'AÑO DE ADQUISICIÓN',
    'P' => 'NUMERO DE ORDEN DE COMPRA',
    'Q' => 'FUNCIONAMIENTO',
    'R' => 'OBSERVACIÓN',
    'S' => 'CORREO',
    'T' => 'PC ASIGNADA'
];

// Configurar encabezados para PCs
foreach ($headers as $column => $header) {
    $sheetPCs->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de PCs
$headerRange = 'A1:T1';
$sheetPCs->getStyle($headerRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FF1F4E79'] // Azul oscuro
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

// Ajustar altura de la fila de encabezados para PCs
$sheetPCs->getRowDimension('1')->setRowHeight(25);

// Llenar datos de PCs (solo CPU, Monitor LED, Teclado)
// REEMPLAZAR esta sección que comienza después de ajustar altura de encabezados:

// Llenar datos de PCs (solo CPU, Monitor LED, Teclado)
$rowA = 2;

// CAMBIAR POR ESTE CÓDIGO:

// Filtrar datos de PCs (solo CPU, Monitor LED, Teclado) y almacenar en array
$datosPCs = [];

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es CPU, Monitor LED o Teclado (case-insensitive)
    $equipo = strtolower($detalle['EQUIPO'] ?? '');
    if (strpos($equipo, 'unidad central de proceso - cpu') !== false ||
        strpos($equipo, 'unidad central de proceso-cpu') !== false ||
        strpos($equipo, 'cpu') !== false ||
        strpos($equipo, 'monitor led') !== false ||
        strpos($equipo, 'teclado') !== false) {

        $datosPCs[] = $detalle;
    }
}

// Ordenar primero por USUARIO y luego por EQUIPO
usort($datosPCs, function($a, $b) {
    $usuarioComparison = strcasecmp($a['USUARIO'] ?? '', $b['USUARIO'] ?? '');
    if ($usuarioComparison === 0) {
        // Si los usuarios son iguales, ordenar por EQUIPO
        // Establecer un orden específico para los equipos
        $ordenEquipos = [
            'unidad central de proceso - cpu' => 1,
            'unidad central de proceso-cpu' => 1,
            'cpu' => 1,
            'monitor led' => 2,
            'teclado' => 3
        ];

        $equipoA = strtolower($a['EQUIPO'] ?? '');
        $equipoB = strtolower($b['EQUIPO'] ?? '');

        $posicionA = 999; // valor por defecto
        $posicionB = 999; // valor por defecto

        // Buscar la posición del equipo A
        foreach ($ordenEquipos as $tipoEquipo => $posicion) {
            if (strpos($equipoA, $tipoEquipo) !== false) {
                $posicionA = $posicion;
                break;
            }
        }

        // Buscar la posición del equipo B
        foreach ($ordenEquipos as $tipoEquipo => $posicion) {
            if (strpos($equipoB, $tipoEquipo) !== false) {
                $posicionB = $posicion;
                break;
            }
        }

        return $posicionA - $posicionB;
    }
    return $usuarioComparison;
});

// Llenar los datos ordenados en la hoja
$rowA = 2;

foreach ($datosPCs as $detalle) {
    $sheetPCs->setCellValue('A' . $rowA, $detalle['DEPENDENCIA'] ?? '');
    $sheetPCs->setCellValue('B' . $rowA, $detalle['ESPECIALIDAD'] ?? '');
    $sheetPCs->setCellValue('C' . $rowA, $detalle['ORGANO'] ?? '');
    $sheetPCs->setCellValue('D' . $rowA, $detalle['USUARIO'] ?? '');
    $sheetPCs->setCellValue('E' . $rowA, $detalle['EQUIPO'] ?? '');
    $sheetPCs->setCellValue('F' . $rowA, $detalle['MARCA'] ?? '');
    $sheetPCs->setCellValue('G' . $rowA, $detalle['MODELO'] ?? '');
    $sheetPCs->setCellValue('H' . $rowA, $detalle['PROCESADOR'] ?? '');
    $sheetPCs->setCellValue('I' . $rowA, $detalle['WINDOWS'] ?? '');
    $sheetPCs->setCellValue('J' . $rowA, $detalle['OFFICE'] ?? '');
    $sheetPCs->setCellValue('K' . $rowA, $detalle['ANTIVIRUS'] ?? '');
    $sheetPCs->setCellValue('L' . $rowA, $detalle["NUMERO DE SERIE"] ?? '');
    $sheetPCs->setCellValue('M' . $rowA, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
    $sheetPCs->setCellValue('N' . $rowA, $detalle['ESTADO'] ?? '');
    $sheetPCs->setCellValue('O' . $rowA, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
    $sheetPCs->setCellValue('P' . $rowA, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
    $sheetPCs->setCellValue('Q' . $rowA, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
    $sheetPCs->setCellValue('R' . $rowA, $detalle['OBSERVACIÓN'] ?? '');
    $sheetPCs->setCellValue('S' . $rowA, $detalle['CORREO'] ?? '');
    $sheetPCs->setCellValue('T' . $rowA, $detalle['NOMBRE_PC'] ?? ''); // PC ASIGNADA

    // Aplicar bordes a las celdas de la fila
    $sheetPCs->getStyle('A' . $rowA . ':T' . $rowA)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Alternar colores de filas para mejor legibilidad
    if ($rowA % 2 == 0) {
        $sheetPCs->getStyle('A' . $rowA . ':T' . $rowA)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8F9FA');
    }

    $rowA++;
}

// Aplicar alineación a todas las celdas de datos de PCs
if ($rowA > 2) {
    $dataRange = 'A2:T' . ($rowA - 1);
    $sheetPCs->getStyle($dataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Aplicar estilo general a los datos de PCs
    $sheetPCs->getStyle($dataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para PCs
    $sheetPCs->setAutoFilter('A1:T' . ($rowA - 1));
}

// Ajustar ancho de columnas automáticamente para PCs
$columns = range('A', 'T');
foreach ($columns as $column) {
    $sheetPCs->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetPCs->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetPCs->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetPCs->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para PCs
$sheetPCs->freezePane('A2');

// Agregar información adicional en una celda para PCs
$sheetPCs->setCellValue('A' . ($rowA + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetPCs->getStyle('A' . ($rowA + 2))->getFont()->setItalic(true)->setSize(9);

$sheetPCs->setCellValue('A' . ($rowA + 3), 'Total de equipos PC: ' . ($rowA - 2));
$sheetPCs->getStyle('A' . ($rowA + 3))->getFont()->setBold(true)->setSize(10);

// ===============================
// CONFIGURAR HOJA "LAPTOPS 01-2025"
// ===============================

// Definir encabezados específicos para laptops
$laptopHeaders = [
    'A' => 'N°',
    'B' => 'SEDE',
    'C' => 'DEPENDENCIA',
    'D' => 'ESPECIALIDAD',
    'E' => 'ÓRGANO',
    'F' => 'USUARIO',
    'G' => 'EQUIPO',
    'H' => 'MARCA',
    'I' => 'MODELO',
    'J' => 'PROCESADOR',
    'K' => 'NUMERO DE SERIE',
    'L' => 'NUMERO DE CONTROL PATRIMONIAL',
    'M' => 'ESTADO',
    'N' => 'AÑO DE ADQUISICIÓN',
    'O' => 'NUMERO DE ORDEN DE COMPRA',
    'P' => 'FUNCIONAMIENTO',
    'Q' => 'OBSERVACIÓN'
];

// Configurar encabezados para laptops
foreach ($laptopHeaders as $column => $header) {
    $sheetLaptops->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de laptops
$laptopHeaderRange = 'A1:Q1';
$sheetLaptops->getStyle($laptopHeaderRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FF28A745'] // Verde para laptops
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

// Ajustar altura de la fila de encabezados para laptops
$sheetLaptops->getRowDimension('1')->setRowHeight(25);

// Filtrar y llenar datos solo de laptops
$laptopRow = 2;
$laptopNum = 1;

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es una laptop (buscar "laptop" en el campo EQUIPO, case-insensitive)
    $equipo = strtolower($detalle['EQUIPO'] ?? '');
    if (strpos($equipo, 'laptop') !== false || strpos($equipo, 'portátil') !== false || strpos($equipo, 'portatil') !== false) {
        $sheetLaptops->setCellValue('A' . $laptopRow, $laptopNum);
        $sheetLaptops->setCellValue('B' . $laptopRow, $detalle['SEDE'] ?? '');
        $sheetLaptops->setCellValue('C' . $laptopRow, $detalle['DEPENDENCIA'] ?? '');
        $sheetLaptops->setCellValue('D' . $laptopRow, $detalle['ESPECIALIDAD'] ?? '');
        $sheetLaptops->setCellValue('E' . $laptopRow, $detalle['ORGANO'] ?? '');
        $sheetLaptops->setCellValue('F' . $laptopRow, $detalle['USUARIO'] ?? '');
        $sheetLaptops->setCellValue('G' . $laptopRow, $detalle['EQUIPO'] ?? '');
        $sheetLaptops->setCellValue('H' . $laptopRow, $detalle['MARCA'] ?? '');
        $sheetLaptops->setCellValue('I' . $laptopRow, $detalle['MODELO'] ?? '');
        $sheetLaptops->setCellValue('J' . $laptopRow, $detalle['PROCESADOR'] ?? '');
        $sheetLaptops->setCellValue('K' . $laptopRow, $detalle["NUMERO DE SERIE"] ?? '');
        $sheetLaptops->setCellValue('L' . $laptopRow, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
        $sheetLaptops->setCellValue('M' . $laptopRow, $detalle['ESTADO'] ?? '');
        $sheetLaptops->setCellValue('N' . $laptopRow, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
        $sheetLaptops->setCellValue('O' . $laptopRow, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
        $sheetLaptops->setCellValue('P' . $laptopRow, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
        $sheetLaptops->setCellValue('Q' . $laptopRow, $detalle['OBSERVACIÓN'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheetLaptops->getStyle('A' . $laptopRow . ':Q' . $laptopRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad
        if ($laptopRow % 2 == 0) {
            $sheetLaptops->getStyle('A' . $laptopRow . ':Q' . $laptopRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0FFF4');
        }

        $laptopRow++;
        $laptopNum++;
    }
}

// Aplicar alineación a todas las celdas de datos de laptops
if ($laptopRow > 2) {
    $laptopDataRange = 'A2:Q' . ($laptopRow - 1);
    $sheetLaptops->getStyle($laptopDataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheetLaptops->getStyle('A2:A' . ($laptopRow - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Aplicar estilo general a los datos de laptops
    $sheetLaptops->getStyle($laptopDataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para laptops
    $sheetLaptops->setAutoFilter('A1:Q' . ($laptopRow - 1));
}

// Ajustar ancho de columnas automáticamente para laptops
$laptopColumns = range('A', 'Q');
foreach ($laptopColumns as $column) {
    $sheetLaptops->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetLaptops->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetLaptops->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetLaptops->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para laptops
$sheetLaptops->freezePane('A2');

// Agregar información adicional para laptops
$sheetLaptops->setCellValue('A' . ($laptopRow + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetLaptops->getStyle('A' . ($laptopRow + 2))->getFont()->setItalic(true)->setSize(9);

$sheetLaptops->setCellValue('A' . ($laptopRow + 3), 'Total de laptops: ' . ($laptopNum - 1));
$sheetLaptops->getStyle('A' . ($laptopRow + 3))->getFont()->setBold(true)->setSize(10);

// ===============================
// CONFIGURAR HOJA "ESTABILIZADORES"
// ===============================

// Definir encabezados específicos para estabilizadores
$estabilizadorHeaders = [
    'A' => 'N°',
    'B' => 'SEDE',
    'C' => 'DEPENDENCIA',
    'D' => 'ESPECIALIDAD',
    'E' => 'ÓRGANO',
    'F' => 'USUARIO',
    'G' => 'EQUIPO',
    'H' => 'MARCA',
    'I' => 'MODELO',
    'J' => 'NUMERO DE SERIE',
    'K' => 'NUMERO DE CONTROL PATRIMONIAL',
    'L' => 'ESTADO',
    'M' => 'AÑO DE ADQUISICIÓN',
    'N' => 'NUMERO DE ORDEN DE COMPRA',
    'O' => 'FUNCIONAMIENTO',
    'P' => 'OBSERVACIÓN'
];

// Configurar encabezados para estabilizadores
foreach ($estabilizadorHeaders as $column => $header) {
    $sheetEstabilizadores->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de estabilizadores
$estabilizadorHeaderRange = 'A1:P1';
$sheetEstabilizadores->getStyle($estabilizadorHeaderRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FFFF6B35'] // Naranja para estabilizadores
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

// Ajustar altura de la fila de encabezados para estabilizadores
$sheetEstabilizadores->getRowDimension('1')->setRowHeight(25);

// Filtrar y llenar datos solo de estabilizadores
$estabilizadorRow = 2;
$estabilizadorNum = 1;

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es un estabilizador (buscar "estabilizador" en el campo EQUIPO, case-insensitive)
    $equipo = strtolower($detalle['EQUIPO'] ?? '');
    if (strpos($equipo, 'estabilizador') !== false) {
        $sheetEstabilizadores->setCellValue('A' . $estabilizadorRow, $estabilizadorNum);
        $sheetEstabilizadores->setCellValue('B' . $estabilizadorRow, $detalle['SEDE'] ?? '');
        $sheetEstabilizadores->setCellValue('C' . $estabilizadorRow, $detalle['DEPENDENCIA'] ?? '');
        $sheetEstabilizadores->setCellValue('D' . $estabilizadorRow, $detalle['ESPECIALIDAD'] ?? '');
        $sheetEstabilizadores->setCellValue('E' . $estabilizadorRow, $detalle['ORGANO'] ?? '');
        $sheetEstabilizadores->setCellValue('F' . $estabilizadorRow, $detalle['USUARIO'] ?? '');
        $sheetEstabilizadores->setCellValue('G' . $estabilizadorRow, $detalle['EQUIPO'] ?? '');
        $sheetEstabilizadores->setCellValue('H' . $estabilizadorRow, $detalle['MARCA'] ?? '');
        $sheetEstabilizadores->setCellValue('I' . $estabilizadorRow, $detalle['MODELO'] ?? '');
        $sheetEstabilizadores->setCellValue('J' . $estabilizadorRow, $detalle["NUMERO DE SERIE"] ?? '');
        $sheetEstabilizadores->setCellValue('K' . $estabilizadorRow, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
        $sheetEstabilizadores->setCellValue('L' . $estabilizadorRow, $detalle['ESTADO'] ?? '');
        $sheetEstabilizadores->setCellValue('M' . $estabilizadorRow, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
        $sheetEstabilizadores->setCellValue('N' . $estabilizadorRow, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
        $sheetEstabilizadores->setCellValue('O' . $estabilizadorRow, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
        $sheetEstabilizadores->setCellValue('P' . $estabilizadorRow, $detalle['OBSERVACIÓN'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheetEstabilizadores->getStyle('A' . $estabilizadorRow . ':P' . $estabilizadorRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad
        if ($estabilizadorRow % 2 == 0) {
            $sheetEstabilizadores->getStyle('A' . $estabilizadorRow . ':P' . $estabilizadorRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEF7F0');
        }

        $estabilizadorRow++;
        $estabilizadorNum++;
    }
}

// Aplicar alineación a todas las celdas de datos de estabilizadores
if ($estabilizadorRow > 2) {
    $estabilizadorDataRange = 'A2:P' . ($estabilizadorRow - 1);
    $sheetEstabilizadores->getStyle($estabilizadorDataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheetEstabilizadores->getStyle('A2:A' . ($estabilizadorRow - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Aplicar estilo general a los datos de estabilizadores
    $sheetEstabilizadores->getStyle($estabilizadorDataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para estabilizadores
    $sheetEstabilizadores->setAutoFilter('A1:P' . ($estabilizadorRow - 1));
}

// Ajustar ancho de columnas automáticamente para estabilizadores
$estabilizadorColumns = range('A', 'P');
foreach ($estabilizadorColumns as $column) {
    $sheetEstabilizadores->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetEstabilizadores->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetEstabilizadores->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetEstabilizadores->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para estabilizadores
$sheetEstabilizadores->freezePane('A2');

// Agregar información adicional para estabilizadores
$sheetEstabilizadores->setCellValue('A' . ($estabilizadorRow + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetEstabilizadores->getStyle('A' . ($estabilizadorRow + 2))->getFont()->setItalic(true)->setSize(9);

$sheetEstabilizadores->setCellValue('A' . ($estabilizadorRow + 3), 'Total de estabilizadores: ' . ($estabilizadorNum - 1));
$sheetEstabilizadores->getStyle('A' . ($estabilizadorRow + 3))->getFont()->setBold(true)->setSize(10);

// ===============================
// CONFIGURAR HOJA "CAMARA WEB"
// ===============================

// Definir encabezados específicos para cámaras web
$camaraWebHeaders = [
    'A' => 'N°',
    'B' => 'SEDE',
    'C' => 'DEPENDENCIA',
    'D' => 'ESPECIALIDAD',
    'E' => 'ÓRGANO',
    'F' => 'USUARIO',
    'G' => 'EQUIPO',
    'H' => 'MARCA',
    'I' => 'MODELO',
    'J' => 'NUMERO DE SERIE',
    'K' => 'NUMERO DE CONTROL PATRIMONIAL',
    'L' => 'ESTADO',
    'M' => 'AÑO DE ADQUISICIÓN',
    'N' => 'NUMERO DE ORDEN DE COMPRA',
    'O' => 'FUNCIONAMIENTO',
    'P' => 'OBSERVACIÓN'
];

// Configurar encabezados para cámaras web
foreach ($camaraWebHeaders as $column => $header) {
    $sheetCamaraWeb->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de cámaras web
$camaraWebHeaderRange = 'A1:P1';
$sheetCamaraWeb->getStyle($camaraWebHeaderRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FF6F42C1'] // Púrpura para cámaras web
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

// Ajustar altura de la fila de encabezados para cámaras web
$sheetCamaraWeb->getRowDimension('1')->setRowHeight(25);

// Filtrar y llenar datos solo de cámaras web
$camaraWebRow = 2;
$camaraWebNum = 1;

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es una cámara web - CORREGIDO para capturar "VIDEO CÁMARA PARA COMPUTADORA"
    $equipo = strtolower($detalle['EQUIPO'] ?? '');

    // Buscar específicamente las variantes de cámara web
    if (strpos($equipo, 'video cámara para computadora') !== false ||
        strpos($equipo, 'video camara para computadora') !== false ||
        strpos($equipo, 'videocámara para computadora') !== false ||
        strpos($equipo, 'videocamara para computadora') !== false ||
        strpos($equipo, 'cámara web') !== false ||
        strpos($equipo, 'camara web') !== false ||
        strpos($equipo, 'webcam') !== false ||
        strpos($equipo, 'web cam') !== false ||
        (strpos($equipo, 'cámara') !== false && strpos($equipo, 'computadora') !== false) ||
        (strpos($equipo, 'camara') !== false && strpos($equipo, 'computadora') !== false)) {

        $sheetCamaraWeb->setCellValue('A' . $camaraWebRow, $camaraWebNum);
        $sheetCamaraWeb->setCellValue('B' . $camaraWebRow, $detalle['SEDE'] ?? '');
        $sheetCamaraWeb->setCellValue('C' . $camaraWebRow, $detalle['DEPENDENCIA'] ?? '');
        $sheetCamaraWeb->setCellValue('D' . $camaraWebRow, $detalle['ESPECIALIDAD'] ?? '');
        $sheetCamaraWeb->setCellValue('E' . $camaraWebRow, $detalle['ORGANO'] ?? '');
        $sheetCamaraWeb->setCellValue('F' . $camaraWebRow, $detalle['USUARIO'] ?? '');
        $sheetCamaraWeb->setCellValue('G' . $camaraWebRow, $detalle['EQUIPO'] ?? '');
        $sheetCamaraWeb->setCellValue('H' . $camaraWebRow, $detalle['MARCA'] ?? '');
        $sheetCamaraWeb->setCellValue('I' . $camaraWebRow, $detalle['MODELO'] ?? '');
        $sheetCamaraWeb->setCellValue('J' . $camaraWebRow, $detalle["NUMERO DE SERIE"] ?? '');
        $sheetCamaraWeb->setCellValue('K' . $camaraWebRow, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
        $sheetCamaraWeb->setCellValue('L' . $camaraWebRow, $detalle['ESTADO'] ?? '');
        $sheetCamaraWeb->setCellValue('M' . $camaraWebRow, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
        $sheetCamaraWeb->setCellValue('N' . $camaraWebRow, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
        $sheetCamaraWeb->setCellValue('O' . $camaraWebRow, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
        $sheetCamaraWeb->setCellValue('P' . $camaraWebRow, $detalle['OBSERVACIÓN'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheetCamaraWeb->getStyle('A' . $camaraWebRow . ':P' . $camaraWebRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad
        if ($camaraWebRow % 2 == 0) {
            $sheetCamaraWeb->getStyle('A' . $camaraWebRow . ':P' . $camaraWebRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8F5FF');
        }

        $camaraWebRow++;
        $camaraWebNum++;
    }
}

// Aplicar alineación a todas las celdas de datos de cámaras web
if ($camaraWebRow > 2) {
    $camaraWebDataRange = 'A2:P' . ($camaraWebRow - 1);
    $sheetCamaraWeb->getStyle($camaraWebDataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheetCamaraWeb->getStyle('A2:A' . ($camaraWebRow - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Aplicar estilo general a los datos de cámaras web
    $sheetCamaraWeb->getStyle($camaraWebDataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para cámaras web
    $sheetCamaraWeb->setAutoFilter('A1:P' . ($camaraWebRow - 1));
}

// Ajustar ancho de columnas automáticamente para cámaras web
$camaraWebColumns = range('A', 'P');
foreach ($camaraWebColumns as $column) {
    $sheetCamaraWeb->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetCamaraWeb->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetCamaraWeb->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetCamaraWeb->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para cámaras web
$sheetCamaraWeb->freezePane('A2');

// Agregar información adicional para cámaras web
$sheetCamaraWeb->setCellValue('A' . ($camaraWebRow + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetCamaraWeb->getStyle('A' . ($camaraWebRow + 2))->getFont()->setItalic(true)->setSize(9);

$sheetCamaraWeb->setCellValue('A' . ($camaraWebRow + 3), 'Total de cámaras web: ' . ($camaraWebNum - 1));
$sheetCamaraWeb->getStyle('A' . ($camaraWebRow + 3))->getFont()->setBold(true)->setSize(10);



// Crear la hoja "ESCANER"
$sheetEscaner = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'ESCANER');
$spreadsheet->addSheet($sheetEscaner, 4);

// Crear la hoja "IMPRESORAS"
$sheetImpresoras = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'IMPRESORAS');
$spreadsheet->addSheet($sheetImpresoras, 5);

// 2. AGREGAR AL FINAL, DESPUÉS DE LA SECCIÓN "CAMARA WEB" Y ANTES DE "Configurar propiedades del documento":

// ===============================
// CONFIGURAR HOJA "ESCANER"
// ===============================

// Definir encabezados específicos para escáneres
$escanerHeaders = [
    'A' => 'N°',
    'B' => 'SEDE',
    'C' => 'DEPENDENCIA',
    'D' => 'ESPECIALIDAD',
    'E' => 'ÓRGANO',
    'F' => 'USUARIO',
    'G' => 'EQUIPO',
    'H' => 'MARCA',
    'I' => 'MODELO',
    'J' => 'NUMERO DE SERIE',
    'K' => 'NUMERO DE CONTROL PATRIMONIAL',
    'L' => 'ESTADO',
    'M' => 'AÑO DE ADQUISICIÓN',
    'N' => 'NUMERO DE ORDEN DE COMPRA',
    'O' => 'FUNCIONAMIENTO',
    'P' => 'OBSERVACIÓN'
];

// Configurar encabezados para escáneres
foreach ($escanerHeaders as $column => $header) {
    $sheetEscaner->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de escáneres
$escanerHeaderRange = 'A1:P1';
$sheetEscaner->getStyle($escanerHeaderRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FF17A2B8'] // Azul cyan para escáneres
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

// Ajustar altura de la fila de encabezados para escáneres
$sheetEscaner->getRowDimension('1')->setRowHeight(25);

// Filtrar y llenar datos solo de escáneres
$escanerRow = 2;
$escanerNum = 1;

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es un escáner
    $equipo = strtolower($detalle['EQUIPO'] ?? '');
    if (strpos($equipo, 'escaner') !== false ||
        strpos($equipo, 'escáner') !== false ||
        strpos($equipo, 'scanner') !== false) {

        $sheetEscaner->setCellValue('A' . $escanerRow, $escanerNum);
        $sheetEscaner->setCellValue('B' . $escanerRow, $detalle['SEDE'] ?? '');
        $sheetEscaner->setCellValue('C' . $escanerRow, $detalle['DEPENDENCIA'] ?? '');
        $sheetEscaner->setCellValue('D' . $escanerRow, $detalle['ESPECIALIDAD'] ?? '');
        $sheetEscaner->setCellValue('E' . $escanerRow, $detalle['ORGANO'] ?? '');
        $sheetEscaner->setCellValue('F' . $escanerRow, $detalle['USUARIO'] ?? '');
        $sheetEscaner->setCellValue('G' . $escanerRow, $detalle['EQUIPO'] ?? '');
        $sheetEscaner->setCellValue('H' . $escanerRow, $detalle['MARCA'] ?? '');
        $sheetEscaner->setCellValue('I' . $escanerRow, $detalle['MODELO'] ?? '');
        $sheetEscaner->setCellValue('J' . $escanerRow, $detalle["NUMERO DE SERIE"] ?? '');
        $sheetEscaner->setCellValue('K' . $escanerRow, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
        $sheetEscaner->setCellValue('L' . $escanerRow, $detalle['ESTADO'] ?? '');
        $sheetEscaner->setCellValue('M' . $escanerRow, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
        $sheetEscaner->setCellValue('N' . $escanerRow, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
        $sheetEscaner->setCellValue('O' . $escanerRow, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
        $sheetEscaner->setCellValue('P' . $escanerRow, $detalle['OBSERVACIÓN'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheetEscaner->getStyle('A' . $escanerRow . ':P' . $escanerRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad
        if ($escanerRow % 2 == 0) {
            $sheetEscaner->getStyle('A' . $escanerRow . ':P' . $escanerRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F8FF');
        }

        $escanerRow++;
        $escanerNum++;
    }
}

// Aplicar alineación a todas las celdas de datos de escáneres
if ($escanerRow > 2) {
    $escanerDataRange = 'A2:P' . ($escanerRow - 1);
    $sheetEscaner->getStyle($escanerDataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheetEscaner->getStyle('A2:A' . ($escanerRow - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Aplicar estilo general a los datos de escáneres
    $sheetEscaner->getStyle($escanerDataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para escáneres
    $sheetEscaner->setAutoFilter('A1:P' . ($escanerRow - 1));
}

// Ajustar ancho de columnas automáticamente para escáneres
$escanerColumns = range('A', 'P');
foreach ($escanerColumns as $column) {
    $sheetEscaner->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetEscaner->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetEscaner->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetEscaner->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para escáneres
$sheetEscaner->freezePane('A2');

// Agregar información adicional para escáneres
$sheetEscaner->setCellValue('A' . ($escanerRow + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetEscaner->getStyle('A' . ($escanerRow + 2))->getFont()->setItalic(true)->setSize(9);

$sheetEscaner->setCellValue('A' . ($escanerRow + 3), 'Total de escáneres: ' . ($escanerNum - 1));
$sheetEscaner->getStyle('A' . ($escanerRow + 3))->getFont()->setBold(true)->setSize(10);

// ===============================
// CONFIGURAR HOJA "IMPRESORAS"
// ===============================

// Definir encabezados específicos para impresoras
$impresoraHeaders = [
    'A' => 'N°',
    'B' => 'PISO',
    'C' => 'SEDE',
    'D' => 'DEPENDENCIA',
    'E' => 'ESPECIALIDAD',
    'F' => 'ÓRGANO',
    'G' => 'USUARIO',
    'H' => 'EQUIPO',
    'I' => 'MARCA',
    'J' => 'MODELO',
    'K' => 'PROCESADOR',
    'L' => 'NUMERO DE SERIE',
    'M' => 'NUMERO DE CONTROL PATRIMONIAL',
    'N' => 'ESTADO',
    'O' => 'AÑO DE ADQUISICIÓN',
    'P' => 'NUMERO DE ORDEN DE COMPRA',
    'Q' => 'FUNCIONAMIENTO',
    'R' => 'OBSERVACIÓN'
];

// Configurar encabezados para impresoras
foreach ($impresoraHeaders as $column => $header) {
    $sheetImpresoras->setCellValue($column . '1', $header);
}

// Aplicar estilo a los encabezados de impresoras
$impresoraHeaderRange = 'A1:R1';
$sheetImpresoras->getStyle($impresoraHeaderRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 11,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FFDC3545'] // Rojo para impresoras
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

// Ajustar altura de la fila de encabezados para impresoras
$sheetImpresoras->getRowDimension('1')->setRowHeight(25);

// Filtrar y llenar datos solo de impresoras
$impresoraRow = 2;
$impresoraNum = 1;

foreach ($bienPersonaX as $detalle) {
    // Verificar si el equipo es una impresora
    $equipo = strtolower($detalle['EQUIPO'] ?? '');
    if (strpos($equipo, 'impresora') !== false ||
        strpos($equipo, 'printer') !== false) {

        $sheetImpresoras->setCellValue('A' . $impresoraRow, $impresoraNum);
        $sheetImpresoras->setCellValue('B' . $impresoraRow, $detalle['PISO'] ?? ''); // Campo PISO
        $sheetImpresoras->setCellValue('C' . $impresoraRow, $detalle['SEDE'] ?? '');
        $sheetImpresoras->setCellValue('D' . $impresoraRow, $detalle['DEPENDENCIA'] ?? '');
        $sheetImpresoras->setCellValue('E' . $impresoraRow, $detalle['ESPECIALIDAD'] ?? '');
        $sheetImpresoras->setCellValue('F' . $impresoraRow, $detalle['ORGANO'] ?? '');
        $sheetImpresoras->setCellValue('G' . $impresoraRow, $detalle['USUARIO'] ?? '');
        $sheetImpresoras->setCellValue('H' . $impresoraRow, $detalle['EQUIPO'] ?? '');
        $sheetImpresoras->setCellValue('I' . $impresoraRow, $detalle['MARCA'] ?? '');
        $sheetImpresoras->setCellValue('J' . $impresoraRow, $detalle['MODELO'] ?? '');
        $sheetImpresoras->setCellValue('K' . $impresoraRow, $detalle['PROCESADOR'] ?? '');
        $sheetImpresoras->setCellValue('L' . $impresoraRow, $detalle["NUMERO DE SERIE"] ?? '');
        $sheetImpresoras->setCellValue('M' . $impresoraRow, $detalle["NUMERO DE CONTROL PATRIMONIAL"] ?? '');
        $sheetImpresoras->setCellValue('N' . $impresoraRow, $detalle['ESTADO'] ?? '');
        $sheetImpresoras->setCellValue('O' . $impresoraRow, $detalle["AÑO DE ADQUISICIÓN"] ?? '');
        $sheetImpresoras->setCellValue('P' . $impresoraRow, $detalle["NUMERO DE ORDEN DE COMPRA"] ?? '');
        $sheetImpresoras->setCellValue('Q' . $impresoraRow, traducirFuncionamiento($detalle['FUNCIONAMIENTO'] ?? 0));
        $sheetImpresoras->setCellValue('R' . $impresoraRow, $detalle['OBSERVACIÓN'] ?? '');

        // Aplicar bordes a las celdas de la fila
        $sheetImpresoras->getStyle('A' . $impresoraRow . ':R' . $impresoraRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alternar colores de filas para mejor legibilidad
        if ($impresoraRow % 2 == 0) {
            $sheetImpresoras->getStyle('A' . $impresoraRow . ':R' . $impresoraRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEF2F2');
        }

        $impresoraRow++;
        $impresoraNum++;
    }
}

// Aplicar alineación a todas las celdas de datos de impresoras
if ($impresoraRow > 2) {
    $impresoraDataRange = 'A2:R' . ($impresoraRow - 1);
    $sheetImpresoras->getStyle($impresoraDataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheetImpresoras->getStyle('A2:A' . ($impresoraRow - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Aplicar estilo general a los datos de impresoras
    $sheetImpresoras->getStyle($impresoraDataRange)->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => 10
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFD0D0D0'],
            ],
        ],
    ]);

    // Aplicar filtros automáticos para impresoras
    $sheetImpresoras->setAutoFilter('A1:R' . ($impresoraRow - 1));
}

// Ajustar ancho de columnas automáticamente para impresoras
$impresoraColumns = range('A', 'R');
foreach ($impresoraColumns as $column) {
    $sheetImpresoras->getColumnDimension($column)->setAutoSize(true);

    // Establecer un ancho mínimo y máximo para mejor visualización
    $currentWidth = $sheetImpresoras->getColumnDimension($column)->getWidth();
    if ($currentWidth < 10) {
        $sheetImpresoras->getColumnDimension($column)->setWidth(10);
    } elseif ($currentWidth > 30) {
        $sheetImpresoras->getColumnDimension($column)->setWidth(30);
    }
}

// Congelar paneles (primera fila) para impresoras
$sheetImpresoras->freezePane('A2');

// Agregar información adicional para impresoras
$sheetImpresoras->setCellValue('A' . ($impresoraRow + 2), 'Generado el: ' . date('d/m/Y H:i:s'));
$sheetImpresoras->getStyle('A' . ($impresoraRow + 2))->getFont()->setItalic(true)->setSize(9);

$sheetImpresoras->setCellValue('A' . ($impresoraRow + 3), 'Total de impresoras: ' . ($impresoraNum - 1));
$sheetImpresoras->getStyle('A' . ($impresoraRow + 3))->getFont()->setBold(true)->setSize(10);

// Configurar propiedades del documento
$spreadsheet->getProperties()
    ->setCreator("Sistema de Bienes Informáticos NCPP")
    ->setLastModifiedBy("Sistema Automatizado")
    ->setTitle("INVENTARIO NCPP 2025 - X")
    ->setSubject("Inventario de Equipos Informáticos")
    ->setDescription("Reporte completo del inventario de PCs y equipos informáticos del NCPP")
    ->setKeywords("inventario, equipos, informaticos, NCPP, 2025")
    ->setCategory("Inventarios");

// Configurar el nombre del archivo de salida
$filename = 'INVENTARIO_NCPP_2025_-_X.xlsx';

// Configurar las cabeceras para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Fecha en el pasado
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // Siempre modificado
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

// Crear el writer y guardar
$writer = new Xlsx($spreadsheet);

// Guardar el archivo y forzar la descarga
$writer->save('php://output');
exit;
?>
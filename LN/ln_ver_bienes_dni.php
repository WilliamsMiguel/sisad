<style>
    /* Estilo normal (pantalla) */
    tr.desvinculado {
        background-color: #ffcccc;
    }

    /* Estilo específico para impresión */
    @media print {
        tr.desvinculado {
            background-color: #ffcccc !important;
            -webkit-print-color-adjust: exact !important; /* Chrome/Safari */
            print-color-adjust: exact !important;         /* Estándar moderno */
            color-adjust: exact !important;               /* Compatibilidad extra */
        }
    }
</style>

<?php
include '../AD/ad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dniP = isset($_POST['dniP']) ? trim($_POST['dniP']) : '';

    if ($dniP === '') {
        echo '<p style="color: red;">El DNI es obligatorio.</p>';
        exit;
    }

    $bienesConPersonasActualVerDNI = listar_bienes_por_dni($dniP);

    if (empty($bienesConPersonasActualVerDNI)) {
        echo '<p>No se encontraron bienes asignados para el DNI proporcionado.</p>';
    } else {
        $output = '<table border="1" cellspacing="0" cellpadding="5">';
        $output .= '<thead>
                    <tr>
                        <th>SEDE</th>
                        <th>AREA</th>             <!-- ✅ Nuevo -->
                        <th>DEPENDENCIA</th>
                        <th>USUARIO</th>
                        <th>EQUIPO</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>PROCESADOR</th>
                        <th>NUMERO DE SERIE</th>
                        <th>NUMERO DE CONTROL PATRIMONIAL</th>
                        <th>ESTADO</th>
                        <th>AÑO DE ADQUISICIÓN</th>
                        <th>NUMERO DE ORDEN DE COMPRA</th>
                        <th>FUNCIONAMIENTO</th>
                        <th>OBSERVACIÓN</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach ($bienesConPersonasActualVerDNI as $bienP)
        {
            // Pintar en rojo claro si fue desvinculado (estado_detalle_movimiento = 2)
            $rowClass = (isset($bienP['estado_detalle_movimiento']) && (int)$bienP['estado_detalle_movimiento'] === 2)
                ? ' class="desvinculado"'
                : '';

            $output .= "<tr{$rowClass}>";

            // Imprimir solo las columnas visibles (omitimos estado_detalle_movimiento)
            foreach ($bienP as $key => $value) {
                if ($key !== 'estado_detalle_movimiento') {
                    $output .= '<td>' . htmlspecialchars($value) . '</td>';
                }
            }

            $output .= '</tr>';
        }

        $output .= '</tbody>
                    </table>';
        echo $output;
    }
} else {
    echo '<p>Acceso no permitido.</p>';
}

?>



<?php
// Obtener la lista de movimientos y sus detalles desde la capa LN
session_start();
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_ver_bienes_inicial.php';

$funcionamientos = [
    1 => 'Operativo',
    2 => 'Inoperativo',
    3 => 'Regular'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Bienes Informáticos</title>

    <link href="../libreria/bootstrap.min.css" rel="stylesheet">
    <link href="../libreria/select2.min.css" rel="stylesheet"/>
    <script src="../libreria/jquery-3.6.0.min.js"></script>
    <script src="../libreria/select2.min.js"></script>
    <script src="../libreria/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../libreria/fontawesome/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-red: #b91c1c;
            --dark-red: #7f1d1d;
            --accent-red: #dc2626;
            --light-red: #ef4444;
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.95);
            --text-light: #f8fafc;
            --text-gray: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: rgba(148, 163, 184, 0.2);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --shadow-primary: 0 4px 20px rgba(185, 28, 28, 0.25);
            --shadow-subtle: 0 8px 32px rgba(0, 0, 0, 0.4);
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --danger-red: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f1419 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Grid sutil de fondo */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                    linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        .main-container {
            position: relative;
            z-index: 10;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .modern-header {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-subtle);
            position: relative;
            text-align: center;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 20px 20px 0 0;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
            margin-bottom: 10px;
        }

        .header-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 0.025em;
        }

        .controls-section {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-subtle);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .controls-section:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
        }

        .search-container {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 12px;
            color: var(--text-light);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
            transform: translateY(-1px);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .search-input:focus + .search-icon {
            color: var(--primary-red);
        }

        .search-info {
            margin-top: 12px;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .table-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
            position: relative;
        }

        .table-wrapper {
            max-height: 600px;
            overflow-y: auto;
            overflow-x: auto;
            position: relative;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
            min-width: 1400px;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, var(--dark-bg), var(--card-bg));
            color: var(--text-light);
            padding: 20px 12px;
            text-align: left;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 2px solid var(--primary-red);
            white-space: nowrap;
        }

        .modern-table thead th i {
            margin-right: 6px;
            color: var(--accent-red);
            opacity: 0.8;
        }

        .modern-table tbody tr {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modern-table tbody tr:hover {
            background: rgba(185, 28, 28, 0.1);
            transform: translateX(3px);
        }

        .modern-table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.04);
        }

        .modern-table tbody tr:nth-child(even):hover {
            background: rgba(185, 28, 28, 0.15);
        }

        .modern-table tbody td {
            padding: 16px 12px;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-gray);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            vertical-align: middle;
        }

        .modern-table tbody td:last-child {
            border-right: none;
            max-width: 200px;
            white-space: normal;
            word-wrap: break-word;
        }

        /* Tooltips para celdas con contenido largo */
        .modern-table tbody td[title] {
            cursor: help;
        }

        /* Estados y badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            text-align: center;
            min-width: 80px;
            transition: all 0.3s ease;
        }

        .status-operativo {
            background: linear-gradient(135deg, var(--success-green), #059669);
            color: var(--text-light);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-inoperativo {
            background: linear-gradient(135deg, var(--danger-red), #dc2626);
            color: var(--text-light);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .status-regular {
            background: linear-gradient(135deg, var(--warning-orange), #d97706);
            color: var(--dark-bg);
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .status-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .export-section {
            margin-top: 30px;
            text-align: center;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--success-green), #059669);
            color: var(--text-light);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .export-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .export-btn:hover::before {
            left: 100%;
        }

        .export-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
            color: var(--text-light);
            text-decoration: none;
            background: linear-gradient(135deg, #10b981, var(--success-green));
        }

        .export-btn:active {
            transform: translateY(-1px);
        }

        .export-btn i {
            font-size: 1.1rem;
        }

        /* Scrollbar personalizado */
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }

        .table-wrapper::-webkit-scrollbar-corner {
            background: var(--card-bg);
        }

        /* Loading spinner */
        .loading-spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 100;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid var(--primary-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mensaje de búsqueda */
        #searchMessage {
            background: rgba(185, 28, 28, 0.1) !important;
            border-left: 4px solid var(--primary-red);
        }

        #searchMessage td {
            padding: 40px 20px !important;
            text-align: center;
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 500;
        }

        #searchMessage i {
            color: var(--primary-red);
            opacity: 0.8;
            font-size: 2rem;
            display: block;
            margin-bottom: 15px;
        }

        /* Notificaciones modernas */
        .modern-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 25px;
            border-radius: 12px;
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            z-index: 10000;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-weight: 600;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modern-notification.success {
            background: rgba(16, 185, 129, 0.9);
            color: var(--text-light);
        }

        .modern-notification.error {
            background: var(--card-bg);
            color: var(--danger-red);
            border-color: var(--danger-red);
        }

        .modern-notification.info {
            background: var(--card-bg);
            color: var(--text-light);
            border-color: var(--primary-red);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .main-container {
                padding: 30px 15px;
            }

            .modern-table {
                font-size: 0.8rem;
                min-width: 1200px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px 10px;
            }

            .header-title {
                font-size: 2rem;
            }

            .modern-header {
                padding: 30px 20px;
            }

            .controls-section {
                padding: 20px 15px;
            }

            .modern-table {
                font-size: 0.75rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 12px 8px;
            }

            .status-badge {
                font-size: 0.7rem;
                padding: 4px 8px;
                min-width: 70px;
            }

            .export-btn {
                padding: 14px 24px;
                font-size: 0.9rem;
            }

            .search-input {
                padding: 12px 16px 12px 45px;
                font-size: 0.9rem;
            }

            .search-icon {
                left: 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 15px 10px;
            }

            .header-title {
                font-size: 1.8rem;
            }

            .table-wrapper {
                max-height: 50vh;
            }

            .modern-table {
                font-size: 0.7rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 10px 6px;
            }
        }

        /* Efectos suaves sin animaciones pesadas */
        .hover-effect {
            transition: all 0.2s ease;
        }

        .hover-effect:hover {
            transform: translateY(-1px);
        }

        /* Focus states mejorados */
        .search-input:focus,
        .export-btn:focus {
            outline: 2px solid var(--primary-red);
            outline-offset: 2px;
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Header moderno -->
    <div class="modern-header">
        <h1 class="header-title">
            <i class="fas fa-desktop"></i>
            Sistema de Bienes Informáticos
        </h1>
        <p class="header-subtitle">Gestión y control de equipos asignados a usuarios</p>
    </div>

    <!-- Sección de controles -->
    <div class="controls-section">
        <div class="search-container">
            <input type="text" id="buscarBienP" class="search-input" placeholder="Buscar en cualquier campo...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="search-info" style="margin-top: 10px; color: var(--text-secondary); font-size: 12px; text-align: center;">
            <i class="fas fa-info-circle"></i> Busca por sede, dependencia, usuario, equipo, marca, modelo, procesador, serie, etc.
        </div>
    </div>

    <!-- Contenedor de tabla -->
    <div class="table-container">
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner"></div>
        </div>

        <div class="table-wrapper" id="bienesTable">
            <table class="modern-table">
                <thead>
                <tr>
                    <th><i class="fas fa-building"></i> SEDE</th>
                    <th><i class="fas fa-sitemap"></i> DEPENDENCIA</th>
                    <th><i class="fas fa-graduation-cap"></i> ESPECIALIDAD</th>
                    <th><i class="fas fa-landmark"></i> ÓRGANO</th>
                    <th><i class="fas fa-user"></i> USUARIO</th>
                    <th><i class="fas fa-laptop"></i> EQUIPO</th>
                    <th><i class="fas fa-tag"></i> MARCA</th>
                    <th><i class="fas fa-info-circle"></i> MODELO</th>
                    <th><i class="fas fa-microchip"></i> PROCESADOR</th>
                    <th><i class="fas fa-desktop"></i> NOMBRE PC</th>
                    <th><i class="fab fa-windows"></i> WINDOWS</th>
                    <th><i class="fas fa-file-word"></i> OFFICE</th>
                    <th><i class="fas fa-shield-alt"></i> ANTIVIRUS</th>
                    <th><i class="fas fa-barcode"></i> N°.SERIE</th>
                    <th><i class="fas fa-hashtag"></i> N°.CP</th>
                    <th><i class="fas fa-flag"></i> ESTADO</th>
                    <th><i class="fas fa-calendar"></i> AÑO A</th>
                    <th><i class="fas fa-receipt"></i> O.D</th>
                    <th><i class="fas fa-cogs"></i> FUNCIONAMIENTO</th>
                    <th><i class="fas fa-comment"></i> OBSERVACIÓN</th>
                    <th><i class="fas fa-envelope"></i> CORREO</th>
                </tr>
                </thead>
                <tbody id="listaBiesConPersonas">
                <?php foreach ($bienesConPersonasActualVer as $bienPX): ?>
                    <tr data-id="<?php echo $bienPX['id_detallemovimiento']; ?>">
                        <td title="<?php echo $bienPX['SEDE']; ?>"><?php echo $bienPX['SEDE']; ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['DEPENDENCIA']); ?>"><?php echo htmlspecialchars($bienPX['DEPENDENCIA']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['ESPECIALIDAD']); ?>"><?php echo htmlspecialchars($bienPX['ESPECIALIDAD']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['ORGANO']); ?>"><?php echo htmlspecialchars($bienPX['ORGANO']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['USUARIO']); ?>"><?php echo htmlspecialchars($bienPX['USUARIO']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['EQUIPO']); ?>"><?php echo htmlspecialchars($bienPX['EQUIPO']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['MARCA']); ?>"><?php echo htmlspecialchars($bienPX['MARCA']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['MODELO']); ?>"><?php echo htmlspecialchars($bienPX['MODELO']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['PROCESADOR']); ?>"><?php echo htmlspecialchars($bienPX['PROCESADOR']); ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['NOMBRE_PC']); ?>">
                            <?php if (!empty($bienPX['NOMBRE_PC'])): ?>
                                <span class="pc-name-badge"><?php echo htmlspecialchars($bienPX['NOMBRE_PC']); ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td title="<?php echo $bienPX['WINDOWS']; ?>">
                            <?php if (!empty($bienPX['WINDOWS'])): ?>
                                <span class="software-badge windows-badge"><?php echo $bienPX['WINDOWS']; ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td title="<?php echo $bienPX['OFFICE']; ?>">
                            <?php if (!empty($bienPX['OFFICE'])): ?>
                                <span class="software-badge office-badge"><?php echo $bienPX['OFFICE']; ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td title="<?php echo $bienPX['ANTIVIRUS']; ?>">
                            <?php if (!empty($bienPX['ANTIVIRUS'])): ?>
                                <span class="software-badge antivirus-badge"><?php echo $bienPX['ANTIVIRUS']; ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td title="<?php echo $bienPX['NUMERO DE SERIE']; ?>"><?php echo $bienPX['NUMERO DE SERIE']; ?></td>
                        <td title="<?php echo $bienPX['NUMERO DE CONTROL PATRIMONIAL']; ?>"><?php echo $bienPX['NUMERO DE CONTROL PATRIMONIAL']; ?></td>
                        <td title="<?php echo $bienPX['ESTADO']; ?>"><?php echo $bienPX['ESTADO']; ?></td>
                        <td title="<?php echo $bienPX['AÑO DE ADQUISICIÓN']; ?>"><?php echo $bienPX['AÑO DE ADQUISICIÓN']; ?></td>
                        <td title="<?php echo $bienPX['NUMERO DE ORDEN DE COMPRA']; ?>"><?php echo $bienPX['NUMERO DE ORDEN DE COMPRA']; ?></td>
                        <td>
                            <?php
                            $funcionamiento = $funcionamientos[$bienPX['FUNCIONAMIENTO']] ?? 'Desconocido';
                            $statusClass = '';
                            switch($bienPX['FUNCIONAMIENTO']) {
                                case 1: $statusClass = 'status-operativo'; break;
                                case 2: $statusClass = 'status-inoperativo'; break;
                                case 3: $statusClass = 'status-regular'; break;
                            }
                            ?>
                            <span class="status-badge <?php echo $statusClass; ?>"><?php echo $funcionamiento; ?></span>
                        </td>
                        <td title="<?php echo $bienPX['OBSERVACIÓN']; ?>"><?php echo $bienPX['OBSERVACIÓN']; ?></td>
                        <td title="<?php echo htmlspecialchars($bienPX['CORREO']); ?>"><?php echo htmlspecialchars($bienPX['CORREO']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sección de exportar -->
    <div class="export-section">
        <a href="../LN/ln_generar_excel_bienes.php" target="_blank" class="export-btn pulse-effect">
            <i class="fas fa-file-excel"></i>
            Exportar a Excel
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Función para mostrar/ocultar spinner
        function showLoading(show) {
            if (show) {
                $('#loadingSpinner').fadeIn(200);
            } else {
                $('#loadingSpinner').fadeOut(200);
            }
        }

        // Búsqueda mejorada con filtrado en tiempo real por cualquier columna
        let searchTimeout;
        $('#buscarBienP').on('keyup', function() {
            const query = $(this).val().toLowerCase().trim();
            const searchIcon = $('.search-icon');

            // Cambiar icono a loading
            searchIcon.removeClass('fa-search').addClass('fa-spinner fa-spin');

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {

                if (query === '') {
                    // Si no hay búsqueda, mostrar todas las filas
                    $('#listaBiesConPersonas tr').show();
                    updateRowVisibility();
                } else {
                    // Filtrar filas localmente
                    let visibleCount = 0;
                    $('#listaBiesConPersonas tr').each(function() {
                        const row = $(this);
                        const rowText = row.text().toLowerCase();

                        if (rowText.includes(query)) {
                            row.show().css({
                                'animation': 'fadeInUp 0.3s ease'
                            });
                            visibleCount++;
                        } else {
                            row.hide();
                        }
                    });

                    // Mostrar mensaje si no hay resultados
                    if (visibleCount === 0 && query !== '') {
                        showSearchMessage('No se encontraron resultados para: "' + query + '"');
                    } else {
                        hideSearchMessage();
                    }
                }

                // Restaurar icono
                searchIcon.removeClass('fa-spinner fa-spin').addClass('fa-search');
            }, 300); // Reducido el delay para mejor UX
        });

        // Funciones auxiliares para el buscador
        function showSearchMessage(message) {
            hideSearchMessage();
            const messageRow = $(`
                <tr id="searchMessage" style="background: rgba(220, 20, 60, 0.1);">
                    <td colspan="14" style="text-align: center; padding: 30px; color: var(--text-secondary);">
                        <i class="fas fa-search" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        ${message}
                        <br><small style="margin-top: 10px; display: block;">Intenta con otros términos de búsqueda</small>
                    </td>
                </tr>
            `);
            $('#listaBiesConPersonas').append(messageRow);
            messageRow.hide().fadeIn(300);
        }

        function hideSearchMessage() {
            $('#searchMessage').fadeOut(200, function() {
                $(this).remove();
            });
        }

        function updateRowVisibility() {
            hideSearchMessage();
            // Agregar efecto de fade in a las filas visibles
            $('#listaBiesConPersonas tr:visible').each(function(index) {
                const row = $(this);
                row.css({
                    'animation': `fadeInUp 0.3s ease ${index * 0.05}s both`
                });
            });
        }

        // Sistema de notificaciones moderno
        function showNotification(message, type = 'info') {
            const notification = $(`
                <div class="modern-notification ${type}" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 25px;
                    background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
                    color: white;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                    z-index: 10000;
                    transform: translateX(400px);
                    transition: all 0.3s ease;
                    font-weight: 500;
                    border: 1px solid rgba(255,255,255,0.1);
                    backdrop-filter: blur(10px);
                ">
                    <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                    ${message}
                </div>
            `);

            $('body').append(notification);

            setTimeout(() => {
                notification.css('transform', 'translateX(0)');
            }, 100);

            setTimeout(() => {
                notification.css('transform', 'translateX(400px)');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Efectos hover mejorados para filas
        $('#listaBiesConPersonas').on('mouseenter', 'tr', function() {
            $(this).addClass('pulse-effect');
        }).on('mouseleave', 'tr', function() {
            $(this).removeClass('pulse-effect');
        });

        // Función cargarlistaBiesConPersonas mantenida
        function cargarlistaBiesConPersonas() {
            var numFilas = $('#numFilas').val();
            showLoading(true);

            $.ajax({
                url: '../LN/ln_ver_movimientos.php',
                type: 'POST',
                data: { numFilas: numFilas },
                success: function(response) {
                    $('#listaBiesConPersonas').html(response);
                },
                error: function() {
                    showNotification('Error al cargar los movimientos', 'error');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        // Efecto de typing en el placeholder con frases de búsqueda general
        const searchInput = document.getElementById('buscarBienP');
        const phrases = [
            'Buscar en cualquier campo...',
            'Ingrese nombre de usuario...',
            'Escriba marca o modelo...',
            'Buscar por sede o dependencia...',
            'Número de serie o código...',
            'Estado o tipo de equipo...',
            'Procesador o año...'
        ];

        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        function typeEffect() {
            const currentPhrase = phrases[phraseIndex];

            if (searchInput.value === '') {
                if (!isDeleting && charIndex < currentPhrase.length) {
                    searchInput.placeholder = currentPhrase.substring(0, charIndex + 1);
                    charIndex++;
                    setTimeout(typeEffect, 100);
                } else if (!isDeleting && charIndex === currentPhrase.length) {
                    setTimeout(() => {
                        isDeleting = true;
                        typeEffect();
                    }, 2000);
                } else if (isDeleting && charIndex > 0) {
                    searchInput.placeholder = currentPhrase.substring(0, charIndex - 1);
                    charIndex--;
                    setTimeout(typeEffect, 50);
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    setTimeout(typeEffect, 500);
                }
            }
        }

        typeEffect();
    });
</script>
</body>
</html>
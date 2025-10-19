<?php

// movimiento.php
session_start();
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_listaR.php'; // Se asume que ya tienes esta función para obtener listas

// Obtener listas de personas, dependencias y áreas
$personas = obtener_personas();
$dependencias = obtener_dependencias();
$areas = obtener_areas();
$bienes = obtener_bienes(); // Asumo que tienes una función para obtener bienes
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Movimiento - Sistema Patrimonial</title>

    <link href="../libreria/bootstrap.min.css" rel="stylesheet">
    <link href="../libreria/select2.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../libreria/fontawesome/css/all.min.css" rel="stylesheet">

    <script src="../libreria/jquery-3.6.0.min.js"></script>
    <script src="../libreria/select2.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            --success-color: #10b981;
            --error-color: #ef4444;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b  50%, #0f1419 100%);
            min-height: 100vh;
            color: var(--text-light);
            position: relative;
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            position: relative;
        }

        .glass-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            position: relative;
            overflow: hidden;
        }

        .glass-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 20px 20px 0 0;
        }

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 0 20px 0;
        }

        .form-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Styling */
        .modern-form {
            padding: 0 50px 50px 50px;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary-red), var(--accent-red));
            border-radius: 2px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .select2-container .select2-selection--single {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1.5px solid transparent !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
            color: var(--text-light) !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            height: auto !important;
            min-height: 54px !important;
        }

        .form-control:focus, .select2-container--open .select2-selection--single {
            border-color: var(--primary-red) !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            outline: none !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Select2 Dark Theme */
        .select2-container--default .select2-dropdown {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-primary), var(--shadow-subtle) !important;
        }

        .select2-container--default .select2-results__option {
            background: transparent !important;
            color: var(--text-light) !important;
            padding: 12px 16px !important;
            border-radius: 8px !important;
            margin: 4px 8px !important;
            transition: all 0.2s ease !important;
        }

        .select2-container--default .select2-results__option--highlighted[data-selected] {
            background: var(--primary-red) !important;
            color: white !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light) !important;
            border-radius: 8px !important;
            padding: 12px !important;
        }

        .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }

        .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }

        .select2-results__options::-webkit-scrollbar-track {
            background: transparent;
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 3px;
        }

        /* Custom Checkbox */
        .custom-checkbox {
            position: relative;
            margin: 25px 0;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 1rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            margin-right: 12px;
            position: relative;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.04);
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-label .checkbox-custom {
            background: var(--primary-red);
            border-color: var(--primary-red);
        }

        .checkbox-custom::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 6px;
            height: 10px;
            border: 2px solid white;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) scale(0);
            transition: all 0.2s ease;
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-label .checkbox-custom::after {
            transform: rotate(45deg) scale(1);
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            margin: 25px 0;
        }

        .file-upload {
            display: none;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 20px;
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-gray);
            font-weight: 500;
        }

        .file-upload-label:hover {
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-light);
        }

        .file-upload-label i {
            font-size: 1.5rem;
            color: var(--accent-red);
        }

        .file-upload-label.disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Bienes Section */
        .bienes-section {
            background: rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            border: 1px solid var(--border-color);
        }

        .add-bien-btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .add-bien-btn:hover {
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            transform: translateY(-1px);
            box-shadow: var(--shadow-primary);
        }

        /* Lista de Bienes */
        .bienes-list {
            margin-top: 25px;
        }

        .bien-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .bien-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .bien-info {
            flex: 1;
            color: var(--text-light);
            font-weight: 500;
        }

        .remove-bien-btn {
            background: var(--error-color);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .remove-bien-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* Submit Button */
        .submit-btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border: none;
            border-radius: 12px;
            padding: 18px 40px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
        }

        /* Loading State */
        .loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Notification System */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            color: var(--text-light);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 9999;
            max-width: 400px;
            min-width: 300px;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-success {
            border-left: 4px solid var(--success-color);
        }

        .notification-error {
            border-left: 4px solid var(--error-color);
        }

        .notification-warning {
            border-left: 4px solid #f59e0b;
        }

        .notification-info {
            border-left: 4px solid var(--accent-red);
        }

        .notification-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .notification-close:hover {
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                margin: 20px auto;
                padding: 0 15px;
            }

            .modern-form {
                padding: 30px 25px;
            }

            .form-header h1 {
                font-size: 2rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .bien-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .remove-bien-btn {
                align-self: flex-end;
            }

            .notification {
                right: 10px;
                left: 10px;
                max-width: none;
                min-width: auto;
            }
        }

        /* Accessibility improvements */
        .form-control:focus-visible,
        .submit-btn:focus-visible,
        .add-bien-btn:focus-visible {
            outline: 2px solid var(--accent-red);
            outline-offset: 2px;
        }

        /* Fade in effect */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Select2 Dark Theme - Mejorado con mejor contraste */
        .select2-container--default .select2-selection--single {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1.5px solid transparent !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
            color: var(--text-light) !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            height: auto !important;
            min-height: 54px !important;
        }

        /* Texto seleccionado en el input principal */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-light) !important;
            line-height: 22px !important;
            padding-left: 0 !important;
        }

        /* Placeholder */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Dropdown */
        .select2-container--default .select2-dropdown {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-primary), var(--shadow-subtle) !important;
        }

        /* Opciones en el dropdown */
        .select2-container--default .select2-results__option {
            background: transparent !important;
            color: var(--text-light) !important;
            padding: 12px 16px !important;
            border-radius: 8px !important;
            margin: 4px 8px !important;
            transition: all 0.2s ease !important;
        }

        /* Opción al hacer hover */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: rgba(185, 28, 28, 0.3) !important;
            color: var(--text-light) !important;
        }

        /* Opción seleccionada (marcada) en el dropdown */
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background: rgba(185, 28, 28, 0.5) !important;
            color: white !important;
            font-weight: 600 !important;
        }

        /* Opción seleccionada Y con hover */
        .select2-container--default .select2-results__option[aria-selected="true"]:hover,
        .select2-container--default .select2-results__option--highlighted[aria-selected="true"] {
            background: var(--primary-red) !important;
            color: white !important;
        }

        /* Campo de búsqueda dentro del dropdown */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light) !important;
            border-radius: 8px !important;
            padding: 12px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--primary-red) !important;
            outline: none !important;
        }

        /* Scrollbar del dropdown */
        .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }

        .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }

        .select2-results__options::-webkit-scrollbar-track {
            background: transparent;
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 3px;
        }

        /* Estado focus del select principal */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary-red) !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1) !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }

        /* Flecha del dropdown */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 10px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-light) transparent transparent transparent !important;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent var(--text-light) transparent !important;
        }

        /* Mensaje de "no hay resultados" */
        .select2-container--default .select2-results__option--no-results {
            color: var(--text-muted) !important;
            background: rgba(255, 255, 255, 0.04) !important;
        }

        /* Opción deshabilitada */
        .select2-container--default .select2-results__option--disabled {
            color: var(--text-muted) !important;
            opacity: 0.5 !important;
        }
    </style>
</head>

<body>
<!-- Animated Background Particles -->
<div class="particles-bg" id="particles"></div>

<div class="main-container">
    <div class="glass-container">
        <div class="form-header">
            <h1><i class="fas fa-exchange-alt" style="margin-right: 15px;"></i>Registrar Movimiento</h1>
            <p>Sistema de Gestión Patrimonial</p>
        </div>

        <form id="movimientoForm" class="modern-form" enctype="multipart/form-data">
            <!-- Sección de Personas -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Responsables del Movimiento
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="transferente">
                            <i class="fas fa-user-minus" style="margin-right: 8px;"></i>
                            Transferente
                        </label>
                        <select class="form-control" name="id_transferente_movimiento" id="transferente" required>
                            <option value="">Seleccionar Transferente</option>
                            <?php foreach ($personas as $persona): ?>
                                <option value="<?php echo $persona['id_persona']; ?>">
                                    <?php echo htmlspecialchars($persona['nomyap_persona']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="receptor">
                            <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                            Receptor
                        </label>
                        <select class="form-control" name="id_receptor_movimiento" id="receptor" required>
                            <option value="">Seleccionar Receptor</option>
                            <?php foreach ($personas as $persona): ?>
                                <option value="<?php echo $persona['id_persona']; ?>">
                                    <?php echo htmlspecialchars($persona['nomyap_persona']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sección de Dependencias -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-building"></i>
                    Dependencias
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="dependencia_transferente">
                            <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>
                            Dependencia Transferente
                        </label>
                        <select class="form-control" name="id_dependencia_transferente_movimiento" id="dependencia_transferente" required>
                            <option value="">Seleccionar Dependencia</option>
                            <?php foreach ($dependencias as $dependencia): ?>
                                <option value="<?php echo $dependencia['id_dependencia']; ?>">
                                    <?php echo htmlspecialchars($dependencia['descripcion_dependencia']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dependencia_receptora">
                            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
                            Dependencia Receptora
                        </label>
                        <select class="form-control" name="id_dependencia_receptor_movimiento" id="dependencia_receptora" required>
                            <option value="">Seleccionar Dependencia</option>
                            <?php foreach ($dependencias as $dependencia): ?>
                                <option value="<?php echo $dependencia['id_dependencia']; ?>">
                                    <?php echo htmlspecialchars($dependencia['descripcion_dependencia']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sección de Áreas -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Áreas
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="area_transferente">
                            <i class="fas fa-location-arrow" style="margin-right: 8px;"></i>
                            Área Transferente
                        </label>
                        <select class="form-control" name="id_area_transferente_movimiento" id="area_transferente" required>
                            <option value="">Seleccionar Área</option>
                            <?php foreach ($areas as $area): ?>
                                <option value="<?php echo $area['id_area']; ?>">
                                    <?php echo htmlspecialchars($area['descripcion_area']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="area_receptora">
                            <i class="fas fa-map-pin" style="margin-right: 8px;"></i>
                            Área Receptora
                        </label>
                        <select class="form-control" name="id_area_receptor_movimiento" id="area_receptora" required>
                            <option value="">Seleccionar Área</option>
                            <?php foreach ($areas as $area): ?>
                                <option value="<?php echo $area['id_area']; ?>">
                                    <?php echo htmlspecialchars($area['descripcion_area']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Fecha y Estado -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Información del Movimiento
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="fecha_movimiento">
                            <i class="fas fa-calendar" style="margin-right: 8px;"></i>
                            Fecha del Movimiento
                        </label>
                        <input type="date" class="form-control" name="fecha_movimiento" id="fecha_movimiento" required>
                    </div>

                    <div class="form-group">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="enTramite" name="en_tramite" value="0">
                            <label class="checkbox-label" for="enTramite">
                                <span class="checkbox-custom"></span>
                                <i class="fas fa-clock" style="margin-right: 8px;"></i>
                                Todavía en trámite
                            </label>
                        </div>
                    </div>
                </div>

                <div class="file-upload-wrapper">
                    <label class="form-label">
                        <i class="fas fa-file-pdf" style="margin-right: 8px;"></i>
                        Archivo del Movimiento
                    </label>
                    <input type="file" class="file-upload" name="archivo_movimiento" id="archivo_movimiento" accept=".pdf" required>
                    <label for="archivo_movimiento" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Seleccionar archivo PDF</span>
                    </label>
                </div>
            </div>

            <!-- Sección de Bienes -->
            <div class="bienes-section">
                <h3 class="section-title">
                    <i class="fas fa-boxes"></i>
                    Detalle del Movimiento
                </h3>

                <div class="form-group">
                    <label class="form-label" for="bien">
                        <i class="fas fa-box" style="margin-right: 8px;"></i>
                        Seleccionar Bien
                    </label>
                    <select class="form-control" name="id_bien_detmov" id="bien">
                        <option value="">Seleccionar Bien</option>
                        <?php foreach ($bienes as $bien): ?>
                            <option value="<?php echo $bien['id_bien']; ?>">
                                <?php echo htmlspecialchars($bien['equipo_bien']); ?>
                                <?php echo htmlspecialchars($bien['marca_bien']); ?>
                                <?php echo htmlspecialchars($bien['numdeserie_bien']); ?>
                                <?php echo htmlspecialchars($bien['numcontropatri_bien']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="button" id="agregarBien" class="add-bien-btn">
                    <i class="fas fa-plus"></i>
                    Agregar Bien
                </button>

                <div class="bienes-list">
                    <ul id="listaBienes"></ul>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                <span>Registrar Movimiento</span>
            </button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize Select2 with enhanced styling
        const select2Config = {
            allowClear: true,
            width: '100%',
            dropdownAutoWidth: true,
            minimumResultsForSearch: 5
        };

        $('#transferente').select2({
            ...select2Config,
            placeholder: "Seleccionar Transferente"
        });

        $('#receptor').select2({
            ...select2Config,
            placeholder: "Seleccionar Receptor"
        });

        $('#dependencia_transferente').select2({
            ...select2Config,
            placeholder: "Seleccionar Dependencia Transferente"
        });

        $('#dependencia_receptora').select2({
            ...select2Config,
            placeholder: "Seleccionar Dependencia Receptora"
        });

        $('#area_transferente').select2({
            ...select2Config,
            placeholder: "Seleccionar Área Transferente"
        });

        $('#area_receptora').select2({
            ...select2Config,
            placeholder: "Seleccionar Área Receptora"
        });

        $('#bien').select2({
            ...select2Config,
            placeholder: "Seleccionar Bien"
        });

        // Enhanced file upload handling
        $('#archivo_movimiento').change(function() {
            const fileName = $(this)[0].files[0]?.name;
            if (fileName) {
                $(this).next('.file-upload-label').html(`
                        <i class="fas fa-check-circle"></i>
                        <span>${fileName}</span>
                    `);
            }
        });

        // Checkbox functionality with enhanced UX
        $('#enTramite').change(function() {
            const isChecked = $(this).is(':checked');
            const fileInput = $('#archivo_movimiento');
            const fileLabel = $('.file-upload-label');

            if (isChecked) {
                fileInput.prop('disabled', true).prop('required', false);
                fileLabel.addClass('disabled').html(`
                        <i class="fas fa-info-circle"></i>
                        <span>Archivo no requerido (en trámite)</span>
                    `);
            } else {
                fileInput.prop('disabled', false).prop('required', true);
                fileLabel.removeClass('disabled').html(`
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Seleccionar archivo PDF</span>
                    `);
            }
        });

        // Enhanced person selection logic
        $('#transferente, #receptor').on('select2:select select2:unselect', function(e) {
            const transferenteSeleccionado = $('#transferente').val();
            const receptorSeleccionado = $('#receptor').val();

            // Reset all options
            $('#receptor option, #transferente option').each(function() {
                $(this).prop('disabled', false);
            });

            // Disable selected options in opposite select
            if (transferenteSeleccionado) {
                $('#receptor option[value="' + transferenteSeleccionado + '"]').prop('disabled', true);
            }
            if (receptorSeleccionado) {
                $('#transferente option[value="' + receptorSeleccionado + '"]').prop('disabled', true);
            }

            // Trigger select2 update
            $('#transferente, #receptor').trigger('change.select2');
        });

        // Set max date to today
        const today = new Date().toISOString().split('T')[0];
        $('#fecha_movimiento').attr('max', today);

        // Enhanced bien management
        $('#agregarBien').click(function() {
            const bienSeleccionado = $('#bien').val();
            const bienTexto = $("#bien option:selected").text().trim();

            if (!bienSeleccionado) {
                showNotification('Debes seleccionar un bien para agregar.', 'error');
                return;
            }

            // Check for duplicates
            let existe = false;
            $('#listaBienes .bien-item').each(function() {
                if ($(this).data('id') == bienSeleccionado) {
                    existe = true;
                    return false;
                }
            });

            if (existe) {
                showNotification('El bien ya ha sido agregado.', 'warning');
                return;
            }

            // Add bien with animation
            const bienHtml = `
                    <li class="bien-item" data-id="${bienSeleccionado}">
                        <div class="bien-info">
                            <i class="fas fa-box" style="margin-right: 10px; color: var(--accent-color);"></i>
                            ${bienTexto}
                        </div>
                        <button type="button" class="remove-bien-btn eliminarBien">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                    </li>
                `;

            $('#listaBienes').append(bienHtml);
            $('#bien').val('').trigger('change');

            showNotification('Bien agregado correctamente', 'success');
        });

        // Remove bien with animation
        $(document).on('click', '.eliminarBien', function() {
            const $item = $(this).closest('.bien-item');
            $item.css({
                'animation': 'slideOutRight 0.3s ease',
                'transform': 'translateX(100%)',
                'opacity': '0'
            });

            setTimeout(() => {
                $item.remove();
            }, 300);
        });

        // Enhanced form submission
        $('#movimientoForm').on('submit', function(e) {
            e.preventDefault();

            // Validate bienes
            if ($('#listaBienes .bien-item').length === 0) {
                showNotification("Debes agregar al menos un bien antes de registrar el movimiento.", 'error');
                return;
            }

            const submitBtn = $('.submit-btn');
            const originalText = submitBtn.html();

            // Loading state
            submitBtn.addClass('loading').html(`
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Procesando...</span>
                `);

            const formData = new FormData(this);

            // Add selected bienes
            $('#listaBienes .bien-item').each(function() {
                formData.append('bienes[]', $(this).data('id'));
            });

            // Add tramite status
            formData.append('en_tramite', $('#enTramite').is(':checked') ? '0' : '1');

            $.ajax({
                url: '../LN/ln_movimiento.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            showNotification(res.message, 'success');

                            // Reset form with animation
                            setTimeout(() => {
                                resetForm();
                            }, 1500);
                        } else {
                            showNotification("Error: " + res.message, 'error');
                        }
                    } catch (e) {
                        showNotification("Error al procesar la respuesta del servidor", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    showNotification("Error de conexión. Intente nuevamente.", 'error');
                },
                complete: function() {
                    // Restore button
                    submitBtn.removeClass('loading').html(originalText);
                }
            });
        });

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = $(`
                    <div class="notification notification-${type}">
                        <div class="notification-content">
                            <i class="fas ${getNotificationIcon(type)}"></i>
                            <span>${message}</span>
                        </div>
                        <button class="notification-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

            $('body').append(notification);

            setTimeout(() => {
                notification.addClass('show');
            }, 100);

            // Auto dismiss
            setTimeout(() => {
                dismissNotification(notification);
            }, 5000);

            // Manual dismiss
            notification.find('.notification-close').click(() => {
                dismissNotification(notification);
            });
        }

        function getNotificationIcon(type) {
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            return icons[type] || icons.info;
        }

        function dismissNotification($notification) {
            $notification.removeClass('show');
            setTimeout(() => {
                $notification.remove();
            }, 300);
        }

        // Reset form function
        function resetForm() {
            $('#movimientoForm')[0].reset();
            $('#listaBienes').empty();
            $('#transferente, #receptor, #dependencia_transferente, #dependencia_receptora, #area_transferente, #area_receptora, #bien')
                .val(null).trigger('change');

            $('.file-upload-label').html(`
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Seleccionar archivo PDF</span>
                `);
        }

        // Add smooth scrolling for better UX
        $('a[href^="#"]').click(function(e) {
            e.preventDefault();
            const target = $($(this).attr('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
            }
        });
    });

    // Add notification styles
    const notificationStyles = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 16px 20px;
                color: var(--text-primary);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                transform: translateX(100%);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 9999;
                max-width: 400px;
                min-width: 300px;
            }

            .notification.show {
                transform: translateX(0);
                opacity: 1;
            }

            .notification-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .notification-success {
                border-left: 4px solid var(--success-color);
            }

            .notification-error {
                border-left: 4px solid var(--error-color);
            }

            .notification-warning {
                border-left: 4px solid #FFA502;
            }

            .notification-info {
                border-left: 4px solid var(--accent-color);
            }

            .notification-close {
                position: absolute;
                top: 8px;
                right: 8px;
                background: none;
                border: none;
                color: var(--text-muted);
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.2s ease;
            }

            .notification-close:hover {
                color: var(--text-primary);
                background: var(--light-dark);
            }

            @keyframes slideOutRight {
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            .disabled {
                opacity: 0.6;
                pointer-events: none;
            }

            /* Enhanced focus states */
            .form-control:focus,
            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: var(--accent-color) !important;
                box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.2) !important;
            }

            /* Loading overlay */
            .form-loading {
                position: relative;
                pointer-events: none;
            }

            .form-loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(2px);
                border-radius: 24px;
                z-index: 999;
            }
        `;

    // Inject notification styles
    const styleSheet = document.createElement('style');
    styleSheet.textContent = notificationStyles;
    document.head.appendChild(styleSheet);

    // Add intersection observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe form sections
    document.querySelectorAll('.form-section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(section);
    });
</script>
</body>
</html>
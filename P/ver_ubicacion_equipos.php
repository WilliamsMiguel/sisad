<?php
// Obtener la lista de equipos desde la BD
session_start();
require_once '../cache_control.php'; // Solo esto
// Incluir archivo de acceso a datos
include_once '../AD/ad.php';

// Para la carga inicial, obtener equipos del piso 1
$pisoInicial = 1;
$result = obtenerEquiposConUbicacionPorPiso($pisoInicial);

// Configuración de pisos
$configuracionPisos = [
    1 => [
        'nombre' => 'Piso 1',
        'imagen' => 'img/PISO1.png',
        'descripcion' => 'Planta Baja'
    ],
    2 => [
        'nombre' => 'Piso 2',
        'imagen' => 'img/PISO2.png',
        'descripcion' => 'Segundo Piso'
    ],
    3 => [
        'nombre' => 'Piso 3',
        'imagen' => 'img/PISO3.png',
        'descripcion' => 'Tercer Piso'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de seguimiento de equipos informáticos</title>

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
        :root {
            --primary-color: #2563eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            margin: 0;
            padding: 0;
        }

        .main-container {
            padding: 20px;
        }

        /* Header */
        .modern-header {
            background: #343a40;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-title {
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Selector de Pisos */
        .floor-selector {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .floor-btn {
            padding: 8px 16px;
            border: 2px solid #6c757d;
            background: transparent;
            color: #6c757d;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .floor-btn:hover {
            border-color: #007bff;
            color: #007bff;
            text-decoration: none;
        }

        .floor-btn.active {
            border-color: #28a745;
            background: #28a745;
            color: white;
        }

        .floor-btn.loading {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .floor-info {
            background: #495057;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Stats Counter */
        .equipment-stats {
            background: #17a2b8;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            border-radius: 8px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #ffffff30;
            border-top: 4px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Controles */
        .controls-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .search-label {
            font-weight: 600;
            color: white;
        }

        .search-input {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            max-width: 300px;
        }

        .mode-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-toggle {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-toggle.edit-mode {
            background: #28a745;
            color: white;
        }

        .btn-toggle.view-mode {
            background: #6c757d;
            color: white;
        }

        .btn-save {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            position: relative;
        }

        .btn-save:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #ffffff40;
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 5px;
        }

        /* Mapa */
        .mapa-container-wrapper {
            position: relative;
        }

        .mapa {
            position: relative;
            display: inline-block;
            border: 2px solid #333;
            border-radius: 8px;
            overflow: hidden;
            max-width: 100%;
        }

        .plano {
            max-width: 100%;
            display: block;
            transition: opacity 0.3s ease;
        }

        .marcador {
            position: absolute;
            font-size: 24px;
            cursor: pointer;
            transform: translate(-50%, -50%);
            transition: transform 0.2s ease-in-out;
            z-index: 1000;
            user-select: none;
        }

        .marcador:hover {
            transform: translate(-50%, -50%) scale(1.3);
        }

        .marcador.conectado {
            color: #28a745;
        }

        .marcador.desconectado {
            color: #dc3545;
        }

        .marcador.dragging {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0.8;
            cursor: move;
        }

        .marcador.edit-mode {
            border: 2px dashed #ffc107;
            border-radius: 50%;
            padding: 2px;
        }

        .marcador.modified {
            border: 2px solid #17a2b8;
            border-radius: 50%;
            padding: 2px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(23, 162, 184, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(23, 162, 184, 0); }
            100% { box-shadow: 0 0 0 0 rgba(23, 162, 184, 0); }
        }

        /* Empty state */
        .empty-floor {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }

        .empty-floor i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        /* Tooltip personalizado */
        .custom-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.95);
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 12px;
            pointer-events: auto; /* CAMBIADO: permitir interacción con el tooltip */
            z-index: 2000;
            max-width: 280px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 1.4;
            word-wrap: break-word;

            /* Animación suave */
            opacity: 0;
            transform: translateY(-5px);
            transition: all 0.2s ease-out;
        }

        /* Cuando el tooltip está visible */
        .custom-tooltip[style*="display: block"] {
            opacity: 1;
            transform: translateY(0);
        }

        /* Estilo para los labels del tooltip */
        .custom-tooltip strong {
            color: #4fc3f7;
            font-weight: 600;
        }

        /* Separación entre líneas */
        .custom-tooltip br {
            line-height: 1.6;
        }

        /* Coordenadas display */
        .coordinates-display {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 6px;
            font-family: monospace;
            display: none;
        }

        /* Alert styles */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 3000;
        }

        .custom-alert {
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 10px;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Counter */
        .changes-counter {
            background: #17a2b8;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-tooltip {
                max-width: 250px;
                font-size: 11px;
                padding: 10px 14px;
            }
            .modern-header {
                flex-direction: column;
                align-items: stretch;
            }

            .floor-selector {
                justify-content: center;
            }

            .controls-section {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                margin-bottom: 10px;
            }
        }

        .icono-equipo {
            width: 28px;
            height: 28px;
            pointer-events: none; /* evita interferencia con drag/click */
        }

        .marcador.highlight {
            transform: translate(-50%, -50%) scale(1.3);
            filter: drop-shadow(0 0 8px rgba(255, 255, 0, 0.8));
            z-index: 1001;
            transition: all 0.3s ease;
        }




        .marcador.delete-mode {
            cursor: crosshair;
            border: 2px dashed #dc3545;
            border-radius: 50%;
            padding: 2px;
        }

        .marcador.delete-mode:hover {
            background: rgba(220, 53, 69, 0.2);
            transform: translate(-50%, -50%) scale(1.2);
        }

        .btn-toggle.delete-mode {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-toggle.delete-mode:hover {
            background: #c82333;
            border-color: #bd2130;
        }

        /* Modal de confirmación personalizado */
        .confirm-delete-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 3000;
        }

        .confirm-delete-content {
            background: white;
            border-radius: 8px;
            padding: 25px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .confirm-delete-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #dc3545;
        }

        .confirm-delete-header i {
            font-size: 24px;
            margin-right: 10px;
        }

        .confirm-delete-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-confirm-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-confirm-delete:hover {
            background: #c82333;
        }

        .btn-cancel-delete {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-cancel-delete:hover {
            background: #545b62;
        }

        .equipment-details {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 0.9rem;
        }

        /* Agregar estos estilos al <style> existente en ver_ubicacion_equipos.php */

        /* Indicadores de validación */
        .validation-indicator {
            font-size: 14px;
            pointer-events: none;
            z-index: 20;
        }

        .validation-indicator .fa-spinner {
            animation: spin 1s linear infinite;
        }

        .form-control:focus + .validation-indicator {
            right: 8px;
        }

        /* Estados de validación para campos */
        .form-control.has-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .form-control.has-success {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .form-control.has-warning {
            border-color: #ffc107 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
        }

        /* Tooltips para indicadores de validación */
        .validation-indicator {
            position: relative;
        }

        .validation-indicator:hover::before {
            content: attr(title);
            position: absolute;
            bottom: 150%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            z-index: 2000;
            opacity: 0;
            animation: fadeInTooltip 0.3s ease forwards;
        }

        .validation-indicator:hover::after {
            content: '';
            position: absolute;
            bottom: 142%;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            opacity: 0;
            animation: fadeInTooltip 0.3s ease forwards;
        }

        @keyframes fadeInTooltip {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(5px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        /* Mejorar mensajes de error en modales */
        .modal-body .alert {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .modal-body .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .modal-body .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .modal-body .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        /* Loading spinner para botones */
        .btn .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #ffffff40;
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* Mejorar apariencia de campos requeridos */
        .form-label .text-danger {
            font-weight: 600;
        }

        /* Estados hover para indicadores */
        .validation-indicator:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Responsive para validaciones en móviles */
        @media (max-width: 768px) {
            .validation-indicator {
                right: 5px !important;
                font-size: 12px;
            }

            .validation-indicator:hover::before {
                font-size: 10px;
                padding: 4px 8px;
                bottom: 120%;
                max-width: 200px;
                white-space: normal;
            }
        }

        /* Animación para campos con errores */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        .form-control.shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Indicador de campo obligatorio mejorado */
        .required-field::after {
            content: ' *';
            color: #dc3545;
            font-weight: bold;
        }

        /* Mejoras para el formulario */
        .modal-body .row.g-3 .col-md-6,
        .modal-body .row.g-3 .col-md-4 {
            position: relative;
        }

        /* Estados de carga para selects */
        .form-select:disabled {
            background-color: #e9ecef;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .form-select option:disabled {
            color: #6c757d;
            background-color: #f8f9fa;
        }

        /* Mejorar visibility del texto de ayuda */
        .form-text {
            font-size: 0.875em;
            color: #6c757d;
            margin-top: 5px;
        }

        .form-text.error {
            color: #dc3545;
            font-weight: 500;
        }

        .form-text.success {
            color: #28a745;
            font-weight: 500;
        }








        /* ===== HALO + ANIMACIONES ===== */
        .marcador {
            position: absolute;
            transform: translate(-50%, -50%);
            display: inline-block;
            cursor: pointer;
        }
        .marcador .marcador-shadow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 72px;   /* ajusta según tu icono */
            height: 72px;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.95;
            transition: all 0.15s linear;
        }
        .marcador .icono-equipo {
            position: relative;
            z-index: 2;
            width: 40px;
            height: 40px;
        }

        /* Conectado: pulso suave verde */
        .marcador.conectado .marcador-shadow {
            background: rgba(40,167,69,0.14);
            box-shadow: 0 0 14px rgba(40,167,69,0.35), inset 0 0 8px rgba(40,167,69,0.12);
            animation: haloPulse 2.4s infinite linear;
        }

        /* Desconectado: rojo PARPADEANTE (rápido para 2s polling) */
        .marcador.desconectado .marcador-shadow {
            background: rgba(220,53,69,0.15);
            box-shadow: 0 0 18px rgba(220,53,69,0.65);
            animation: haloBlinkFast 0.8s infinite steps(2);
        }

        /* Animaciones */
        @keyframes haloPulse {
            0% { transform: translate(-50%,-50%) scale(0.94); opacity: 0.7; }
            50% { transform: translate(-50%,-50%) scale(1.06); opacity: 1; }
            100% { transform: translate(-50%,-50%) scale(0.94); opacity: 0.7; }
        }
        @keyframes haloBlinkFast {
            0% { opacity: 1; transform: translate(-50%,-50%) scale(1.0); }
            50% { opacity: 0.15; transform: translate(-50%,-50%) scale(0.95); }
            100% { opacity: 1; transform: translate(-50%,-50%) scale(1.0); }
        }

        /* Opcional: si quieres que icono esté gris cuando desconectado */
        .marcador.desconectado .icono-equipo {
            filter: grayscale(70%);
        }

        .supply-alert {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            animation: pulse-alert 2s infinite;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
            z-index: 10;
        }

        @keyframes pulse-alert {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .marcador.conectado .supply-alert {
            animation: pulse-alert 2s infinite;
        }

        /* Estilos para campos de suministros en modal */
        #nivel_toner.bg-danger,
        #nivel_kit_mantenimiento.bg-danger,
        #nivel_unidad_imagen.bg-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        #nivel_toner.bg-warning,
        #nivel_kit_mantenimiento.bg-warning,
        #nivel_unidad_imagen.bg-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }

        #nivel_toner.bg-success,
        #nivel_kit_mantenimiento.bg-success,
        #nivel_unidad_imagen.bg-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        #nivel_toner.bg-secondary,
        #nivel_kit_mantenimiento.bg-secondary,
        #nivel_unidad_imagen.bg-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }

        #seccion-suministros {
            margin-top: 15px;
        }

        #seccion-suministros h6 {
            margin-bottom: 10px;
        }

        /* Estilos para las cards de registros */
        .registro-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background: #585858;
            transition: all 0.3s ease;
        }

        .registro-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .registro-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        .registro-ip {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
        }

        .registro-piso-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .piso-1 {
            background: #dcfce7;
            color: #166534;
        }

        .piso-2 {
            background: #dbeafe;
            color: #1e40af;
        }

        .piso-3 {
            background: #fef3c7;
            color: #92400e;
        }

        .registro-info {
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .registro-info strong {
            color: #ffffff;
            display: inline-block;
            width: 140px;
        }

        .suministros-section {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }

        .nivel-suministro {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 5px;
        }

        .nivel-critico {
            background: #fee2e2;
            color: #991b1b;
        }

        .nivel-bajo {
            background: #fef3c7;
            color: #92400e;
        }

        .nivel-medio {
            background: #dbeafe;
            color: #1e40af;
        }

        .nivel-alto {
            background: #dcfce7;
            color: #166534;
        }

        .nivel-na {
            background: #f3f4f6;
            color: #6b7280;
        }

        .ultima-lectura {
            font-size: 0.8rem;
            color: #ffffff;
            margin-top: 5px;
        }

    </style>
</head>
<body>

<div class="main-container">
    <!-- Header with Floor Navigation -->
    <div class="modern-header">
        <div>
            <h1 class="header-title">
                <i class="fas fa-network-wired"></i>
                <span id="headerTitle">Seguimiento de Equipos - Piso 1</span>
            </h1>
            <div class="floor-info">
                <i class="fas fa-building"></i>
                <span id="floorDescription">Planta Baja</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap">
            <!-- Stats -->
            <div class="equipment-stats">
                <i class="fas fa-desktop"></i>
                <span id="equipmentCount">0</span> equipos
            </div>

            <!-- Floor Selector -->
            <div class="floor-selector">
                <?php foreach ($configuracionPisos as $numPiso => $configPiso): ?>
                    <button class="floor-btn <?php echo $numPiso == $pisoInicial ? 'active' : ''; ?>"
                            data-piso="<?php echo $numPiso; ?>"
                            data-nombre="<?php echo $configPiso['nombre']; ?>"
                            data-imagen="<?php echo $configPiso['imagen']; ?>"
                            data-descripcion="<?php echo $configPiso['descripcion']; ?>">
                        <i class="fas fa-layer-group"></i>
                        <?php echo $configPiso['nombre']; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Controles -->
    <div class="controls-section">
        <div class="search-container">
            <label for="buscarReceptor" class="search-label">
                <i class="fas fa-search"></i> Buscar
            </label>
            <input type="text" id="buscarReceptor" class="search-input"
                   placeholder="Equipo, marca, modelo, serie, IP, persona, área...">
        </div>

        <div class="mode-controls">
            <button id="btnAnadirEquipo" class="btn-toggle edit-mode">
                <i class="fas fa-plus"></i> Añadir Equipo
            </button>
            <!-- NUEVO BOTÓN -->
            <button id="btnEliminarEquipo" class="btn-toggle view-mode" style="background: #dc3545;">
                <i class="fas fa-trash"></i> Eliminar Equipo
            </button>
            <button id="toggleMode" class="btn-toggle view-mode">
                <i class="fas fa-edit"></i> Modo Edición
            </button>
            <!-- AGREGAR ESTE BOTÓN EN EL div.mode-controls, línea ~574 -->
            <button id="btnVerRegistros" class="btn-toggle view-mode" style="background: #17a2b8;">
                <i class="fas fa-list"></i> Ver Registros
            </button>
            <button id="btnActualizarSNMP" class="btn-toggle view-mode" style="background: #f59e0b;">
                <i class="fas fa-sync"></i> Actualizar Suministros
            </button>
            <button id="saveCoordinates" class="btn-save" style="display: none; position: relative;">
                <i class="fas fa-save"></i> Guardar en BD
                <span id="changesCounter" class="changes-counter" style="display: none;">0</span>
            </button>
            <button id="resetCoordinates" class="btn-toggle view-mode" style="display: none;">
                <i class="fas fa-undo"></i> Cancelar
            </button>
        </div>
    </div>

    <!-- Plano -->
    <div class="table-container">
        <div class="mapa-container-wrapper">
            <div class="mapa" id="mapaContainer">
                <img src="<?php echo $configuracionPisos[$pisoInicial]['imagen']; ?>"
                     class="plano"
                     alt="Piso 1"
                     id="planoImg">
            </div>
            <div class="loading-overlay" id="loadingOverlay" style="display: none;">
                <div class="loading-spinner"></div>
            </div>
        </div>

        <div class="empty-floor" id="emptyFloor" style="display: none;">
            <i class="fas fa-inbox"></i>
            <h3 id="emptyTitle">No hay equipos en este piso</h3>
            <p>No se encontraron equipos registrados para este piso.</p>
            <small>Selecciona otro piso o registra equipos para este nivel.</small>
        </div>
    </div>
</div>

<!-- Contenedor de alertas -->
<div class="alert-container" id="alertContainer"></div>

<!-- Display de coordenadas -->
<div class="coordinates-display" id="coordinatesDisplay"></div>

<!-- Tooltip personalizado -->
<div class="custom-tooltip" id="customTooltip" style="display: none;"></div>

<!-- Modal Editar Equipo -->
<div class="modal fade" id="modalEditarEquipo" tabindex="-1" aria-labelledby="modalEditarEquipoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarEquipoLabel"><i class="fas fa-edit"></i> Editar Ubicación de Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarEquipo">
                <div class="modal-body">
                    <input type="hidden" id="id_ubicacion_equipos" name="id_ubicacion_equipos">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">IP</label>
                            <input type="text" class="form-control" name="ip_ubicacion_equipos" id="ip_ubicacion_equipos">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAC</label>
                            <input type="text" class="form-control" name="mac_ubicacion_equipos" id="mac_ubicacion_equipos">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Categoría</label>
                            <select class="form-select" name="id_categoria" id="id_categoria">
                                <option value="">Seleccione una Categoría</option>
                                <?php
                                include_once '../AD/ad.php';
                                $categorias = obtenerCategorias();
                                foreach ($categorias as $cat) {
                                    echo "<option value='{$cat['id_nombre_bien']}'>{$cat['des_nombre_bien']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bien</label>
                            <select class="form-select" name="id_bien" id="id_bien">
                                <option value="">Seleccione un Bien</option>
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Persona</label>
                            <select class="form-select" name="id_persona" id="id_persona">
                                <option value="">Seleccione una Persona</option>
                                <?php
                                $personas = obtenerPersonas();
                                foreach ($personas as $persona) {
                                    echo "<option value='{$persona['id_persona']}'>{$persona['nomyap_persona']} ({$persona['dni_persona']})</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Área</label>
                            <select class="form-select" name="id_area" id="id_area">
                                <option value="">Seleccione un Área</option>
                                <?php
                                $areas = obtenerAreas();
                                foreach ($areas as $area) {
                                    echo "<option value='{$area['id_area']}'>{$area['descripcion_area']} - {$area['organo']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado Conexión</label>
                            <select class="form-select" name="estado_conexion" id="estado_conexion">
                                <option value="1">Conectado</option>
                                <option value="0">Desconectado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Última Detección</label>
                            <input type="datetime-local" class="form-control" name="ultima_deteccion" id="ultima_deteccion">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Piso</label>
                            <select class="form-select" name="piso" id="piso">
                                <option value="">Seleccione un piso</option>
                                <option value="1">Piso 1</option>
                                <option value="2">Piso 2</option>
                                <option value="3">Piso 3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posición X</label>
                            <input type="number" class="form-control" name="pos_x" id="pos_x">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posición Y</label>
                            <input type="number" class="form-control" name="pos_y" id="pos_y">
                        </div>

                        <div class="col-md-4" id="campo-toner-editar" style="display: none;">
                            <label class="form-label">Nivel Toner (%)</label>
                            <input type="number" class="form-control" name="nivel_toner" id="nivel_toner_editar" min="0" max="100" readonly>
                        </div>

                        <div class="col-md-4" id="campo-kit-editar" style="display: none;">
                            <label class="form-label">Nivel Kit Mantenimiento (%)</label>
                            <input type="number" class="form-control" name="nivel_kit_mantenimiento" id="nivel_kit_mantenimiento_editar" min="0" max="100" readonly>
                        </div>

                        <div class="col-md-4" id="campo-unidad-editar" style="display: none;">
                            <label class="form-label">Nivel Unidad Imagen (%)</label>
                            <input type="number" class="form-control" name="nivel_unidad_imagen" id="nivel_unidad_imagen_editar" min="0" max="100" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Añadir Equipo -->
<div class="modal fade" id="modalAnadirEquipo" tabindex="-1" aria-labelledby="modalAnadirEquipoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAnadirEquipoLabel">
                    <i class="fas fa-plus"></i> Añadir Nuevo Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAnadirEquipo">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span> IP</label>
                            <input type="text" class="form-control" name="ip_ubicacion_equipos" id="ip_nuevo" required>
                            <div class="form-text">Ejemplo: 192.168.1.100</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span> MAC</label>
                            <input type="text" class="form-control" name="mac_ubicacion_equipos" id="mac_nuevo" required>
                            <div class="form-text">Ejemplo: AA:BB:CC:DD:EE:FF</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span> Categoría</label>
                            <select class="form-select" name="id_categoria" id="id_categoria_nuevo" required>
                                <option value="">Seleccione una Categoría</option>
                                <?php
                                include_once '../AD/ad.php';
                                $categorias = obtenerCategorias();
                                foreach ($categorias as $cat) {
                                    echo "<option value='{$cat['id_nombre_bien']}'>{$cat['des_nombre_bien']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bien</label>
                            <select class="form-select" name="id_bien" id="id_bien_nuevo">
                                <option value="">Seleccione un Bien</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Persona</label>
                            <select class="form-select" name="id_persona" id="id_persona_nuevo">
                                <option value="">Seleccione una Persona</option>
                                <?php
                                $personas = obtenerPersonas();
                                foreach ($personas as $persona) {
                                    echo "<option value='{$persona['id_persona']}'>{$persona['nomyap_persona']} ({$persona['dni_persona']})</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Área</label>
                            <select class="form-select" name="id_area" id="id_area_nuevo">
                                <option value="">Seleccione un Área</option>
                                <?php
                                $areas = obtenerAreas();
                                foreach ($areas as $area) {
                                    echo "<option value='{$area['id_area']}'>{$area['descripcion_area']} - {$area['organo']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado Conexión</label>
                            <select class="form-select" name="estado_conexion" id="estado_conexion_nuevo">
                                <option value="1">Conectado</option>
                                <option value="0">Desconectado</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Última Detección</label>
                            <input type="datetime-local" class="form-control" name="ultima_deteccion" id="ultima_deteccion_nuevo">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span> Piso</label>
                            <select class="form-select" name="piso" id="piso_nuevo" required>
                                <option value="">Seleccione un piso</option>
                                <option value="1">Piso 1</option>
                                <option value="2">Piso 2</option>
                                <option value="3">Piso 3</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Posición X</label>
                            <input type="number" class="form-control" name="pos_x" id="pos_x_nuevo" value="100" min="0" max="5000">
                            <div class="form-text">0 - 5000</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Posición Y</label>
                            <input type="number" class="form-control" name="pos_y" id="pos_y_nuevo" value="100" min="0" max="5000">
                            <div class="form-text">0 - 5000</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="confirmDeleteModal" class="confirm-delete-modal" style="display: none;">
    <div class="confirm-delete-content">
        <div class="confirm-delete-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h4>Confirmar Eliminación</h4>
        </div>

        <p>¿Estás seguro de que deseas eliminar este equipo del sistema?</p>

        <div class="equipment-details" id="deleteEquipmentDetails">
            <!-- Se llena dinámicamente -->
        </div>

        <div class="alert alert-warning">
            <small><i class="fas fa-info-circle"></i> Esta acción no se puede deshacer.</small>
        </div>

        <div class="confirm-delete-buttons">
            <button id="cancelDeleteBtn" class="btn-cancel-delete">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button id="confirmDeleteBtn" class="btn-confirm-delete">
                <i class="fas fa-trash"></i> Eliminar Equipo
            </button>
        </div>
    </div>
</div>

<!-- Modal Ver Registros -->
<div class="modal fade" id="modalVerRegistros" tabindex="-1" aria-labelledby="modalVerRegistrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalVerRegistrosLabel">
                    <i class="fas fa-list"></i> Registros de Equipos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Filtros -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="filtroRegistros" class="form-control" placeholder="Buscar por IP, categoría, persona...">
                    </div>
                    <div class="col-md-3">
                        <select id="filtroPisoRegistros" class="form-select">
                            <option value="">Todos los pisos</option>
                            <option value="1">Piso 1</option>
                            <option value="2">Piso 2</option>
                            <option value="3">Piso 3</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button id="btnRefrescarRegistros" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync"></i> Refrescar
                        </button>
                    </div>
                    <div class="col-md-2 text-end">
                        <span id="totalRegistros" class="badge bg-secondary">0 registros</span>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingRegistros" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando registros...</p>
                </div>

                <!-- Contenedor de Cards -->
                <div id="registrosContainer" class="row g-3" style="max-height: 600px; overflow-y: auto;">
                    <!-- Los cards se generarán dinámicamente aquí -->
                </div>

                <!-- Mensaje vacío -->
                <div id="noRegistros" class="text-center py-5" style="display: none;">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No se encontraron registros</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables para control de validación
    let validationTimeout = null;
    let isValidating = false;
    const CONFIG = {
        AJAX_URL_SAVE: '../LN/ln_guardar_coordenadas.php',
        AJAX_URL_LOAD: '../LN/ajax_cargar_piso.php',
        RELOAD_DELAY: 1500,
        TOOLTIP_OFFSET: { x: 10, y: 10 },
        ALERT_DURATION: 5000,
        CURRENT_FLOOR: <?php echo $pisoInicial; ?>,
        // AGREGADO: Límites para validación
        MAX_COORDINATE: 5000,
        MIN_COORDINATE: 0
    };

    // Configuración de pisos desde PHP
    const FLOOR_CONFIG = <?php echo json_encode($configuracionPisos); ?>;

    // Datos iniciales de equipos desde PHP
    let equiposData = [
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            $equipos_array = [];
            while($row = mysqli_fetch_assoc($result)) {
                $equipos_array[] = json_encode($row);
            }
            echo implode(',', $equipos_array);
        }
        ?>
    ];

    console.log(`Sistema inicializado: Piso ${CONFIG.CURRENT_FLOOR} con ${equiposData.length} equipos`);

    const AppState = {
        editMode: false,
        deleteMode: false, // NUEVO
        isDragging: false,
        currentDragElement: null,
        dragOffset: { x: 0, y: 0 },
        originalPositions: {},
        modifiedEquipments: new Set(),
        isLoadingFloor: false,
        equipmentToDelete: null // NUEVO
    };

    $(document).ready(function() {
        initializeMap();
        bindEvents();
        updateEquipmentCount();
        bindFloorNavigation();
    });

    /**
     * Navegación entre pisos
     */
    function bindFloorNavigation() {
        $('.floor-btn').on('click', function(e) {
            e.preventDefault();

            if (AppState.isLoadingFloor || $(this).hasClass('active')) {
                return;
            }

            const piso = $(this).data('piso');
            const nombre = $(this).data('nombre');
            const imagen = $(this).data('imagen');
            const descripcion = $(this).data('descripcion');

            cambiarPiso(piso, nombre, imagen, descripcion);
        });
    }

    /**
     * Cambia a otro piso dinámicamente
     */
    function cambiarPiso(piso, nombre, imagen, descripcion) {
        // Detener polling temporalmente durante el cambio
        pollScanStop();
        // Verificar si hay cambios pendientes
        if (AppState.modifiedEquipments.size > 0) {
            if (!confirm('Tienes cambios sin guardar. ¿Deseas continuar y perder los cambios?')) {
                return;
            }
        }

        AppState.isLoadingFloor = true;

        // Actualizar UI de carga
        mostrarCargandoPiso(piso);

        // MEJORADO: Timeout para la petición AJAX
        const ajaxTimeout = setTimeout(() => {
            showAlert('La carga del piso está tomando más tiempo del esperado...', 'warning');
        }, 5000);

        // Cargar datos del nuevo piso
        $.ajax({
            url: CONFIG.AJAX_URL_LOAD,
            method: 'POST',
            data: { piso: piso },
            dataType: 'json',
            timeout: 10000, // AGREGADO: Timeout de 10 segundos
            success: function(response) {
                clearTimeout(ajaxTimeout); // AGREGADO: Limpiar timeout

                if (response && response.success) {
                    // Validar que equipos sea array
                    if (!Array.isArray(response.equipos)) {
                        throw new Error('Respuesta inválida: equipos no es un array');
                    }

                    // Actualizar datos
                    equiposData = response.equipos;
                    CONFIG.CURRENT_FLOOR = piso;

                    // Actualizar UI
                    actualizarInterfazPiso(piso, nombre, imagen, descripcion);

                    // Reinicializar mapa
                    reinicializarMapa();

                    showAlert(`Cargado ${nombre} con ${equiposData.length} equipos`, 'success');
                } else {
                    throw new Error(response ? response.message : 'Respuesta inválida del servidor');
                }
            },
            error: function(xhr, status, error) {
                clearTimeout(ajaxTimeout); // AGREGADO: Limpiar timeout
                console.error('Error cargando piso:', { xhr: xhr, status: status, error: error });

                let errorMessage = 'Error de conexión al cargar el piso';
                if (status === 'timeout') {
                    errorMessage = 'La carga del piso ha expirado. Intenta nuevamente.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                ocultarCargandoPiso();
                AppState.isLoadingFloor = false;
            }
        });
    }

    /**
     * Muestra indicador de carga
     */
    function mostrarCargandoPiso(piso) {
        $('.floor-btn').addClass('loading').prop('disabled', true);
        $('#loadingOverlay').show();
        $('#buscarReceptor').prop('disabled', true);
    }

    /**
     * Oculta indicador de carga
     */
    function ocultarCargandoPiso() {
        $('.floor-btn').removeClass('loading').prop('disabled', false);
        $('#loadingOverlay').hide();
        $('#buscarReceptor').prop('disabled', false);
    }

    /**
     * Actualiza la interfaz para el nuevo piso
     */
    function actualizarInterfazPiso(piso, nombre, imagen, descripcion) {
        // Actualizar header
        $('#headerTitle').text(`Seguimiento de Equipos - ${nombre}`);
        $('#floorDescription').text(descripcion);

        // Actualizar imagen del plano
        $('#planoImg').attr('src', imagen).attr('alt', nombre);

        // Actualizar botones activos
        $('.floor-btn').removeClass('active');
        $(`.floor-btn[data-piso="${piso}"]`).addClass('active');

        // Limpiar búsqueda
        $('#buscarReceptor').val('');

        // Resetear modo edición si estaba activo
        if (AppState.editMode) {
            AppState.editMode = false;
            updateEditModeUI();
        }
    }

    /**
     * Reinicializa el mapa con los nuevos datos
     */
    function reinicializarMapa() {
        // Limpiar estado
        AppState.originalPositions = {};
        AppState.modifiedEquipments.clear();

        // Reinicializar mapa
        initializeMap();
        updateEquipmentCount();

        // Mostrar/ocultar estado vacío
        if (equiposData.length === 0) {
            $('#mapaContainer').hide();
            $('#emptyFloor').show();
            $('#emptyTitle').text(`No hay equipos en ${FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre}`);
        } else {
            $('#mapaContainer').show();
            $('#emptyFloor').hide();
        }

        // Reiniciar polling
        pollScanStart();
    }

    function updateEquipmentCount() {
        $('#equipmentCount').text(equiposData.length);
    }

    function initializeMap() {
        const container = $('#mapaContainer');
        $('.marcador').remove();

        if (equiposData.length === 0) {
            return;
        }

        equiposData.forEach(equipo => {
            const coords = {
                x: equipo.pos_x || 100,
                y: equipo.pos_y || 100
            };
            createMarker(equipo, coords, container);
        });
    }

    // 🔹 Función para obtener ícono según id de categoría (ruta de imagen)
    function getIconByCategoria(idCategoria) {
        if (!idCategoria) return "img/iconos/default.png"; // Icono por defecto

        const mapaIconos = {
            1: "img/iconos/CPU.png",          // UNIDAD CENTRAL DE PROCESO - CPU
            2: "img/iconos/MONITOR.png",      // MONITOR LED
            3: "img/iconos/TECLADO.png",      // TECLADO
            4: "img/iconos/LAPTOP.png",       // LAPTOP
            5: "img/iconos/IMPRESORA.png",    // IMPRESORA
            6: "img/iconos/CONSOLA_AMPLIFICADORA_DE_AUDIO.png",  // CONSOLA AMPLIFICADORA
            7: "img/iconos/CONSOLA_AMPLIFICADORA_DE_AUDIO.png",        // CONSOLA MIXER
            8: "img/iconos/PARLANTES.png",
            9: "img/iconos/PARLANTES.png",
            10: "img/iconos/MICROFONO.png",
            11: "img/iconos/VIDEO_CAMARA_PARA_CPU.png",
            12: "img/iconos/ESTABILIZADOR.png",
            13: "img/iconos/UPS.png",
            14: "img/iconos/GRABADORA_DIGITAL.png",
            15: "img/iconos/TARJETA DE SONIDO EXTERNO.png",
            16: "img/iconos/SWITCH_RED.png",
            17: "img/iconos/AUDIFONOS_PROFESIONALES.png",
            18: "img/iconos/LECTOR_DE_CODIGO_DE_BARRAS.png"
        };

        return mapaIconos[idCategoria] || "img/iconos/default.png";
    }

    // 🔹 createMarker actualizado con <img>
    function createMarker(equipo, coords, container) {
        const icono = getIconByCategoria(equipo.equipo_bien);

        // Verificar si es impresora con niveles bajos
        let alertaBaja = '';
        if (equipo.equipo_bien == 5) { // Si es impresora
            const toner = parseInt(equipo.nivel_toner) || null;
            const kit = parseInt(equipo.nivel_kit_mantenimiento) || null;
            const unidad = parseInt(equipo.nivel_unidad_imagen) || null;

            // Si algún suministro está por debajo del 15%
            if ((toner !== null && toner < 15) ||
                (kit !== null && kit < 15) ||
                (unidad !== null && unidad < 15)) {
                alertaBaja = '<span class="supply-alert" title="Suministros bajos">⚠️</span>';
            }
        }

        const marcador = $(`
        <div class="marcador ${equipo.estado_conexion == '1' ? 'conectado' : 'desconectado'}"
             data-equipo-id="${equipo.id_ubicacion_equipos}"
             data-ip="${equipo.ip_ubicacion_equipos || ''}"
             data-mac="${equipo.mac_ubicacion_equipos || ''}"
             data-bien-id="${equipo.id_bien || ''}"
             data-equipo-nombre="${equipo.equipo_bien || 'Equipo sin nombre'}"
             data-piso="${equipo.piso || CONFIG.CURRENT_FLOOR}"
             style="top: ${coords.y}px; left: ${coords.x}px;">
             <span class="marcador-shadow" aria-hidden="true"></span>
            <img src="${icono}" alt="icono" class="icono-equipo">
        </div>
    `);

        AppState.originalPositions[equipo.id_ubicacion_equipos] = { x: coords.x, y: coords.y };

        // Event listeners para tooltip
        marcador.on('mouseenter', function(e) {
            if (!AppState.isDragging) showTooltip(e, equipo);
        });

        marcador.on('mouseleave', function(e) {
            setTimeout(() => {
                if (!$('#customTooltip:hover').length && !$(e.currentTarget).is(':hover')) {
                    hideTooltip();
                }
            }, 100);
        });

        $('#customTooltip').off('mouseenter mouseleave').on({
            mouseenter: function() {},
            mouseleave: function() { hideTooltip(); }
        });

        // Event listener para drag (solo en modo edición)
        marcador.on('mousedown', function(e) {
            if (AppState.editMode) {
                hideTooltip();
                startDrag(e, this);
            }
        });

        // CAMBIO PRINCIPAL: Usar dblclick en lugar de click para abrir modal
        marcador.on('dblclick', function(e) {
            // Prevenir que se abra el modal si estamos en modo edición y arrastrando
            if (AppState.deleteMode || (AppState.editMode && AppState.isDragging)) {
                return;
            }

            hideTooltip(); // Ocultar tooltip al abrir modal
            abrirModalEditarEquipo(equipo);
        });

        // MODIFICADO: Agregar lógica para modo eliminación
        marcador.on('click', function(e) {
            if (AppState.deleteMode) {
                // Modo eliminación: mostrar confirmación
                e.preventDefault();
                e.stopPropagation();
                hideTooltip();
                showDeleteConfirmation(equipo);
                return;
            }

            // Modo normal: resaltar marcador
            if (!AppState.isDragging && !AppState.editMode) {
                console.log(`Marcador clickeado: ${equipo.equipo_bien || 'Equipo'}`);
                $(this).addClass('highlight');
                setTimeout(() => {
                    $(this).removeClass('highlight');
                }, 1000);
            }
        });

        container.append(marcador);
    }




    $('#formEditarEquipo').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '../LN/ln_editar_equipo.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert('Equipo actualizado correctamente', 'success');
                    $('#modalEditarEquipo').modal('hide');
                    // Recargar piso actual
                    cambiarPiso(CONFIG.CURRENT_FLOOR, FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre, FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen, FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion);
                } else {
                    showAlert('Error: ' + response.message, 'danger');
                }
            },
            error: function() {
                showAlert('Error de conexión al actualizar equipo', 'danger');
            }
        });
    });

    // También actualizar el event listener del formulario de editar
    $('#formEditarEquipo').off('submit').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const formData = {};

        // Limpiar alertas anteriores
        limpiarAlertasModal('#modalEditarEquipo');

        // Recopilar datos del formulario
        $form.serializeArray().forEach(field => {
            formData[field.name] = field.value;
        });

        const excluir_id = $('#id_ubicacion_equipos').val();
        const submitBtn = $form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Validar formulario completo antes de enviar
        validarFormularioCompleto(formData, excluir_id)
            .then(validationResult => {
                console.log('Resultado validación editar:', validationResult); // DEBUG

                if (!validationResult.success) {
                    const errores = validationResult.errors.join(', ');
                    showModalAlert('Error de validación: ' + errores, 'danger', '#modalEditarEquipo');
                    return; // DETENER EJECUCIÓN - NO ENVIAR AL SERVIDOR
                }

                // Solo si la validación es exitosa, enviar al servidor
                // Deshabilitar botón y mostrar loading
                submitBtn.prop('disabled', true).html('<div class="spinner"></div>Actualizando...');

                $.ajax({
                    url: '../LN/ln_editar_equipo.php',
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log('Respuesta servidor editar:', response); // DEBUG

                        if (response.success) {
                            showModalAlert('Equipo actualizado correctamente', 'success', '#modalEditarEquipo');

                            // Cerrar modal después de un delay
                            setTimeout(() => {
                                $('#modalEditarEquipo').modal('hide');

                                // Recargar piso actual
                                setTimeout(() => {
                                    cambiarPiso(
                                        CONFIG.CURRENT_FLOOR,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion
                                    );
                                }, 300);
                            }, 1500);
                        } else {
                            const tipoError = response.type || 'unknown';
                            let mensaje = response.message || 'Error desconocido';

                            if (tipoError === 'duplicate') {
                                mensaje = 'Datos duplicados: ' + mensaje;
                            }

                            showModalAlert('Error: ' + mensaje, 'danger', '#modalEditarEquipo');
                        }
                    },
                    error: function() {
                        showModalAlert('Error de conexión al actualizar equipo', 'danger', '#modalEditarEquipo');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            })
            .catch(error => {
                console.error('Error en validación:', error);
                showModalAlert('Error al validar los datos', 'danger', '#modalEditarEquipo');
            });
    });



    function bindEvents() {
        $('#toggleMode').on('click', toggleEditMode);
        $('#saveCoordinates').on('click', saveCoordinatesToDatabase);
        $('#resetCoordinates').on('click', resetCoordinates);
        $('#btnEliminarEquipo').on('click', toggleDeleteMode); // NUEVO
        $('#buscarReceptor').on('keyup', function() {
            filterMarkers($(this).val().toLowerCase());
        });

        // Event listeners para modal de confirmación
        $('#cancelDeleteBtn').on('click', cancelDelete); // NUEVO
        $('#confirmDeleteBtn').on('click', confirmDelete); // NUEVO

        $(document).on('mousemove', handleGlobalMouseMove);
        $(document).on('mouseup', handleGlobalMouseUp);
        $(document).on('selectstart', function() {
            return !AppState.isDragging;
        });
    }

    function toggleEditMode() {
        AppState.editMode = !AppState.editMode;
        updateEditModeUI();
    }

    function updateEditModeUI() {
        const btn = $('#toggleMode');
        const saveBtn = $('#saveCoordinates');
        const resetBtn = $('#resetCoordinates');
        const addBtn = $('#btnAnadirEquipo'); // NUEVA LÍNEA
        const deleteBtn = $('#btnEliminarEquipo'); // NUEVO

        if (AppState.editMode) {
            btn.removeClass('view-mode').addClass('edit-mode')
                .html('<i class="fas fa-eye"></i> Modo Vista');
            saveBtn.show();
            resetBtn.show();
            addBtn.hide(); // NUEVA LÍNEA - Ocultar botón "Añadir Equipo" en modo edición
            deleteBtn.hide(); // NUEVO - Ocultar botón eliminar en modo edición
            $('.marcador').addClass('edit-mode');
            showAlert(`Modo edición activado para ${FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre}. Arrastra los marcadores para reposicionarlos.`, 'warning');
        } else {
            btn.removeClass('edit-mode').addClass('view-mode')
                .html('<i class="fas fa-edit"></i> Modo Edición');
            saveBtn.hide();
            resetBtn.hide();
            addBtn.show(); // NUEVA LÍNEA - Mostrar botón "Añadir Equipo" en modo vista
            deleteBtn.show(); // NUEVO - Mostrar botón eliminar en modo vista
            $('.marcador').removeClass('edit-mode modified');
            $('#coordinatesDisplay').hide();
            AppState.modifiedEquipments.clear();
            updateChangesCounter();
            showAlert('Modo vista activado.', 'success');
        }
    }

    function startDrag(e, element) {
        e.preventDefault();
        AppState.isDragging = true;
        AppState.currentDragElement = element;

        const $element = $(element);
        const rect = $('#mapaContainer')[0].getBoundingClientRect();

        AppState.dragOffset.x = e.clientX - rect.left - parseInt($element.css('left'));
        AppState.dragOffset.y = e.clientY - rect.top - parseInt($element.css('top'));

        $element.addClass('dragging');
        hideTooltip();
    }

    function handleGlobalMouseMove(e) {
        if (AppState.isDragging && AppState.currentDragElement) {
            updateDragPosition(e);
        }

        if (AppState.editMode && !AppState.isDragging) {
            updateCoordinatesDisplay(e);
        }
    }

    function updateDragPosition(e) {
        if (!AppState.currentDragElement) return;

        const rect = $('#mapaContainer')[0].getBoundingClientRect();
        const newX = e.clientX - rect.left - AppState.dragOffset.x;
        const newY = e.clientY - rect.top - AppState.dragOffset.y;

        const imgRect = $('#planoImg')[0].getBoundingClientRect();
        const maxX = imgRect.width;
        const maxY = imgRect.height;

        const boundedX = Math.max(0, Math.min(newX, maxX));
        const boundedY = Math.max(0, Math.min(newY, maxY));

        $(AppState.currentDragElement).css({
            left: boundedX + 'px',
            top: boundedY + 'px'
        });
    }

    function handleGlobalMouseUp() {
        if (AppState.isDragging) {
            stopDrag();
        }
    }

    function stopDrag() {
        if (AppState.currentDragElement) {
            const $element = $(AppState.currentDragElement);
            $element.removeClass('dragging');

            const equipoId = $element.data('equipo-id');
            const newX = Math.round(parseInt($element.css('left')));
            const newY = Math.round(parseInt($element.css('top')));

            const original = AppState.originalPositions[equipoId];
            if (original.x !== newX || original.y !== newY) {
                $element.addClass('modified');
                AppState.modifiedEquipments.add(equipoId);
                updateChangesCounter();
            }

            AppState.currentDragElement = null;
        }

        // AGREGADO: Pequeño delay antes de permitir clicks nuevamente
        // Esto previene que un mouseup accidental después de arrastrar abra el modal
        setTimeout(() => {
            AppState.isDragging = false;
        }, 100);
    }

    function updateCoordinatesDisplay(e) {
        const rect = $('#mapaContainer')[0].getBoundingClientRect();
        const x = Math.round(e.clientX - rect.left);
        const y = Math.round(e.clientY - rect.top);

        $('#coordinatesDisplay')
            .html(`${FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre} - Coordenadas: ${x}, ${y}`)
            .show();
    }

    function updateChangesCounter() {
        const counter = $('#changesCounter');
        const count = AppState.modifiedEquipments.size;

        if (count > 0) {
            counter.text(count).show();
            $('#saveCoordinates').prop('disabled', false);
        } else {
            counter.hide();
            $('#saveCoordinates').prop('disabled', true);
        }
    }

    function saveCoordinatesToDatabase() {
        if (AppState.modifiedEquipments.size === 0) {
            showAlert('No hay cambios para guardar.', 'warning');
            return;
        }

        const saveBtn = $('#saveCoordinates');
        const originalHtml = saveBtn.html();
        saveBtn.prop('disabled', true).html('<div class="spinner"></div>Guardando...');

        const coordinatesData = prepareCoordinatesData();

        $.ajax({
            url: CONFIG.AJAX_URL_SAVE,
            method: 'POST',
            data: {
                coordinates: JSON.stringify(coordinatesData),
                piso: CONFIG.CURRENT_FLOOR
            },
            dataType: 'json',
            success: handleSaveSuccess,
            error: handleSaveError,
            complete: function() {
                saveBtn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    function prepareCoordinatesData() {
        const coordinatesData = [];
        AppState.modifiedEquipments.forEach(equipoId => {
            const $marcador = $(`.marcador[data-equipo-id="${equipoId}"]`);

            if ($marcador.length > 0) { // AGREGADO: Verificar que el marcador existe
                const x = Math.round(parseInt($marcador.css('left')));
                const y = Math.round(parseInt($marcador.css('top')));

                // AGREGADO: Validar coordenadas antes de enviar
                if (x >= CONFIG.MIN_COORDINATE && x <= CONFIG.MAX_COORDINATE &&
                    y >= CONFIG.MIN_COORDINATE && y <= CONFIG.MAX_COORDINATE) {
                    coordinatesData.push({
                        id: parseInt(equipoId),
                        x: x,
                        y: y,
                        piso: CONFIG.CURRENT_FLOOR
                    });
                } else {
                    console.warn(`Coordenadas inválidas para equipo ${equipoId}: (${x}, ${y})`);
                    showAlert(`Coordenadas inválidas para equipo ${equipoId}`, 'warning');
                }
            }
        });
        return coordinatesData;
    }

    function handleSaveSuccess(response) {
        console.log('Respuesta del servidor:', response);

        if (response && response.success) {
            const coordinatesData = prepareCoordinatesData();

            // AGREGADO: Validar que hay datos para procesar
            if (coordinatesData.length === 0) {
                showAlert('No se encontraron coordenadas válidas para actualizar', 'warning');
                return;
            }

            coordinatesData.forEach(coord => {
                AppState.originalPositions[coord.id] = { x: coord.x, y: coord.y };

                const equipoIndex = equiposData.findIndex(e => e.id_ubicacion_equipos == coord.id);
                if (equipoIndex !== -1) {
                    equiposData[equipoIndex].pos_x = coord.x;
                    equiposData[equipoIndex].pos_y = coord.y;
                }
            });

            $('.marcador.modified').removeClass('modified');
            AppState.modifiedEquipments.clear();
            updateChangesCounter();

            showAlert(`${coordinatesData.length} coordenadas guardadas en ${FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre}.`, 'success');

            // MEJORADO: Mostrar advertencias de manera más clara
            if (response.warnings && response.warnings.length > 0) {
                const maxWarningsToShow = 3;
                const warningsToShow = response.warnings.slice(0, maxWarningsToShow);
                const warningMessage = warningsToShow.join('; ');

                setTimeout(() => {
                    showAlert(`Advertencias: ${warningMessage}${response.warnings.length > maxWarningsToShow ? '...' : ''}`, 'warning');
                }, 1000);
            }

            // AGREGADO: Mostrar errores si existen
            if (response.errors && response.errors.length > 0) {
                setTimeout(() => {
                    showAlert(`Errores: ${response.errors.slice(0, 2).join('; ')}`, 'danger');
                }, 2000);
            }
        } else {
            showAlert('Error al guardar coordenadas: ' + (response ? response.message : 'Respuesta inválida'), 'danger');
        }
    }

    function handleSaveError(xhr, status, error) {
        console.error('Error AJAX:', { xhr, status, error });
        showAlert('Error de conexión al guardar coordenadas.', 'danger');
    }

    function resetCoordinates() {
        if (AppState.modifiedEquipments.size === 0) {
            showAlert('No hay cambios para cancelar.', 'warning');
            return;
        }

        AppState.modifiedEquipments.forEach(equipoId => {
            const $marcador = $(`.marcador[data-equipo-id="${equipoId}"]`);
            const original = AppState.originalPositions[equipoId];
            $marcador.css({
                left: original.x + 'px',
                top: original.y + 'px'
            }).removeClass('modified');
        });

        AppState.modifiedEquipments.clear();
        updateChangesCounter();
        showAlert('Cambios cancelados. Posiciones restauradas.', 'success');
    }

    function showTooltip(e, equipo) {
        const tooltip = $('#customTooltip');
        const $marcador = $(e.currentTarget);

        const bienInfo = equipo.equipo_bien ? `
        <strong>Equipo:</strong> ${equipo.equipo_bien}<br>
        <strong>Marca:</strong> ${equipo.marca_bien || 'N/A'}<br>
        <strong>Modelo:</strong> ${equipo.modelo_bien || 'N/A'}<br>
        <strong>Procesador:</strong> ${equipo.procesador_bien || 'N/A'}<br>
        <strong>N° Serie:</strong> ${equipo.numdeserie_bien || 'N/A'}<br>
        <strong>N° Patrimonial:</strong> ${equipo.numcontropatri_bien || 'N/A'}<br>
        <strong>Estado Bien:</strong> ${equipo.estado_bien || 'N/A'}<br>
        <strong>Año Adquisición:</strong> ${equipo.añodeadqs_bien || 'N/A'}<br>
        <strong>Funcionamiento:</strong> ${equipo.funcionamiento == '1' ? 'Activo' : 'Inactivo'}<br>
    ` : '<strong>Bien:</strong> No asignado<br>';

        // NUEVO: Sección de suministros para impresoras
        let suministrosInfo = '';
        if (equipo.equipo_bien == 5) { // Si es impresora
            const toner = equipo.nivel_toner;
            const kit = equipo.nivel_kit_mantenimiento;
            const unidad = equipo.nivel_unidad_imagen;
            const ultimaLectura = equipo.ultima_lectura_suministros;

            suministrosInfo = '<hr style="margin: 8px 0; border-color: rgba(255,255,255,0.2);">';
            suministrosInfo += '<strong style="color: #fbbf24;">📊 Suministros:</strong><br>';

            if (toner !== null) {
                const tonerColor = toner < 15 ? '#ef4444' : (toner < 30 ? '#f59e0b' : '#10b981');
                const tonerIcon = toner < 15 ? '🔴' : (toner < 30 ? '🟡' : '🟢');
                suministrosInfo += `${tonerIcon} <strong>Toner:</strong> <span style="color: ${tonerColor}; font-weight: bold;">${toner}%</span><br>`;
            } else {
                suministrosInfo += '⚪ <strong>Toner:</strong> No disponible<br>';
            }

            if (kit !== null) {
                const kitColor = kit < 15 ? '#ef4444' : (kit < 30 ? '#f59e0b' : '#10b981');
                const kitIcon = kit < 15 ? '🔴' : (kit < 30 ? '🟡' : '🟢');
                suministrosInfo += `${kitIcon} <strong>Kit Mantenimiento:</strong> <span style="color: ${kitColor}; font-weight: bold;">${kit}%</span><br>`;
            } else {
                suministrosInfo += '⚪ <strong>Kit Mantenimiento:</strong> No disponible<br>';
            }

            if (unidad !== null) {
                const unidadColor = unidad < 15 ? '#ef4444' : (unidad < 30 ? '#f59e0b' : '#10b981');
                const unidadIcon = unidad < 15 ? '🔴' : (unidad < 30 ? '🟡' : '🟢');
                suministrosInfo += `${unidadIcon} <strong>Unidad Imagen:</strong> <span style="color: ${unidadColor}; font-weight: bold;">${unidad}%</span><br>`;
            } else {
                suministrosInfo += '⚪ <strong>Unidad Imagen:</strong> No disponible<br>';
            }

            if (ultimaLectura) {
                suministrosInfo += `<small style="color: #9ca3af;">Última lectura: ${ultimaLectura}</small>`;
            }
        }

        const content = `
        ${bienInfo}
        <strong>Persona:</strong> ${equipo.nomyap_persona || 'N/A'}<br>
        <strong>Área:</strong> ${equipo.descripcion_area || 'N/A'}<br>
        <strong>IP:</strong> ${equipo.ip_ubicacion_equipos || 'N/A'}<br>
        <strong>MAC:</strong> ${equipo.mac_ubicacion_equipos || 'N/A'}<br>
        <strong>Piso:</strong> ${equipo.piso || CONFIG.CURRENT_FLOOR}<br>
        <strong>Estado Conexión:</strong> ${equipo.estado_conexion == '1' ? 'Conectado' : 'Desconectado'}<br>
        <strong>Última Detección:</strong> ${equipo.ultima_deteccion || 'N/A'}<br>
        <strong>Coords:</strong> (${equipo.pos_x || 0}, ${equipo.pos_y || 0})
    `;

        const marcadorRect = $marcador[0].getBoundingClientRect();
        const scrollTop = $(window).scrollTop();
        const scrollLeft = $(window).scrollLeft();

        // Centro del marcador
        const centerX = marcadorRect.left + marcadorRect.width / 2 + scrollLeft;
        const centerY = marcadorRect.top + marcadorRect.height / 2 + scrollTop;

        // Medidas estimadas del tooltip
        const tooltipWidth = 280;
        const tooltipHeight = 250;

        // Posicionar centrado horizontalmente y pegado al borde superior del ícono
        let finalX = centerX - tooltipWidth / 2;
        let finalY = centerY - marcadorRect.height / 2 - tooltipHeight; // sin margen

        // Evitar que se salga de la pantalla
        finalX = Math.max(scrollLeft + 5, Math.min(finalX, $(window).width() + scrollLeft - tooltipWidth - 5));
        finalY = Math.max(scrollTop + 5, Math.min(finalY, $(window).height() + scrollTop - tooltipHeight - 5));

        tooltip.html(content).css({
            left: finalX + 'px',
            top: finalY + 'px',
            display: 'block'
        });
    }



    // FUNCIÓN ADICIONAL: Actualizar tooltip durante el movimiento del mouse (opcional)
    function updateTooltipPosition(e, equipo) {
        const tooltip = $('#customTooltip');

        if (tooltip.is(':visible')) {
            const $marcador = $(e.currentTarget);
            const marcadorRect = $marcador[0].getBoundingClientRect();
            const scrollTop = $(window).scrollTop();
            const scrollLeft = $(window).scrollLeft();

            const tooltipX = marcadorRect.right + scrollLeft + 10;
            const tooltipY = marcadorRect.top + scrollTop - 10;

            tooltip.css({
                left: tooltipX + 'px',
                top: tooltipY + 'px'
            });
        }
    }

    function hideTooltip() {
        $('#customTooltip').hide();
    }

    function filterMarkers(filter) {
        $('.marcador').each(function() {
            const equipoId = $(this).data('equipo-id');
            const equipo = equiposData.find(e => e.id_ubicacion_equipos == equipoId);

            if (!equipo) {
                $(this).hide();
                return;
            }

            const searchText = buildSearchText(equipo);
            $(this).toggle(searchText.includes(filter));
        });

        // Update visible count
        const visibleCount = $('.marcador:visible').length;
        $('#equipmentCount').text(visibleCount);
    }

    function buildSearchText(equipo) {
        return `
            ${equipo.equipo_bien || ''}
            ${equipo.marca_bien || ''}
            ${equipo.modelo_bien || ''}
            ${equipo.numdeserie_bien || ''}
            ${equipo.numcontropatri_bien || ''}
            ${equipo.nomyap_persona || ''}
            ${equipo.descripcion_area || ''}
            ${equipo.ip_ubicacion_equipos || ''}
            ${equipo.mac_ubicacion_equipos || ''}
            ${equipo.piso || ''}
        `.toLowerCase();
    }

    function showAlert(message, type) {
        const iconClass = getAlertIcon(type);
        const alert = $(`
            <div class="custom-alert alert-${type}">
                <i class="fas fa-${iconClass}"></i>
                ${message}
            </div>
        `);

        $('#alertContainer').append(alert);

        setTimeout(() => {
            alert.remove();
        }, CONFIG.ALERT_DURATION);
    }

    function getAlertIcon(type) {
        const icons = {
            'success': 'check-circle',
            'danger': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }



    // Al cambiar categoría, cargar bienes relacionados
    $('#id_categoria').on('change', function() {
        let idCategoria = $(this).val();
        $('#id_bien').html('<option value="">Cargando...</option>');

        if (idCategoria) {
            $.ajax({
                url: '../LN/ln_listar_bienes_categoria.php',
                type: 'POST',
                data: { id_categoria: idCategoria },
                dataType: 'json',
                success: function(data) {
                    let opciones = '<option value="">Seleccione un Bien</option>';
                    data.forEach(bien => {
                        opciones += `<option value="${bien.id_bien}">${bien.marca_bien} - ${bien.modelo_bien} - ${bien.numcontropatri_bien}</option>`;
                    });
                    $('#id_bien').html(opciones);

                    // 🔹 Si estamos editando, seleccionar el bien guardado
                    if (window.bienSeleccionadoTemporal) {
                        $('#id_bien').val(window.bienSeleccionadoTemporal).trigger('change');
                        window.bienSeleccionadoTemporal = null; // limpiar
                    }
                },
                error: function() {
                    $('#id_bien').html('<option value="">Error al cargar</option>');
                }
            });
        } else {
            $('#id_bien').html('<option value="">Seleccione un Bien</option>');
        }
    });


    // En editar equipo, también preseleccionar categoría y cargar bienes
    function abrirModalEditarEquipo(equipo) {
        // Llenar campos básicos
        $('#id_ubicacion_equipos').val(equipo.id_ubicacion_equipos);
        $('#ip_ubicacion_equipos').val(equipo.ip_ubicacion_equipos);
        $('#mac_ubicacion_equipos').val(equipo.mac_ubicacion_equipos);
        $('#id_persona').val(equipo.id_persona);
        $('#id_area').val(equipo.id_area);
        $('#estado_conexion').val(equipo.estado_conexion);
        $('#ultima_deteccion').val(equipo.ultima_deteccion ? equipo.ultima_deteccion.replace(" ", "T") : '');
        $('#piso').val(equipo.piso);
        $('#pos_x').val(equipo.pos_x);
        $('#pos_y').val(equipo.pos_y);

        // Limpiar validaciones anteriores
        $('.validation-message').remove();
        $('.validation-indicator').remove();
        $('#modalEditarEquipo .form-control').removeClass('is-invalid is-valid');

        // Manejar categoría y bien de forma secuencial
        if (equipo.equipo_bien) {
            // Primero establecer la categoría
            $('#id_categoria').val(equipo.equipo_bien);

            // Aplicar configuración de campos network
            toggleCamposNetwork(parseInt(equipo.equipo_bien));

            // LUEGO establecer valores de IP/MAC solo si la categoría los requiere
            if (categoriaRequiereNetwork(parseInt(equipo.equipo_bien))) {
                $('#ip_ubicacion_equipos').val(equipo.ip_ubicacion_equipos || '');
                $('#mac_ubicacion_equipos').val(equipo.mac_ubicacion_equipos || '');
            }

            // Cargar bienes y LUEGO establecer el bien seleccionado
            $('#id_bien').html('<option value="">Cargando...</option>');

            $.ajax({
                url: '../LN/ln_listar_bienes_categoria.php',
                type: 'POST',
                data: { id_categoria: equipo.equipo_bien },
                dataType: 'json',
                success: function(data) {
                    let opciones = '<option value="">Seleccione un Bien</option>';
                    if (data && Array.isArray(data)) {
                        data.forEach(bien => {
                            opciones += `<option value="${bien.id_bien}">${bien.marca_bien} - ${bien.modelo_bien}</option>`;
                        });
                    }
                    $('#id_bien').html(opciones);

                    // Establecer el bien seleccionado después de cargar las opciones
                    if (equipo.id_bien) {
                        $('#id_bien').val(equipo.id_bien);
                    }
                },
                error: function() {
                    $('#id_bien').html('<option value="">Error al cargar</option>');
                    console.error('Error al cargar bienes para la categoría:', equipo.equipo_bien);
                }
            });

        } else {
            // Si no hay categoría, limpiar campos
            $('#id_categoria').val('');
            $('#id_bien').html('<option value="">Seleccione un Bien</option>');
            toggleCamposNetwork(0); // Ocultar campos por defecto
        }

        // NUEVO: Cargar datos de suministros si es impresora (id_categoria = 5)
        const esImpresora = (parseInt(equipo.equipo_bien) === 5);

        console.log('DEBUG Modal Editar:', {
            esImpresora: esImpresora,
            categoria: equipo.equipo_bien,
            toner: equipo.nivel_toner,
            kit: equipo.nivel_kit_mantenimiento,
            unidad: equipo.nivel_unidad_imagen
        });

        if (esImpresora) {
            // Mostrar sección de suministros CON IDS CORREGIDOS
            $('#seccion-suministros, #campo-toner-editar, #campo-kit-editar, #campo-unidad-editar').show();

            // Cargar valores (pueden ser null)
            $('#nivel_toner_editar').val(equipo.nivel_toner !== null ? equipo.nivel_toner : '');
            $('#nivel_kit_mantenimiento_editar').val(equipo.nivel_kit_mantenimiento !== null ? equipo.nivel_kit_mantenimiento : '');
            $('#nivel_unidad_imagen_editar').val(equipo.nivel_unidad_imagen !== null ? equipo.nivel_unidad_imagen : '');

            // Agregar indicadores visuales de estado
            aplicarEstiloSuministro('#nivel_toner_editar', equipo.nivel_toner);
            aplicarEstiloSuministro('#nivel_kit_mantenimiento_editar', equipo.nivel_kit_mantenimiento);
            aplicarEstiloSuministro('#nivel_unidad_imagen_editar', equipo.nivel_unidad_imagen);

        } else {
            // Ocultar sección de suministros para otros tipos de equipos
            $('#seccion-suministros, #campo-toner-editar, #campo-kit-editar, #campo-unidad-editar').hide();
        }

        // Mostrar modal
        $('#modalEditarEquipo').modal('show');
    }

    /**
     * Aplica estilos de color según el nivel de suministro
     */
    function aplicarEstiloSuministro(selector, nivel) {
        const $input = $(selector);

        // Limpiar clases previas
        $input.removeClass('bg-success bg-warning bg-danger text-white');

        if (nivel === null || nivel === undefined || nivel === '') {
            $input.addClass('bg-secondary text-white');
            $input.attr('placeholder', 'No disponible');
            return;
        }

        const nivelNum = parseInt(nivel);

        if (nivelNum < 15) {
            $input.addClass('bg-danger text-white');
        } else if (nivelNum < 30) {
            $input.addClass('bg-warning text-dark');
        } else {
            $input.addClass('bg-success text-white');
        }
    }

    // También corregir el event listener para cambio de categoría en modal editar
    $('#id_categoria').off('change.editModal').on('change.editModal', function() {
        const idCategoria = parseInt($(this).val()) || 0;
        toggleCamposNetwork(idCategoria);

        // Limpiar el select de bienes cuando se cambia la categoría manualmente
        $('#id_bien').html('<option value="">Seleccione un Bien</option>');

        if (idCategoria) {
            $('#id_bien').html('<option value="">Cargando...</option>');

            $.ajax({
                url: '../LN/ln_listar_bienes_categoria.php',
                type: 'POST',
                data: { id_categoria: idCategoria },
                dataType: 'json',
                success: function(data) {
                    let opciones = '<option value="">Seleccione un Bien</option>';
                    if (data && Array.isArray(data)) {
                        data.forEach(bien => {
                            opciones += `<option value="${bien.id_bien}">${bien.marca_bien} - ${bien.modelo_bien} - ${bien.numcontropatri_bien}</option>`;
                        });
                    }
                    $('#id_bien').html(opciones);
                },
                error: function() {
                    $('#id_bien').html('<option value="">Error al cargar</option>');
                }
            });
        }
    });


    // Event listener para el botón "Añadir Equipo"
    $(document).ready(function() {
        // Añadir al final de la función existente $(document).ready()

        $('#btnAnadirEquipo').on('click', function() {
            abrirModalAnadirEquipo();
        });

        // Event listener para el formulario de añadir equipo
        $('#formAnadirEquipo').on('submit', function(e) {
            e.preventDefault();
            procesarAnadirEquipo();
        });

        // Cambio de categoría en modal añadir
        // Event listeners para cambio de categoría en ambos modales
        $('#id_categoria_nuevo').on('change', function() {
            const idCategoria = parseInt($(this).val()) || 0;
            toggleCamposNetwork(idCategoria);

            // Cargar bienes por categoría
            cargarBienesPorCategoria(idCategoria, '#id_bien_nuevo');
        });

        $('#id_categoria').on('change', function() {
            const idCategoria = parseInt($(this).val()) || 0;
            toggleCamposNetwork(idCategoria);

            // Cargar bienes por categoría
            cargarBienesPorCategoria(idCategoria, '#id_bien');
        });

        // Event listeners para validación en tiempo real con categoría
        $('#ip_nuevo, #ip_ubicacion_equipos').on('input', function() {
            validarCampoIndividualConCategoria($(this), 'ip');
        });

        $('#mac_nuevo, #mac_ubicacion_equipos').on('input', function() {
            validarCampoIndividualConCategoria($(this), 'mac');
        });

        // Limpiar alertas cuando se abren los modales
        $('#modalAnadirEquipo').on('show.bs.modal', function() {
            limpiarAlertasModal('#modalAnadirEquipo');
            // Limpiar todas las validaciones en línea
            $(this).find('.validation-message').remove();
            $(this).find('.form-control').removeClass('is-invalid is-valid');
        });

        $('#modalEditarEquipo').on('show.bs.modal', function() {
            limpiarAlertasModal('#modalEditarEquipo');
            // Limpiar todas las validaciones en línea
            $(this).find('.validation-message').remove();
            $(this).find('.form-control').removeClass('is-invalid is-valid');
        });
    });

    /**
     * Abre el modal para añadir equipo nuevo
     */
    function abrirModalAnadirEquipo() {
        // Limpiar formulario
        $('#formAnadirEquipo')[0].reset();

        // Establecer valores por defecto
        $('#estado_conexion_nuevo').val('1');
        $('#piso_nuevo').val(CONFIG.CURRENT_FLOOR);
        $('#pos_x_nuevo').val(100);
        $('#pos_y_nuevo').val(100);

        // Limpiar select de bienes
        $('#id_bien_nuevo').html('<option value="">Seleccione un Bien</option>');

        // Establecer fecha actual en última detección
        const ahora = new Date();
        const fechaLocal = new Date(ahora.getTime() - ahora.getTimezoneOffset() * 60000);
        $('#ultima_deteccion_nuevo').val(fechaLocal.toISOString().slice(0, 16));


        toggleCamposNetwork(0); // 0 = sin categoría seleccionada

        // Limpiar validaciones anteriores
        $('.validation-message').remove();
        $('.validation-indicator').remove();
        $('#modalAnadirEquipo .form-control').removeClass('is-invalid is-valid');

        // Mostrar modal
        $('#modalAnadirEquipo').modal('show');
    }

    /**
     * Procesa el formulario de añadir equipo
     */
    // Modificar la función procesarAnadirEquipo existente
    function procesarAnadirEquipo() {
        const $form = $('#formAnadirEquipo');
        const formData = {};

        // Recopilar datos del formulario
        $form.serializeArray().forEach(field => {
            formData[field.name] = field.value;
        });

        const submitBtn = $form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Validar formulario completo antes de enviar
        validarFormularioCompleto(formData)
            .then(validationResult => {
                if (!validationResult.success) {
                    // Mostrar errores de validación
                    const errores = validationResult.errors.join(', ');
                    showAlert('Error de validación: ' + errores, 'danger');
                    return;
                }

                // Deshabilitar botón y mostrar loading
                submitBtn.prop('disabled', true).html('<div class="spinner"></div>Guardando...');

                // Enviar datos al servidor
                $.ajax({
                    url: '../LN/ln_anadir_equipo.php',
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.success) {
                            showAlert('Equipo agregado correctamente', 'success');
                            $('#modalAnadirEquipo').modal('hide');

                            // Recargar el piso actual para mostrar el nuevo equipo
                            setTimeout(() => {
                                cambiarPiso(
                                    CONFIG.CURRENT_FLOOR,
                                    FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre,
                                    FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen,
                                    FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion
                                );
                            }, 500);
                        } else {
                            const tipoError = response.type || 'unknown';
                            let mensaje = response.message || 'Error desconocido';

                            if (tipoError === 'duplicate') {
                                mensaje = 'Datos duplicados: ' + mensaje;
                            }

                            showAlert('Error: ' + mensaje, 'danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error añadiendo equipo:', { xhr, status, error });
                        let errorMsg = 'Error de conexión al añadir equipo';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        showAlert(errorMsg, 'danger');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            })
            .catch(error => {
                console.error('Error en validación:', error);
                showAlert('Error al validar los datos', 'danger');
            });
    }


    /**
     * Carga bienes filtrados por categoría
     */
    function cargarBienesPorCategoria(idCategoria, targetSelect) {
        const $select = $(targetSelect);

        if (!idCategoria) {
            $select.html('<option value="">Seleccione un Bien</option>');
            return;
        }

        $select.html('<option value="">Cargando...</option>');

        $.ajax({
            url: '../LN/ln_listar_bienes_categoria.php',
            type: 'POST',
            data: { id_categoria: idCategoria },
            dataType: 'json',
            success: function(data) {
                let opciones = '<option value="">Seleccione un Bien</option>';
                if (data && Array.isArray(data)) {
                    data.forEach(bien => {
                        opciones += `<option value="${bien.id_bien}">${bien.marca_bien} - ${bien.modelo_bien} - ${bien.numcontropatri_bien}</option>`;
                    });
                }
                $select.html(opciones);
            },
            error: function() {
                $select.html('<option value="">Error al cargar</option>');
                showAlert('Error al cargar los bienes de la categoría', 'warning');
            }
        });
    }


    // NUEVA FUNCIÓN: Alternar modo eliminación
    function toggleDeleteMode() {
        // No permitir modo eliminación si hay cambios pendientes
        if (AppState.modifiedEquipments.size > 0) {
            showAlert('Debes guardar o cancelar los cambios antes de eliminar equipos', 'warning');
            return;
        }

        AppState.deleteMode = !AppState.deleteMode;
        updateDeleteModeUI();
    }

    // NUEVA FUNCIÓN: Actualizar UI del modo eliminación
    function updateDeleteModeUI() {
        const btn = $('#btnEliminarEquipo');
        const addBtn = $('#btnAnadirEquipo');
        const editBtn = $('#toggleMode');

        if (AppState.deleteMode) {
            // Activar modo eliminación
            btn.removeClass('view-mode').addClass('delete-mode')
                .html('<i class="fas fa-times"></i> Cancelar Eliminación');

            // Deshabilitar otros botones
            addBtn.hide();
            editBtn.hide();

            // Cambiar apariencia de marcadores
            $('.marcador').addClass('delete-mode');

            showAlert('Modo eliminación activado. Haz clic en un equipo para eliminarlo.', 'warning');

            // Ocultar tooltip mientras esté en modo eliminación
            hideTooltip();

        } else {
            // Desactivar modo eliminación
            btn.removeClass('delete-mode').addClass('view-mode')
                .html('<i class="fas fa-trash"></i> Eliminar Equipo');

            // Restaurar otros botones
            addBtn.show();
            editBtn.show();

            // Restaurar apariencia de marcadores
            $('.marcador').removeClass('delete-mode');

            showAlert('Modo eliminación desactivado.', 'success');
        }
    }

    // ALTERNATIVA SIMPLE: Reemplazar la función showDeleteConfirmation
    function showDeleteConfirmation(equipo) {
        AppState.equipmentToDelete = equipo;

        // Usar texto plano en lugar de HTML para evitar problemas de parsing
        let detalles = '';
        detalles += 'Equipo: ' + (equipo.equipo_bien || 'N/A') + '\n';
        detalles += 'IP: ' + (equipo.ip_ubicacion_equipos || 'N/A') + '\n';
        detalles += 'MAC: ' + (equipo.mac_ubicacion_equipos || 'N/A') + '\n';
        detalles += 'Persona: ' + (equipo.nomyap_persona || 'N/A') + '\n';
        detalles += 'Área: ' + (equipo.descripcion_area || 'N/A') + '\n';
        detalles += 'Piso: ' + (equipo.piso || CONFIG.CURRENT_FLOOR);

        // Usar text() en lugar de html() para mayor seguridad
        $('#deleteEquipmentDetails').text(detalles).css({
            'white-space': 'pre-line',
            'font-family': 'monospace'
        });

        $('#confirmDeleteModal').show();

        // Prevenir scroll del fondo
        $('body').css('overflow', 'hidden');
    }

    // NUEVA FUNCIÓN: Cancelar eliminación
    function cancelDelete() {
        $('#confirmDeleteModal').hide();
        $('body').css('overflow', 'auto');

        // AGREGADO: Resetear el botón de confirmación
        const confirmBtn = $('#confirmDeleteBtn');
        confirmBtn.prop('disabled', false).html('<i class="fas fa-trash"></i> Eliminar Equipo');

        // Limpiar datos
        AppState.equipmentToDelete = null;
    }

    // NUEVA FUNCIÓN: Confirmar eliminación
    function confirmDelete() {
        if (!AppState.equipmentToDelete) {
            showAlert('Error: No hay equipo seleccionado para eliminar', 'danger');
            return;
        }

        const btn = $('#confirmDeleteBtn');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<div class="spinner"></div>Eliminando...');

        $.ajax({
            url: '../LN/ln_eliminar_equipo.php',
            method: 'POST',
            data: {
                id_ubicacion_equipos: AppState.equipmentToDelete.id_ubicacion_equipos
            },
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    showAlert('Equipo eliminado correctamente', 'success');

                    // Cerrar modal
                    cancelDelete();

                    // Salir del modo eliminación
                    AppState.deleteMode = false;
                    updateDeleteModeUI();

                    // CAMBIO PRINCIPAL: Recargar datos del piso actual desde la BD
                    setTimeout(() => {
                        cambiarPiso(
                            CONFIG.CURRENT_FLOOR,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion
                        );
                    }, 500);

                    // Eliminar marcador del mapa
                    $(`.marcador[data-equipo-id="${AppState.equipmentToDelete.id_ubicacion_equipos}"]`).remove();

                    // Actualizar datos locales
                    equiposData = equiposData.filter(e =>
                        e.id_ubicacion_equipos != AppState.equipmentToDelete.id_ubicacion_equipos
                    );

                    // Actualizar contador
                    updateEquipmentCount();

                    // Mostrar estado vacío si no hay equipos
                    if (equiposData.length === 0) {
                        $('#mapaContainer').hide();
                        $('#emptyFloor').show();
                        $('#emptyTitle').text(`No hay equipos en ${FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre}`);
                    }

                } else {
                    showAlert('Error: ' + (response ? response.message : 'No se pudo eliminar el equipo'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error eliminando equipo:', { xhr, status, error });
                let errorMsg = 'Error de conexión al eliminar equipo';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                showAlert(errorMsg, 'danger');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    }

    // OPCIONAL: Manejar click fuera del modal para cerrarlo
    $(document).ready(function() {
        // Agregar este event listener a los existentes
        $('#confirmDeleteModal').on('click', function(e) {
            // Si se hace click en el fondo del modal (no en el contenido), cerrarlo
            if (e.target === this) {
                cancelDelete();
            }
        });

        // Cerrar con ESC
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#confirmDeleteModal').is(':visible')) {
                cancelDelete();
            }
        });

        // Event listener para actualizar suministros SNMP
        $('#btnActualizarSNMP').on('click', function() {
            performSNMPScan();
        });
    });


    // Función para validar formato de IP
    function validarFormatoIP(ip) {
        const regex = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
        return regex.test(ip);
    }

    // Función para validar formato de MAC
    function validarFormatoMAC(mac) {
        const regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;
        return regex.test(mac);
    }

    // Función para normalizar MAC
    function normalizarMAC(mac) {
        return mac.toUpperCase().replace(/-/g, ':');
    }

    // Función para mostrar/ocultar indicadores de validación
    function mostrarIndicadorValidacion($input, tipo, mensaje = '') {
        const $parent = $input.parent();
        const indicadorId = $input.attr('id') + '_indicator';

        // Remover indicador anterior
        $parent.find('.validation-indicator').remove();

        let iconClass, colorClass, bgClass;

        switch(tipo) {
            case 'loading':
                iconClass = 'fas fa-spinner fa-spin';
                colorClass = 'text-info';
                bgClass = 'bg-info';
                break;
            case 'success':
                iconClass = 'fas fa-check';
                colorClass = 'text-success';
                bgClass = 'bg-success';
                break;
            case 'error':
                iconClass = 'fas fa-exclamation-triangle';
                colorClass = 'text-danger';
                bgClass = 'bg-danger';
                break;
            case 'warning':
                iconClass = 'fas fa-exclamation-circle';
                colorClass = 'text-warning';
                bgClass = 'bg-warning';
                break;
            default:
                return;
        }

        const indicador = `
        <div class="validation-indicator ${colorClass}" id="${indicadorId}"
             style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10;"
             title="${mensaje}">
            <i class="${iconClass}"></i>
        </div>
    `;

        $parent.css('position', 'relative').append(indicador);

        // Auto-ocultar indicadores de éxito después de 3 segundos
        if (tipo === 'success') {
            setTimeout(() => {
                $parent.find('#' + indicadorId).fadeOut(300);
            }, 3000);
        }
    }

    // Función principal de validación de duplicados
    function validarDuplicados(ip, mac, id_bien, excluir_id = null) {
        return new Promise((resolve, reject) => {
            if (isValidating) {
                resolve({ success: true, errors: [] }); // Evitar múltiples validaciones simultáneas
                return;
            }

            isValidating = true;

            $.ajax({
                url: '../LN/ln_validar_duplicados.php',
                method: 'POST',
                data: {
                    ip: ip,
                    mac: mac,
                    id_bien: id_bien,
                    excluir_id: excluir_id
                },
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error en validación:', { xhr, status, error });
                    reject({
                        success: false,
                        message: 'Error de conexión al validar duplicados'
                    });
                },
                complete: function() {
                    isValidating = false;
                }
            });
        });
    }

    // Función para validar campo individual con debounce
    function validarCampoIndividual($input, tipo) {
        const valor = $input.val().trim();

        if (!valor) {
            mostrarIndicadorValidacion($input, 'clear');
            return;
        }

        // Validar formato primero
        let formatoValido = true;
        let mensajeFormato = '';

        if (tipo === 'ip') {
            formatoValido = validarFormatoIP(valor);
            mensajeFormato = 'Formato de IP inválido';
        } else if (tipo === 'mac') {
            formatoValido = validarFormatoMAC(valor);
            mensajeFormato = 'Formato de MAC inválido (AA:BB:CC:DD:EE:FF)';
        }

        if (!formatoValido) {
            mostrarIndicadorValidacion($input, 'warning', mensajeFormato);
            return;
        }

        // Mostrar loading
        mostrarIndicadorValidacion($input, 'loading', 'Verificando disponibilidad...');

        // Obtener ID del equipo actual (para edición)
        const excluir_id = $('#id_ubicacion_equipos').val() || null;

        // Preparar datos para validación
        let datosValidacion = { ip: '', mac: '', id_bien: '', excluir_id: excluir_id };
        datosValidacion[tipo] = valor;

        // Validar después de un delay
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            validarDuplicados(datosValidacion.ip, datosValidacion.mac, datosValidacion.id_bien, excluir_id)
                .then(response => {
                    if (response.success) {
                        mostrarIndicadorValidacion($input, 'success', 'Disponible');
                    } else if (response.errors && response.errors.length > 0) {
                        const mensaje = response.errors.join(', ');
                        mostrarIndicadorValidacion($input, 'error', mensaje);
                    }
                })
                .catch(error => {
                    console.error('Error en validación:', error);
                    mostrarIndicadorValidacion($input, 'error', 'Error al verificar disponibilidad');
                });
        }, 800); // Debounce de 800ms
    }

    // Función para validar formulario completo antes del envío
    function validarFormularioCompleto(formData, excluir_id = null) {
        return new Promise((resolve, reject) => {
            const ip = formData.ip_ubicacion_equipos || '';
            const mac = formData.mac_ubicacion_equipos || '';
            const id_bien = formData.id_bien || '';
            const id_categoria = parseInt(formData.id_categoria) || 0;

            // Validaciones de formato solo si la categoría requiere network
            const erroresFormato = [];

            if (categoriaRequiereNetwork(id_categoria)) {
                // Para categorías que requieren network, validar formato
                if (ip && !validarFormatoIP(ip)) {
                    erroresFormato.push('Formato de IP inválido');
                }
                if (mac && !validarFormatoMAC(mac)) {
                    erroresFormato.push('Formato de MAC inválido');
                }
            } else {
                // Para otras categorías, solo validar si se proporcionaron valores
                if (ip && ip !== '' && !validarFormatoIP(ip)) {
                    erroresFormato.push('Formato de IP inválido');
                }
                if (mac && mac !== '' && !validarFormatoMAC(mac)) {
                    erroresFormato.push('Formato de MAC inválido');
                }
            }

            if (erroresFormato.length > 0) {
                resolve({
                    success: false,
                    errors: erroresFormato,
                    type: 'format'
                });
                return;
            }

            // Validar duplicados
            const datosValidacion = {
                ...formData,
                excluir_id: excluir_id
            };

            $.ajax({
                url: '../LN/ln_validar_duplicados.php',
                method: 'POST',
                data: datosValidacion,
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject({
                        success: false,
                        message: 'Error de conexión al validar duplicados'
                    });
                }
            });
        });
    }






    // === FUNCION: updateMarkerStatus(id, estado, ultima_deteccion)
    // === POLLING y actualización ===
    let POLL_SCAN_INTERVAL = 10000; // 30 segundos en vez de 2s
    let pollScanTimer = null;
    const SCAN_ENDPOINT = 'scan_equipos.php'; // ruta al archivo PHP
    const SNMP_ENDPOINT = 'consultar_suministros_impresora.php'; // Escaneo SNMP

    function updateMarkerStatus(id, estado, ultima_deteccion){
        const $marcador = $(`.marcador[data-equipo-id='${id}']`);
        if ($marcador.length === 0) return;
        if (estado == 1 || estado === '1') {
            $marcador.removeClass('desconectado').addClass('conectado');
            $marcador.attr('data-ultima-deteccion', ultima_deteccion || '');
        } else {
            $marcador.removeClass('conectado').addClass('desconectado');
            $marcador.attr('data-ultima-deteccion', '');
        }
    }

    // Inicia polling
    // Variables para polling SNMP
    let pollSNMPTimer = null;
    const SNMP_SCAN_INTERVAL = 600000; // 10 minutos

    // Inicia polling de estado de conexión
    function pollScanStart(){
        if (pollScanTimer) return;
        performScanOnce(); // llamada inmediata
        pollScanTimer = setInterval(performScanOnce, POLL_SCAN_INTERVAL);
    }

    /*// Inicia polling de suministros SNMP
    function pollSNMPStart() {
        if (pollSNMPTimer) return;

        // Primera ejecución después de 2 segundos (para no sobrecargar al inicio)
        setTimeout(performSNMPScan, 2000);

        // Luego cada 5 minutos
        pollSNMPTimer = setInterval(performSNMPScan, SNMP_SCAN_INTERVAL);
        console.log('SNMP polling iniciado (cada 5 minutos)');
    }

    function pollSNMPStop() {
        if (pollSNMPTimer) {
            clearInterval(pollSNMPTimer);
            pollSNMPTimer = null;
            console.log('SNMP polling detenido');
        }
    }*/

    function pollScanStop(){
        if (pollScanTimer) {
            clearInterval(pollScanTimer);
            pollScanTimer = null;
        }
    }

    function performScanOnce(){
        $.ajax({
            url: SCAN_ENDPOINT,
            method: 'GET',
            dataType: 'json',
            timeout: 20000, // 20 segundos para dar margen
            success: function(resp) {
                if (!resp || !resp.ok) {
                    console.warn('scan_equipos: respuesta inválida', resp);
                    return;
                }
                resp.data.forEach(item => {
                    updateMarkerStatus(item.id, item.estado, item.ultima_deteccion);
                });
            },
            error: function(xhr, status, err) {
                console.error('Error al llamar scan_equipos.php', status, err);
            }
        });
    }

    /**
     * Consulta suministros de impresoras via SNMP
     * Se ejecuta cada 5 minutos (300000ms) para no saturar la red
     */
    function performSNMPScan() {
        // Mostrar indicador de carga
        const btn = $('#btnActualizarSNMP');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<div class="spinner"></div> Consultando...');

        $.ajax({
            url: SNMP_ENDPOINT,
            method: 'GET',
            dataType: 'json',
            timeout: 60000, // 60 segundos
            success: function(resp) {
                if (!resp || !resp.ok) {
                    showAlert('Error al consultar suministros SNMP', 'warning');
                    return;
                }

                console.log('SNMP scan completado:', resp.resumen);

                if (resp.resumen && resp.resumen.actualizadas > 0) {
                    showAlert(`✅ Suministros actualizados: ${resp.resumen.actualizadas} impresoras`, 'success');

                    // Recargar piso actual para mostrar cambios
                    setTimeout(() => {
                        cambiarPiso(
                            CONFIG.CURRENT_FLOOR,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen,
                            FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion
                        );
                    }, 1500);
                } else {
                    showAlert('No se encontraron impresoras para actualizar', 'info');
                }
            },
            error: function(xhr, status, err) {
                console.error('Error en SNMP scan:', status, err);
                showAlert('Error al consultar suministros. Intenta nuevamente.', 'danger');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    }

    // Llamar pollScanStart() cuando la vista esté lista
    $(document).ready(function(){
        pollScanStart();
    });








    // ===== VALIDACIONES CONDICIONALES POR CATEGORÍA =====

    // Categorías que requieren validación de IP/MAC
    const CATEGORIAS_REQUIEREN_NETWORK = [1, 4, 5]; // CPU, Laptop, Impresora

    function categoriaRequiereNetwork(idCategoria) {
        return CATEGORIAS_REQUIEREN_NETWORK.includes(parseInt(idCategoria));
    }

    // **NUEVA FUNCIÓN** - Maneja la visibilidad y obligatoriedad de campos según categoría
    function manejarCamposSegunCategoria(categoriaId, modalPrefix = '') {
        const esNetworkCategory = categoriaRequiereNetwork(categoriaId);

        // Selectores de campos IP y MAC
        const ipField = $(`#ip${modalPrefix}`);
        const macField = $(`#mac${modalPrefix}`);
        const ipContainer = ipField.closest('.col-md-6');
        const macContainer = macField.closest('.col-md-6');

        if (esNetworkCategory) {
            // Mostrar campos y hacerlos obligatorios
            ipContainer.show();
            macContainer.show();
            ipField.prop('required', true);
            macField.prop('required', true);

            // Actualizar etiquetas para mostrar que son obligatorios
            ipContainer.find('label').html('<span class="text-danger">*</span> IP');
            macContainer.find('label').html('<span class="text-danger">*</span> MAC');

            // Restaurar placeholders informativos
            ipField.attr('placeholder', 'Ejemplo: 192.168.1.100');
            macField.attr('placeholder', 'Ejemplo: AA:BB:CC:DD:EE:FF');

            // Limpiar valores por defecto si existen
            if (ipField.val() === '-') ipField.val('');
            if (macField.val() === '-') macField.val('');

        } else {
            // Ocultar campos y quitar obligatoriedad
            ipContainer.hide();
            macContainer.hide();
            ipField.prop('required', false);
            macField.prop('required', false);

            // Establecer valores por defecto (serán enviados como "-")
            ipField.val('-');
            macField.val('-');

            // Limpiar validaciones previas
            limpiarValidacionesCampo(ipField);
            limpiarValidacionesCampo(macField);
        }
    }

    // **NUEVA FUNCIÓN** - Limpia indicadores de validación
    function limpiarValidacionesCampo($input) {
        $input.removeClass('is-invalid is-valid');
        $input.closest('.col-md-6').find('.validation-message').remove();
    }




    // AGREGAR ESTAS FUNCIONES Y MODIFICACIONES AL JAVASCRIPT EXISTENTE

    // Configuración de categorías que requieren validación de network
    const CATEGORIAS_NETWORK = [1, 4, 5]; // CPU, Laptop, Impresora

    // Función para verificar si una categoría requiere validación de network
    function categoriaRequiereNetwork(idCategoria) {
        return CATEGORIAS_NETWORK.includes(parseInt(idCategoria));
    }

    // Función mejorada para validar campo individual con verificación de categoría
    function validarCampoIndividualConCategoria($input, tipo) {
        const valor = $input.val().trim();

        // Obtener la categoría actual del modal correspondiente
        const isModalAnadir = $input.closest('#modalAnadirEquipo').length > 0;
        const categoriaSelect = isModalAnadir ? '#id_categoria_nuevo' : '#id_categoria';
        const idCategoria = parseInt($(categoriaSelect).val()) || 0;

        // Si no hay valor, limpiar indicador
        if (!valor) {
            mostrarIndicadorValidacionEnLinea($input, 'clear');
            return;
        }

        // Si la categoría no requiere network, omitir validación para IP/MAC
        if (idCategoria > 0 && !categoriaRequiereNetwork(idCategoria) && (tipo === 'ip' || tipo === 'mac')) {
            mostrarIndicadorValidacionEnLinea($input, 'success', 'Validación no requerida para esta categoría');
            return;
        }

        // Validar formato primero
        let formatoValido = true;
        let mensajeFormato = '';

        if (tipo === 'ip') {
            formatoValido = validarFormatoIP(valor);
            mensajeFormato = 'Formato de IP inválido';
        } else if (tipo === 'mac') {
            formatoValido = validarFormatoMAC(valor);
            mensajeFormato = 'Formato de MAC inválido (AA:BB:CC:DD:EE:FF)';
        }

        if (!formatoValido) {
            mostrarIndicadorValidacionEnLinea($input, 'warning', mensajeFormato);
            return;
        }

        // Mostrar loading
        mostrarIndicadorValidacionEnLinea($input, 'loading', 'Verificando disponibilidad...');

        // Obtener ID del equipo actual (para edición)
        const excluir_id = $('#id_ubicacion_equipos').val() || null;

        // Preparar datos para validación
        let datosValidacion = {
            ip: '',
            mac: '',
            id_bien: '',
            id_categoria: idCategoria,
            excluir_id: excluir_id
        };
        datosValidacion[tipo] = valor;

        // Validar después de un delay
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            validarDuplicados(datosValidacion.ip, datosValidacion.mac, datosValidacion.id_bien, excluir_id)
                .then(response => {
                    if (response.success) {
                        mostrarIndicadorValidacionEnLinea($input, 'success', 'Disponible');
                    } else if (response.errors && response.errors.length > 0) {
                        const mensaje = response.errors.join(', ');
                        mostrarIndicadorValidacionEnLinea($input, 'error', mensaje);
                    }
                })
                .catch(error => {
                    console.error('Error en validación:', error);
                    mostrarIndicadorValidacionEnLinea($input, 'error', 'Error al verificar disponibilidad');
                });
        }, 800);
    }

    // Función para mostrar/ocultar campos según la categoría seleccionada
    function toggleCamposNetwork(idCategoria) {
        const requiereNetwork = categoriaRequiereNetwork(idCategoria);
        const esImpresora = (parseInt(idCategoria) === 5); // NUEVO

        // Para modal añadir
        const $ipNuevo = $('#ip_nuevo').closest('.col-md-6');
        const $macNuevo = $('#mac_nuevo').closest('.col-md-6');

        // Para modal editar
        const $ip = $('#ip_ubicacion_equipos').closest('.col-md-6');
        const $mac = $('#mac_ubicacion_equipos').closest('.col-md-6');

        if (requiereNetwork) {
            // Mostrar campos y marcarlos como requeridos
            $ipNuevo.show();
            $macNuevo.show();
            $ip.show();
            $mac.show();

            // Agregar asteriscos rojos para campos requeridos
            $ipNuevo.find('label').html('<span class="text-danger">*</span> IP');
            $macNuevo.find('label').html('<span class="text-danger">*</span> MAC');
            $ip.find('label').html('<span class="text-danger">*</span> IP');
            $mac.find('label').html('<span class="text-danger">*</span> MAC');

            // Hacer campos requeridos
            $('#ip_nuevo, #ip_ubicacion_equipos').prop('required', true);
            $('#mac_nuevo, #mac_ubicacion_equipos').prop('required', true);

        } else {
            // Ocultar campos para categorías que no requieren network
            $ipNuevo.hide();
            $macNuevo.hide();
            $ip.hide();
            $mac.hide();

            // Remover requerimientos
            $('#ip_nuevo, #ip_ubicacion_equipos').prop('required', false);
            $('#mac_nuevo, #mac_ubicacion_equipos').prop('required', false);

            // Limpiar valores para que se asignen por defecto
            $('#ip_nuevo, #ip_ubicacion_equipos').val('');
            $('#mac_nuevo, #mac_ubicacion_equipos').val('');

            // Limpiar indicadores de validación
            $('.validation-indicator').remove();
        }

        // NUEVO: Mostrar/ocultar campos de suministros para impresoras
        // Detectar si estamos en modal editar o añadir
        const isModalEditar = $('#modalEditarEquipo').hasClass('show');
        const sufijo = isModalEditar ? '-editar' : '-nuevo';

        if (esImpresora) {
            $(`#seccion-suministros${sufijo === '-editar' ? '' : sufijo}, #campo-toner${sufijo}, #campo-kit${sufijo}, #campo-unidad${sufijo}`).show();
        } else {
            $(`#seccion-suministros${sufijo === '-editar' ? '' : sufijo}, #campo-toner${sufijo}, #campo-kit${sufijo}, #campo-unidad${sufijo}`).hide();
        }
    }

    // Función para mostrar alertas dentro del modal activo
    function showModalAlert(message, type, modalId = null) {
        // Determinar qué modal está activo
        let activeModal = modalId;
        if (!activeModal) {
            if ($('#modalAnadirEquipo').hasClass('show')) {
                activeModal = '#modalAnadirEquipo';
            } else if ($('#modalEditarEquipo').hasClass('show')) {
                activeModal = '#modalEditarEquipo';
            }
        }

        if (!activeModal) {
            // Si no hay modal activo, usar la función original
            showAlert(message, type);
            return;
        }

        const alertId = 'modalAlert_' + Date.now();
        const iconClass = getAlertIcon(type);

        const alertHtml = `
            <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-${iconClass}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Insertar al inicio del modal-body
        const modalBody = $(activeModal + ' .modal-body');

        // Remover alertas anteriores para evitar acumulación
        modalBody.find('.alert').remove();

        // Agregar nueva alerta
        modalBody.prepend(alertHtml);

        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            $('#' + alertId).fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Función mejorada para mostrar indicadores de validación en línea
    function mostrarIndicadorValidacionEnLinea($input, tipo, mensaje = '') {
        const $parent = $input.closest('.col-md-6');
        const indicadorId = $input.attr('id') + '_inline_indicator';

        // Remover indicador anterior
        $parent.find('.validation-message').remove();

        // Remover clases de estado anteriores
        $input.removeClass('is-invalid is-valid');

        if (tipo === 'clear') {
            return;
        }

        let iconClass, textClass, inputClass;

        switch(tipo) {
            case 'loading':
                iconClass = 'fas fa-spinner fa-spin';
                textClass = 'text-info';
                inputClass = '';
                break;
            case 'success':
                iconClass = 'fas fa-check';
                textClass = 'text-success';
                inputClass = 'is-valid';
                break;
            case 'error':
                iconClass = 'fas fa-exclamation-triangle';
                textClass = 'text-danger';
                inputClass = 'is-invalid';
                break;
            case 'warning':
                iconClass = 'fas fa-exclamation-circle';
                textClass = 'text-warning';
                inputClass = '';
                break;
            default:
                return;
        }

        // Agregar clase al input
        if (inputClass) {
            $input.addClass(inputClass);
        }

        // Crear mensaje de validación
        const validationMessage = `
            <div class="validation-message ${textClass}" id="${indicadorId}">
                <small>
                    <i class="${iconClass}"></i>
                    ${mensaje}
                </small>
            </div>
        `;

        // Agregar después del input
        $input.after(validationMessage);

        // Auto-ocultar indicadores de éxito después de 3 segundos
        if (tipo === 'success') {
            setTimeout(() => {
                $('#' + indicadorId).fadeOut(300);
            }, 3000);
        }
    }

    // Función para limpiar todas las alertas del modal
    function limpiarAlertasModal(modalId) {
        $(modalId + ' .modal-body .alert').remove();
    }

    // Modificar el submit del formulario de añadir equipo
    $('#formAnadirEquipo').off('submit').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const formData = {};

        // Limpiar alertas anteriores
        limpiarAlertasModal('#modalAnadirEquipo');

        // Recopilar datos del formulario
        $form.serializeArray().forEach(field => {
            formData[field.name] = field.value;
        });

        const submitBtn = $form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Validar formulario completo antes de enviar
        validarFormularioCompleto(formData)
            .then(validationResult => {
                console.log('Resultado validación añadir:', validationResult); // DEBUG

                if (!validationResult.success) {
                    const errores = validationResult.errors.join(', ');
                    showModalAlert('Error de validación: ' + errores, 'danger', '#modalAnadirEquipo');
                    return; // DETENER EJECUCIÓN - NO ENVIAR AL SERVIDOR
                }

                // Solo si la validación es exitosa, enviar al servidor
                // Deshabilitar botón y mostrar loading
                submitBtn.prop('disabled', true).html('<div class="spinner"></div>Guardando...');

                // Enviar datos al servidor
                $.ajax({
                    url: '../LN/ln_anadir_equipo.php',
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log('Respuesta servidor añadir:', response); // DEBUG

                        if (response && response.success) {
                            showModalAlert('Equipo agregado correctamente', 'success', '#modalAnadirEquipo');

                            // Cerrar modal después de un delay
                            setTimeout(() => {
                                $('#modalAnadirEquipo').modal('hide');

                                // Recargar el piso actual
                                setTimeout(() => {
                                    cambiarPiso(
                                        CONFIG.CURRENT_FLOOR,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].nombre,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].imagen,
                                        FLOOR_CONFIG[CONFIG.CURRENT_FLOOR].descripcion
                                    );
                                }, 300);
                            }, 1500);
                        } else {
                            const tipoError = response.type || 'unknown';
                            let mensaje = response.message || 'Error desconocido';

                            if (tipoError === 'duplicate') {
                                mensaje = 'Datos duplicados: ' + mensaje;
                            }

                            showModalAlert('Error: ' + mensaje, 'danger', '#modalAnadirEquipo');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error añadiendo equipo:', { xhr, status, error });
                        let errorMsg = 'Error de conexión al añadir equipo';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        showModalAlert(errorMsg, 'danger', '#modalAnadirEquipo');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            })
            .catch(error => {
                console.error('Error en validación:', error);
                showModalAlert('Error al validar los datos', 'danger', '#modalAnadirEquipo');
            });
    });

    // Event listener para abrir modal
    $('#btnVerRegistros').on('click', function() {
        abrirModalVerRegistros();
    });

    // Función para abrir el modal y cargar registros
    function abrirModalVerRegistros() {
        $('#modalVerRegistros').modal('show');
        cargarRegistrosEquipos();
    }

    // Función para cargar registros desde el servidor
    function cargarRegistrosEquipos(filtros = {}) {
        $('#loadingRegistros').show();
        $('#registrosContainer').hide();
        $('#noRegistros').hide();

        $.ajax({
            url: '../LN/ln_listar_registros_equipos.php',
            method: 'POST',
            data: filtros,
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    mostrarRegistrosEnCards(response.registros);
                    $('#totalRegistros').text(`${response.registros.length} registros`);
                } else {
                    mostrarMensajeError('Error al cargar registros');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error cargando registros:', error);
                mostrarMensajeError('Error de conexión');
            },
            complete: function() {
                $('#loadingRegistros').hide();
            }
        });
    }

    // Función para mostrar registros en formato de cards
    function mostrarRegistrosEnCards(registros) {
        const container = $('#registrosContainer');
        container.empty();

        if (!registros || registros.length === 0) {
            $('#noRegistros').show();
            return;
        }

        registros.forEach(registro => {
            const card = crearCardRegistro(registro);
            container.append(card);
        });

        container.show();
    }

    // Función para crear una card individual
    function crearCardRegistro(reg) {
        // Determinar clase de piso
        const pisoClass = `piso-${reg.piso || 1}`;

        // Información de suministros (solo para impresoras)
        let suministrosHTML = '';
        if (reg.id_categoria == 5) { // Si es impresora
            suministrosHTML = `
            <div class="suministros-section">
                <strong style="color: #ffffff;">📊 Suministros:</strong><br>
                ${crearNivelSuministro('Toner', reg.nivel_toner)}
                ${crearNivelSuministro('Kit Mant.', reg.nivel_kit_mantenimiento)}
                ${crearNivelSuministro('Unidad Img.', reg.nivel_unidad_imagen)}
                ${reg.ultima_lectura_suministros ?
                `<div class="ultima-lectura">
                        <i class="fas fa-clock"></i> Última lectura: ${reg.ultima_lectura_suministros}
                    </div>` : ''}
            </div>
        `;
        }

        return $(`
        <div class="col-md-6 col-lg-4">
            <div class="registro-card">
                <div class="registro-card-header">
                    <span class="registro-ip">
                        <i class="fas fa-network-wired"></i>
                        ${reg.ip_ubicacion_equipos || 'Sin IP'}
                    </span>
                    <span class="registro-piso-badge ${pisoClass}">
                        Piso ${reg.piso || 'N/A'}
                    </span>
                </div>

                <div class="registro-info">
                    <strong>Categoría:</strong> ${reg.categoria || 'N/A'}
                </div>

                <div class="registro-info">
                    <strong>Bien:</strong> ${reg.bien || 'No asignado'}
                </div>

                <div class="registro-info">
                    <strong>Persona:</strong> ${reg.persona || 'Sin asignar'}
                </div>

                <div class="registro-info">
                    <strong>Área:</strong> ${reg.area || 'Sin área'}
                </div>

                ${suministrosHTML}
            </div>
        </div>
    `);
    }

    // Función para crear indicador de nivel de suministro
    function crearNivelSuministro(nombre, nivel) {
        if (nivel === null || nivel === undefined || nivel === '') {
            return `<span class="nivel-suministro nivel-na">${nombre}: N/A</span>`;
        }

        const nivelNum = parseInt(nivel);
        let claseNivel = 'nivel-alto';

        if (nivelNum < 15) {
            claseNivel = 'nivel-critico';
        } else if (nivelNum < 30) {
            claseNivel = 'nivel-bajo';
        } else if (nivelNum < 50) {
            claseNivel = 'nivel-medio';
        }

        return `<span class="nivel-suministro ${claseNivel}">${nombre}: ${nivelNum}%</span>`;
    }

    // Función para mostrar mensaje de error
    function mostrarMensajeError(mensaje) {
        $('#noRegistros').html(`
        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
        <p class="text-danger">${mensaje}</p>
    `).show();
    }

    // Event listener para filtro de búsqueda
    $('#filtroRegistros').on('keyup', function() {
        const filtro = $(this).val().toLowerCase();
        filtrarCardsLocalmente(filtro);
    });

    // Event listener para filtro de piso
    $('#filtroPisoRegistros').on('change', function() {
        const piso = $(this).val();

        if (piso) {
            $('.registro-card').parent().hide();
            $(`.registro-piso-badge.piso-${piso}`).closest('.col-md-6').show();
        } else {
            $('.registro-card').parent().show();
        }

        actualizarContadorVisible();
    });

    // Event listener para refrescar
    $('#btnRefrescarRegistros').on('click', function() {
        $('#filtroRegistros').val('');
        $('#filtroPisoRegistros').val('');
        cargarRegistrosEquipos();
    });

    // Función para filtrar cards localmente
    function filtrarCardsLocalmente(filtro) {
        $('.registro-card').each(function() {
            const texto = $(this).text().toLowerCase();
            const coincide = texto.includes(filtro);
            $(this).parent().toggle(coincide);
        });

        actualizarContadorVisible();
    }

    // Función para actualizar contador de registros visibles
    function actualizarContadorVisible() {
        const visibles = $('.registro-card:visible').length;
        $('#totalRegistros').text(`${visibles} registros`);

        if (visibles === 0) {
            $('#noRegistros').show();
        } else {
            $('#noRegistros').hide();
        }
    }
</script>

</body>
</html>
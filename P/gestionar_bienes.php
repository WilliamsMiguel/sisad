<?php
// Obtener la lista de bienes y sus detalles desde la capa LN
session_start();
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_verbienes.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienes Registrados</title>

    <link href="../libreria/bootstrap.min.css" rel="stylesheet">
    <link href="../libreria/select2.min.css" rel="stylesheet"/>
    <script src="../libreria/jquery-3.6.0.min.js"></script>
    <script src="../libreria/select2.min.js"></script>
    <script src="../libreria/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../libreria/fontawesome/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
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

        /* Grid sutil de fondo - versión ligera */
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

        /* Contenedor de cards */
        .cards-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--shadow-subtle);
            position: relative;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            padding: 0;
        }

        /* Estilos de las cards */
        .bien-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .bien-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(185, 28, 28, 0.15);
            border-color: rgba(185, 28, 28, 0.3);
            background: rgba(185, 28, 28, 0.05);
        }

        /* Header de la card */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--dark-bg), var(--card-bg));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-id {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-weight: 700;
            font-size: 1rem;
        }

        .card-id i {
            color: var(--accent-red);
        }

        .card-status {
            display: flex;
            align-items: center;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid transparent;
        }

        .status-bueno {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success-green);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .status-regular {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning-orange);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .status-malo {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger-red);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .status-baja {
            background: rgba(107, 114, 128, 0.2);
            color: #9ca3af;
            border-color: rgba(107, 114, 128, 0.3);
        }

        /* Cuerpo de la card */
        .card-body {
            padding: 20px;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-red);
        }

        .card-title i {
            color: var(--accent-red);
            font-size: 1.2rem;
        }

        .card-title h4 {
            color: var(--text-light);
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            max-width: 200px;
        }

        .card-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .detail-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
            min-width: 80px;
        }

        .detail-label i {
            color: var(--accent-red);
            font-size: 0.8rem;
            width: 12px;
        }

        .detail-value {
            color: var(--text-gray);
            font-weight: 500;
            font-size: 0.9rem;
            text-align: right;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            max-width: 150px;
        }

        /* Footer de la card */
        .card-footer {
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.02);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .action-btn {
            border: none;
            border-radius: 8px;
            padding: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .action-btn.btn-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .action-btn.btn-success:hover {
            background: rgba(16, 185, 129, 0.2);
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .action-btn.btn-primary {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .action-btn.btn-primary:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .action-btn.btn-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-orange);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .action-btn.btn-warning:hover {
            background: rgba(245, 158, 11, 0.2);
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        }

        .action-btn.btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-red);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .action-btn.btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        /* Responsive para cards */
        @media (max-width: 1200px) {
            .cards-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 18px;
            }
        }

        @media (max-width: 768px) {
            .cards-container {
                padding: 15px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .bien-card {
                margin: 0;
            }

            .card-header, .card-body, .card-footer {
                padding: 15px;
            }

            .card-title h4 {
                font-size: 1rem;
                max-width: 180px;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                padding: 6px 0;
            }

            .detail-value {
                text-align: left;
                max-width: 100%;
            }

            .action-buttons {
                gap: 12px;
            }

            .action-btn {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .cards-container {
                padding: 10px;
                border-radius: 15px;
            }

            .cards-grid {
                gap: 12px;
            }

            .card-header, .card-body, .card-footer {
                padding: 12px;
            }

            .card-title {
                margin-bottom: 15px;
            }

            .detail-group {
                gap: 6px;
            }

            .action-buttons {
                gap: 10px;
            }
        }

        /* Botones de acción modernos */
        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        }

        .btn-outline-success:hover {
            background: rgba(16, 185, 129, 0.2);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px) scale(1.05);
        }

        .btn-outline-primary {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
        }

        .btn-outline-primary:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px) scale(1.05);
        }

        .btn-outline-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-orange);
            border: 1px solid rgba(245, 158, 11, 0.3);
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.2);
        }

        .btn-outline-warning:hover {
            background: rgba(245, 158, 11, 0.2);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
            transform: translateY(-2px) scale(1.05);
        }

        .btn-outline-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-red);
            border: 1px solid rgba(239, 68, 68, 0.3);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }

        .btn-outline-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px) scale(1.05);
        }

        /* Modales modernos */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(20px);
        }

        .modal-content {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.98), rgba(42, 42, 42, 0.95));
            backdrop-filter: blur(30px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--shadow-subtle);
            overflow: hidden;
            position: relative;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border-bottom: 1px solid rgba(185, 28, 28, 0.3);
            position: relative;
            z-index: 2;
        }

        .modal-title {
            color: white;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .modal-body {
            background: rgba(30, 41, 59, 0.8);
            color: var(--text-gray);
            position: relative;
            z-index: 2;
        }

        .form-control, .form-select {
            background: rgba(42, 42, 42, 0.8);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-gray);
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(42, 42, 42, 0.95);
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.2);
            color: var(--text-light);
        }

        .form-control:disabled {
            background: rgba(75, 85, 99, 0.3);
            color: var(--text-muted);
        }

        .form-label {
            color: var(--text-gray);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Loading spinner simple */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(185, 28, 28, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .loading-spinner {
            width: 24px;
            height: 24px;
            border: 3px solid rgba(185, 28, 28, 0.3);
            border-top: 3px solid var(--primary-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 20px rgba(185, 28, 28, 0.5);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estados mejorados */
        .bg-success {
            background: linear-gradient(135deg, var(--success-green), #059669) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red)) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, var(--warning-orange), #d97706) !important;
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

        /* Focus states mejorados */
        .search-input:focus,
        .btn:focus {
            outline: 2px solid var(--primary-red);
            outline-offset: 2px;
        }

        /* Select2 personalizado moderno */
        .select2-container {
            z-index: 9999 !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
            border: 2px solid rgba(148, 163, 184, 0.2) !important;
            border-radius: 12px !important;
            background: rgba(42, 42, 42, 0.8) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            backdrop-filter: blur(10px) !important;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--open .select2-selection--single {
            border-color: var(--primary-red) !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.2) !important;
            background: rgba(42, 42, 42, 0.95) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-gray) !important;
            line-height: 44px !important;
            padding-left: 16px !important;
            padding-right: 40px !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 12px !important;
            width: 20px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
            border-width: 6px 5px 0 5px !important;
            margin-top: -3px !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent var(--primary-red) transparent !important;
            border-width: 0 5px 6px 5px !important;
            margin-top: -9px !important;
        }

        /* Dropdown mejorado */
        .select2-dropdown {
            background: rgba(30, 41, 59, 0.98) !important;
            border: 2px solid rgba(185, 28, 28, 0.3) !important;
            border-radius: 12px !important;
            backdrop-filter: blur(20px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(185, 28, 28, 0.1) !important;
            margin-top: 4px !important;
            z-index: 99999 !important;
        }

        .select2-search--dropdown {
            padding: 12px !important;
            background: transparent !important;
        }

        .select2-search--dropdown .select2-search__field {
            background: rgba(42, 42, 42, 0.8) !important;
            border: 2px solid rgba(148, 163, 184, 0.2) !important;
            border-radius: 10px !important;
            color: var(--text-light) !important;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--primary-red) !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.2) !important;
            background: rgba(42, 42, 42, 0.95) !important;
            outline: none !important;
        }

        .select2-search--dropdown .select2-search__field::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .select2-results {
            max-height: 280px !important;
            padding: 4px !important;
        }

        .select2-results__options {
            max-height: 260px !important;
        }

        .select2-results__option {
            background: transparent !important;
            color: var(--text-gray) !important;
            padding: 12px 16px !important;
            border-radius: 8px !important;
            margin: 2px 0 !important;
            font-weight: 500 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer !important;
        }

        .select2-results__option:hover,
        .select2-results__option--highlighted {
            background: rgba(185, 28, 28, 0.15) !important;
            color: var(--text-light) !important;
            transform: translateX(4px) !important;
        }

        .select2-results__option--selected {
            background: rgba(185, 28, 28, 0.25) !important;
            color: var(--text-light) !important;
            font-weight: 600 !important;
        }

        .select2-results__option--selected:hover {
            background: rgba(185, 28, 28, 0.35) !important;
        }

        /* Estados especiales */
        .select2-results__message {
            color: var(--text-muted) !important;
            padding: 16px !important;
            text-align: center !important;
            font-style: italic !important;
        }

        /* Animaciones */
        .select2-dropdown {
            animation: dropdownFadeIn 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Estilos para el botón de exportar */
        .export-section {
            margin-top: 30px;
            text-align: center;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
            border: 1px solid rgba(16, 185, 129, 0.3);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .export-btn:hover {
            background: linear-gradient(135deg, #047857, #059669);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);
            color: white;
            text-decoration: none;
        }

        .export-btn:focus {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        .export-btn i {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Efecto de pulso */
        .pulse-effect {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
            }
            50% {
                box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4), 0 0 20px rgba(16, 185, 129, 0.3);
            }
        }

        /* Responsive para el botón de exportar */
        @media (max-width: 768px) {
            .export-btn {
                padding: 14px 24px;
                font-size: 0.9rem;
            }

            .export-section {
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .export-btn {
                padding: 12px 20px;
                font-size: 0.85rem;
                gap: 8px;
            }

            .export-btn i {
                font-size: 1rem;
            }
        }

        /* Contenedor de botones */
        .export-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Botón de subir Excel */
        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.25);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .upload-btn:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.4);
        }

        .upload-btn:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .upload-btn i {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Responsive para botones */
        @media (max-width: 768px) {
            .export-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .upload-btn {
                padding: 14px 24px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .upload-btn {
                padding: 12px 20px;
                font-size: 0.85rem;
                gap: 8px;
            }

            .upload-btn i {
                font-size: 1rem;
            }
        }

        /* Estilos para secciones de modales mejorados */
        .modal-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(148, 163, 184, 0.15);
            backdrop-filter: blur(10px);
        }

        .modal-section h6 {
            color: var(--text-light);
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary-red);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-section h6 i {
            color: var(--accent-red);
            font-size: 1.1rem;
        }

        .field-group {
            background: rgba(42, 42, 42, 0.4);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        .field-group .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /* Campos especiales */
        .highlight-field {
            background: linear-gradient(135deg, rgba(185, 28, 28, 0.1), rgba(185, 28, 28, 0.05));
            border: 1px solid rgba(185, 28, 28, 0.2);
        }

        .optional-field {
            opacity: 0.9;
        }

        /* Responsive para modales grandes */
        @media (min-width: 1400px) {
            .modal-dialog {
                max-width: 1400px !important;
                width: 95vw !important;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .modal-dialog {
                max-width: 1200px !important;
                width: 90vw !important;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .modal-dialog {
                max-width: 95% !important;
            }
        }

        @media (max-width: 767px) {
            .modal-section {
                padding: 15px;
                margin-bottom: 15px;
            }

            .field-group {
                padding: 12px;
            }
        }

        /* Indicador de resultados de búsqueda */
        .search-results {
            margin-top: 8px;
            padding: 8px 16px;
            background: rgba(185, 28, 28, 0.1);
            border: 1px solid rgba(185, 28, 28, 0.2);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Estilos para el botón de cerrar del modal */
        .modal-header .btn-close {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            width: 32px;
            height: 32px;
            opacity: 0.8;
            transition: all 0.3s ease;
            position: relative;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .modal-header .btn-close:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .modal-header .btn-close:focus {
            outline: 2px solid rgba(255, 255, 255, 0.5);
            outline-offset: 2px;
        }

        /* Personalizar la X del botón de cerrar */
        .modal-header .btn-close::before {
            content: '×';
            font-size: 20px;
            font-weight: 700;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            line-height: 1;
        }

        .modal-header .btn-close:hover::before {
            color: #ffffff;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
        }

        /* Variante para modales con fondo claro si los tienes */
        .modal-header.bg-light .btn-close,
        .modal-header.bg-white .btn-close {
            background: rgba(0, 0, 0, 0.1);
            border-color: rgba(0, 0, 0, 0.2);
        }

        .modal-header.bg-light .btn-close::before,
        .modal-header.bg-white .btn-close::before {
            color: #000;
        }

        .modal-header.bg-light .btn-close:hover,
        .modal-header.bg-white .btn-close:hover {
            background: rgba(0, 0, 0, 0.15);
            border-color: rgba(0, 0, 0, 0.3);
        }

        /* Modal Nuevo PC Asignada - Diseño compacto */
        #modalNuevoPcasignada .modal-content {
            border: 2px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
            border-radius: 12px;
        }

        #modalNuevoPcasignada .modal-header {
            background: linear-gradient(135deg, #059669, #10b981) !important;
            border-bottom: 2px solid rgba(16, 185, 129, 0.3);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0;
        }

        #modalNuevoPcasignada .modal-title {
            font-size: 1.2rem;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        #modalNuevoPcasignada .modal-body {
            padding: 20px;
            background: rgba(16, 185, 129, 0.02);
        }

        #modalNuevoPcasignada .form-group-custom {
            margin-bottom: 0;
        }

        #modalNuevoPcasignada .form-control {
            border: 2px solid rgba(16, 185, 129, 0.2);
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        #modalNuevoPcasignada .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        #modalNuevoPcasignada .form-label {
            color: #10b981;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        #modalNuevoPcasignada .modal-footer {
            background: rgba(16, 185, 129, 0.05);
            border-top: 1px solid rgba(16, 185, 129, 0.2);
            gap: 10px;
            display: flex;              /* activa flexbox */
            justify-content: center;    /* centra horizontalmente */
            align-items: center;        /* centra verticalmente */
        }


        #modalNuevoPcasignada .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        #modalNuevoPcasignada .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            border: none;
            font-weight: 600;
            padding: 12px 24px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        #modalNuevoPcasignada .btn-success:hover {
            background: linear-gradient(135deg, #047857, #059669);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        #modalNuevoPcasignada .btn-success:disabled {
            background: #6b7280;
            box-shadow: none;
            transform: none;
        }

        /* Mensajes de validación específicos */
        #modalNuevoPcasignada #validacion_mensaje {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid transparent;
        }

        #modalNuevoPcasignada .text-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
        }

        #modalNuevoPcasignada .text-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
        }

        #modalNuevoPcasignada .text-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* Responsive para pantallas pequeñas */
        @media (max-width: 576px) {
            #modalNuevoPcasignada .modal-dialog {
                max-width: 95vw !important;
                margin: 1rem auto !important;
            }

            #modalNuevoPcasignada .modal-header,
            #modalNuevoPcasignada .modal-body,
            #modalNuevoPcasignada .modal-footer {
                padding: 15px;
            }

            #modalNuevoPcasignada .btn {
                padding: 10px 14px;
                font-size: 0.85rem;
            }
        }

        #modalNuevoPcasignada .modal-dialog {
            max-width: 400px !important;
            width: 85vw !important;
        }

        /* === SISTEMA DE FILTROS DINÁMICOS === */

        /* Contenedor principal de filtros */
        .filters-section {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-subtle);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        .filters-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 16px 16px 0 0;
        }

        .filters-section:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
        }

        /* Header de los filtros */
        .filters-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .filters-title {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .filters-title i {
            color: var(--accent-red);
            font-size: 1.2rem;
        }

        .filters-toggle {
            background: rgba(185, 28, 28, 0.1);
            border: 1px solid rgba(185, 28, 28, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--accent-red);
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filters-toggle:hover {
            background: rgba(185, 28, 28, 0.15);
            color: var(--light-red);
            transform: scale(1.02);
        }

        /* Contenedor de filtros colapsible */
        .filters-content {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .filters-content.collapsed {
            height: 0 !important;
            opacity: 0;
            padding: 0;
            margin: 0;
        }

        /* Grid de filtros */
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Grupo de filtro individual */
        .filter-group {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .filter-group:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(185, 28, 28, 0.2);
            transform: translateY(-2px);
        }

        .filter-group::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-red), transparent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .filter-group:hover::before {
            transform: scaleX(1);
        }

        /* Etiqueta del filtro */
        .filter-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .filter-label i {
            color: var(--accent-red);
            font-size: 0.9rem;
            width: 14px;
        }

        /* Select personalizado */
        .filter-select {
            width: 100%;
            background: rgba(42, 42, 42, 0.6);
            border: 1.5px solid rgba(148, 163, 184, 0.2);
            border-radius: 10px;
            color: var(--text-light);
            padding: 10px 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent-red);
            background: rgba(42, 42, 42, 0.8);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        .filter-select:hover {
            border-color: rgba(185, 28, 28, 0.4);
        }

        /* Opciones del select */
        .filter-select option {
            background: var(--dark-bg);
            color: var(--text-light);
            padding: 8px;
        }

        /* Botones de acción de filtros */
        .filters-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Contador de resultados */
        .results-counter {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .results-counter i {
            color: var(--accent-red);
        }

        .results-number {
            color: var(--light-red);
            font-weight: 700;
            font-size: 1rem;
        }

        /* Botones de control */
        .filter-controls {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn-clear {
            background: rgba(107, 114, 128, 0.1);
            color: #9ca3af;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        .filter-btn-clear:hover {
            background: rgba(107, 114, 128, 0.2);
            color: #d1d5db;
            transform: translateY(-1px);
        }

        .filter-btn-apply {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .filter-btn-apply:hover {
            background: rgba(16, 185, 129, 0.2);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Estados activos */
        .filter-group.active {
            background: rgba(185, 28, 28, 0.05);
            border-color: rgba(185, 28, 28, 0.2);
        }

        .filter-group.active::before {
            transform: scaleX(1);
        }

        .filter-select.active {
            border-color: var(--accent-red);
            background: rgba(185, 28, 28, 0.05);
        }

        /* Indicador de filtros activos */
        .active-filters-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-red);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Estados de filtrado */
        .bien-card.filtered-out {
            display: none;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            display: none;
        }

        .no-results i {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-results h3 {
            color: var(--text-light);
            margin-bottom: 10px;
        }

        /* Animaciones */
        .filter-group {
            animation: filterSlideIn 0.3s ease;
        }

        @keyframes filterSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive para filtros */
        @media (max-width: 1200px) {
            .filters-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .filters-section {
                padding: 20px 15px;
            }

            .filters-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .filters-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .filters-actions {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }

            .filter-controls {
                justify-content: center;
            }

            .filter-group {
                padding: 12px;
            }

            .filter-btn {
                padding: 10px 14px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }

            .filter-controls {
                flex-direction: column;
            }

            .filter-btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Header moderno -->
    <div class="modern-header">
        <h1 class="header-title">
            <i class="fas fa-desktop"></i>
            Bienes Registrados
        </h1>
        <p class="header-subtitle">Sistema de gestión y control de equipos informáticos</p>
    </div>

    <!-- === NUEVA SECCIÓN DE FILTROS === -->
    <div class="filters-section" id="filtersSection">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                Filtros Avanzados
            </h3>
            <button class="filters-toggle" id="toggleFilters">
                <i class="fas fa-eye"></i>
                <span>Ocultar</span>
            </button>
        </div>

        <div class="filters-content" id="filtersContent">
            <div class="filters-grid">
                <!-- Filtro por Categoría/Equipo -->
                <!-- Filtro por Categoría/Equipo -->
                <div class="filter-group" id="filterEquipo">
                    <div class="filter-label">
                        <i class="fas fa-desktop"></i>
                        <span>Categoría</span>
                    </div>
                    <select class="filter-select" id="selectEquipo">
                        <option value="">Todas las categorías</option>
                        <!-- Se carga dinámicamente via JavaScript -->
                    </select>
                </div>

                <!-- Filtro por Año -->
                <div class="filter-group" id="filterAno">
                    <div class="filter-label">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Año</span>
                    </div>
                    <select class="filter-select" id="selectAno">
                        <option value="">Todos los años</option>
                        <!-- Se carga dinámicamente via JavaScript -->
                    </select>
                </div>

                <!-- Filtro por Estado -->
                <div class="filter-group" id="filterEstado">
                    <div class="filter-label">
                        <i class="fas fa-check-circle"></i>
                        <span>Estado</span>
                    </div>
                    <select class="filter-select" id="selectEstado">
                        <option value="">Todos los estados</option>
                        <!-- Se carga dinámicamente via JavaScript -->
                    </select>
                </div>

                <!-- Filtro por Marca -->
                <div class="filter-group" id="filterMarca">
                    <div class="filter-label">
                        <i class="fas fa-tag"></i>
                        <span>Marca</span>
                    </div>
                    <select class="filter-select" id="selectMarca">
                        <option value="">Todas las marcas</option>
                        <!-- Se carga dinámicamente via JavaScript -->
                    </select>
                </div>
            </div>

            <div class="filters-actions">
                <div class="results-counter">
                    <i class="fas fa-list"></i>
                    <span>Mostrando:</span>
                    <span class="results-number" id="resultsCount">0</span>
                    <span>de 0 bienes</span>
                </div>

                <div class="filter-controls">
                    <button class="filter-btn filter-btn-clear" id="clearFilters">
                        <i class="fas fa-eraser"></i>
                        Limpiar
                    </button>
                    <button class="filter-btn filter-btn-apply" id="applyFilters">
                        <i class="fas fa-search"></i>
                        Aplicar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de controles -->
    <div class="controls-section">
        <div class="search-container">
            <input type="text" id="buscarBien" class="search-input" placeholder="Buscar bienes por cualquier campo...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="search-info">
            <i class="fas fa-info-circle"></i> Busca por ID, equipo, marca, modelo, serie, estado, etc.
            <div class="search-results" id="searchResults" style="display: none;">
                <span id="searchResultsCount"></span> resultado(s) encontrado(s)
            </div>
        </div>
    </div>



    <!-- Contenedor de tabla -->
    <!-- Contenedor de cards -->
    <div class="cards-container" id="bienesCards">
        <div class="cards-grid" id="listabienes">
            <?php foreach ($bienesActualVer as $mov): ?>
                <div class="bien-card"
                     data-id="<?php echo $mov['id_bien']; ?>"
                     data-equipo="<?php echo htmlspecialchars($mov['nombre_equipo']); ?>"
                     data-ano="<?php echo htmlspecialchars($mov['añodeadqs_bien']); ?>"
                     data-estado="<?php echo htmlspecialchars($mov['estado_bien']); ?>"
                     data-marca="<?php echo htmlspecialchars($mov['marca_bien']); ?>">
                    <!-- Header de la card -->
                    <div class="card-header">
                        <div class="card-id">
                            <i class="fas fa-hashtag"></i>
                            <span><?php echo $mov['id_bien']; ?></span>
                        </div>
                        <div class="card-status">
                        <span class="status-badge status-<?php echo strtolower($mov['estado_bien']); ?>">
                            <?php echo htmlspecialchars($mov['estado_bien']); ?>
                        </span>
                        </div>
                    </div>

                    <!-- Contenido principal -->
                    <div class="card-body">
                        <div class="card-title">
                            <i class="fas fa-laptop"></i>
                            <h4><?php echo htmlspecialchars($mov['nombre_equipo']); ?></h4>
                        </div>

                        <div class="card-details">
                            <div class="detail-group">
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-tag"></i> Marca
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['marca_bien']); ?></span>
                                </div>
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-cube"></i> Modelo
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['modelo_bien']); ?></span>
                                </div>
                            </div>

                            <div class="detail-group">
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-barcode"></i> N° Serie
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['numdeserie_bien']); ?></span>
                                </div>
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-hashtag"></i> N° CP
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['numcontropatri_bien']); ?></span>
                                </div>
                            </div>

                            <div class="detail-group">
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-calendar"></i> Año
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['añodeadqs_bien']); ?></span>
                                </div>
                                <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-receipt"></i> O. Compra
                                </span>
                                    <span class="detail-value"><?php echo htmlspecialchars($mov['numdeordendecom_bien']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer con botones de acción -->
                    <div class="card-footer">
                        <div class="action-buttons">
                            <button class="action-btn btn-success btnAsignacion"
                                    data-id="<?php echo $mov['id_bien']; ?>"
                                    title="Ver asignación">
                                <i class="fas fa-user-check"></i>
                            </button>
                            <button class="action-btn btn-primary ver-btn" title="Ver">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn btn-warning editar-btn" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="action-btn btn-danger btnEliminar"
                                    data-id="<?php echo $mov['id_bien']; ?>" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Mensaje cuando no hay resultados -->
        <div class="no-results" id="noResults" style="display: none;">
            <i class="fas fa-search-minus"></i>
            <h3>No se encontraron bienes</h3>
            <p>No hay bienes que coincidan con los filtros seleccionados.</p>
            <p>Prueba ajustando los criterios de búsqueda.</p>
        </div>
    </div>

    <!-- Sección de exportar -->
    <div class="export-section">
        <div class="export-buttons">
            <a href="../LN/ln_generar_excel_inventario_bienes.php" target="_blank" class="export-btn pulse-effect">
                <i class="fas fa-file-excel"></i>
                Exportar a Excel
            </a>
            <button type="button" class="upload-btn" id="btnSubirExcel">
                <i class="fas fa-upload"></i>
                Subir Excel
            </button>
        </div>
    </div>
</div>

<!-- Modal Asignación -->
<div class="modal fade" id="modalAsignacion" tabindex="-1" aria-labelledby="modalAsignacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 1200px;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAsignacionLabel">
                    <i class="fas fa-user-check me-2"></i>Asignación del Bien
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="infoAsignacion">
                    <!-- Aquí se cargará la información vía AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Bien -->
<div class="modal fade" id="modalVerBien" tabindex="-1" aria-labelledby="modalVerBienLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1400px; width: 95vw;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalVerBienLabel">
                    <i class="fas fa-eye me-2"></i>Detalle del Bien
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formVerBien">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <!-- Sección: Información Básica del Equipo -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-desktop"></i>
                                    Información Básica del Equipo
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-desktop me-2 text-primary"></i>Equipo
                                            </label>
                                            <input type="text" class="form-control" id="ver_equipo_bien" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-tag me-2 text-success"></i>Marca
                                            </label>
                                            <input type="text" class="form-control" id="ver_marca_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-cube me-2 text-info"></i>Modelo
                                            </label>
                                            <input type="text" class="form-control" id="ver_modelo_bien" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-microchip me-2 text-warning"></i>Procesador
                                            </label>
                                            <input type="text" class="form-control" id="ver_procesador_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Estado y Funcionamiento -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-check-circle"></i>
                                    Estado y Funcionamiento
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-check-circle me-2 text-success"></i>Estado
                                            </label>
                                            <input type="text" class="form-control" id="ver_estado_bien" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-cogs me-2 text-warning"></i>Funcionamiento
                                            </label>
                                            <input type="text" class="form-control" id="ver_funcionamiento" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-building me-2 text-warning"></i>Piso
                                            </label>
                                            <input type="text" class="form-control" id="ver_piso_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <!-- Sección: Información Administrativa -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    Información Administrativa
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Año de Adquisición
                                            </label>
                                            <input type="text" class="form-control" id="ver_añodeadqs_bien" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-receipt me-2 text-info"></i>N° Orden de Compra
                                            </label>
                                            <input type="text" class="form-control" id="ver_numdeordendecom_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="form-label">
                                                <i class="fas fa-dollar-sign me-2 text-success"></i>Costo (S/.)
                                            </label>
                                            <input type="text" class="form-control" id="ver_costo_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Códigos de Identificación -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-barcode"></i>
                                    Códigos de Identificación
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group highlight-field">
                                            <label class="form-label">
                                                <i class="fas fa-barcode me-2 text-secondary"></i>N° de Serie
                                            </label>
                                            <input type="text" class="form-control" id="ver_numdeserie_bien" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="field-group highlight-field">
                                            <label class="form-label">
                                                <i class="fas fa-hashtag me-2 text-danger"></i>N° Control Patrimonial
                                            </label>
                                            <input type="text" class="form-control" id="ver_numcontropatri_bien" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: PC Asignada (mantener id original) -->
                            <div class="modal-section" id="ver_pc_container" style="display: none;">
                                <h6>
                                    <i class="fas fa-network-wired"></i>
                                    PC Asignada
                                </h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field-group highlight-field">
                                            <label class="form-label">
                                                <i class="fas fa-network-wired me-2 text-info"></i>PC Asignada
                                            </label>
                                            <input type="text" class="form-control" id="ver_nombre_pcasignada" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sección: Detalles Adicionales -->
                        <div class="modal-section">
                            <h6>
                                <i class="fas fa-info-circle"></i>
                                Detalles Adicionales
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="field-group optional-field">
                                        <label class="form-label">
                                            <i class="fas fa-palette me-2 text-primary"></i>Color
                                        </label>
                                        <input type="text" class="form-control" id="ver_color_bien" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="field-group optional-field">
                                        <label class="form-label">
                                            <i class="fas fa-sticky-note me-2 text-secondary"></i>Observaciones
                                        </label>
                                        <textarea class="form-control" id="ver_observacion_bien" rows="2" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Bien -->
<div class="modal fade" id="modalEditarBien" tabindex="-1" aria-labelledby="modalEditarBienLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1400px; width: 95vw;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarBienLabel">
                    <i class="fas fa-pen me-2"></i>Editar Bien
                </h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarBien" method="POST">
                    <input type="hidden" id="editar_id_bien" name="id_bien">

                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <!-- Sección: Información Básica del Equipo -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-desktop"></i>
                                    Información Básica del Equipo
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_equipo_bien" class="form-label">
                                                <i class="fas fa-desktop me-2 text-primary"></i>Equipo *
                                            </label>
                                            <select class="form-select" id="editar_equipo_bien" name="equipo_bien" required>
                                                <option value="">Seleccione equipo</option>
                                                <?php
                                                require_once '../AD/ad.php';
                                                $conn = conectar();
                                                $sql = "SELECT id_nombre_bien, des_nombre_bien FROM nombre_bien WHERE estado_nombre_bien = 1";
                                                $result = $conn->query($sql);
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row['id_nombre_bien']}'>{$row['des_nombre_bien']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_marca_bien" class="form-label">
                                                <i class="fas fa-tag me-2 text-success"></i>Marca *
                                            </label>
                                            <input type="text" class="form-control" id="editar_marca_bien" name="marca_bien" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_modelo_bien" class="form-label">
                                                <i class="fas fa-cube me-2 text-info"></i>Modelo *
                                            </label>
                                            <input type="text" class="form-control" id="editar_modelo_bien" name="modelo_bien" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_procesador_bien" class="form-label">
                                                <i class="fas fa-microchip me-2 text-warning"></i>Procesador
                                            </label>
                                            <input type="text" class="form-control" id="editar_procesador_bien" name="procesador_bien">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Estado y Funcionamiento -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-check-circle"></i>
                                    Estado y Funcionamiento
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="field-group">
                                            <label for="editar_estado_bien" class="form-label">
                                                <i class="fas fa-check-circle me-2 text-success"></i>Estado
                                            </label>
                                            <select class="form-select" id="editar_estado_bien" name="estado_bien">
                                                <option value="">Seleccione</option>
                                                <option value="1">Bueno</option>
                                                <option value="2">Regular</option>
                                                <option value="3">Malo</option>
                                                <option value="4">Baja</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="field-group">
                                            <label for="editar_funcionamiento" class="form-label">
                                                <i class="fas fa-cogs me-2 text-warning"></i>Funcionamiento
                                            </label>
                                            <select class="form-select" id="editar_funcionamiento" name="funcionamiento">
                                                <option value="">Seleccione</option>
                                                <option value="1">Operativo</option>
                                                <option value="2">Inoperativo</option>
                                                <option value="3">Regular</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="field-group">
                                            <label for="editar_piso_bien" class="form-label">
                                                <i class="fas fa-building me-2 text-warning"></i>Piso
                                            </label>
                                            <select class="form-select" id="editar_piso_bien" name="piso_bien">
                                                <option value="">Seleccione piso</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <!-- Sección: Información Administrativa -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    Información Administrativa
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_añodeadqs_bien" class="form-label">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Año de Adquisición
                                            </label>
                                            <input type="number" class="form-control" id="editar_añodeadqs_bien" name="añodeadqs_bien">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_numdeordendecom_bien" class="form-label">
                                                <i class="fas fa-receipt me-2 text-info"></i>N° Orden de Compra
                                            </label>
                                            <input type="text" class="form-control" id="editar_numdeordendecom_bien" name="numdeordendecom_bien">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label for="editar_costo_bien" class="form-label">
                                                <i class="fas fa-dollar-sign me-2 text-success"></i>Costo (S/.)
                                            </label>
                                            <input type="number" step="0.01" class="form-control" id="editar_costo_bien" name="costo_bien">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Códigos de Identificación -->
                            <div class="modal-section">
                                <h6>
                                    <i class="fas fa-barcode"></i>
                                    Códigos de Identificación
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-group highlight-field">
                                            <label for="editar_numdeserie_bien" class="form-label">
                                                <i class="fas fa-barcode me-2 text-secondary"></i>N° de Serie
                                            </label>
                                            <input type="text" class="form-control" id="editar_numdeserie_bien" name="numdeserie_bien">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="field-group highlight-field">
                                            <label for="editar_numcontropatri_bien" class="form-label">
                                                <i class="fas fa-hashtag me-2 text-danger"></i>N° de Control Patrimonial
                                            </label>
                                            <input type="text" class="form-control" id="editar_numcontropatri_bien" name="numcontropatri_bien">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: PC Asignada (mantener estructura original y ocultar por defecto) -->
                            <div class="modal-section" id="seccion-pc-asignada" style="display: none;">
                                <h6>
                                    <i class="fas fa-network-wired"></i>
                                    PC Asignada
                                </h6>
                                <div class="row align-items-end mb-3">
                                    <div class="col-md-10">
                                        <label for="pcasignada" class="form-label">
                                            <i class="fas fa-network-wired me-2 text-info"></i>PC Asignada
                                        </label>
                                        <select class="form-select select2-pcasignada" id="pcasignada" name="pcasignada">
                                            <option value="">Seleccione</option>
                                            <?php
                                            require_once '../AD/ad.php';
                                            $conn = conectar();
                                            $sql = "SELECT id_pcasignada, nombre_pcasignada FROM pcasignada WHERE estado_pcasignada = 1";
                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id_pcasignada']}'>{$row['nombre_pcasignada']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary w-100" id="btnNuevoPcasignada" style="height: 48px;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sección: Detalles Adicionales -->
                        <div class="modal-section">
                            <h6>
                                <i class="fas fa-info-circle"></i>
                                Detalles Adicionales
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="field-group optional-field">
                                        <label for="editar_color_bien" class="form-label">
                                            <i class="fas fa-palette me-2 text-primary"></i>Color
                                        </label>
                                        <input type="text" class="form-control" id="editar_color_bien" name="color_bien">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="field-group optional-field">
                                        <label for="editar_observacion_bien" class="form-label">
                                            <i class="fas fa-sticky-note me-2 text-secondary"></i>Observación
                                        </label>
                                        <textarea class="form-control" id="editar_observacion_bien" name="observacion_bien" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-4 border-0">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Guardar cambios
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- 🔹 Modal Nuevo PC Asignada -->
<div class="modal fade" id="modalNuevoPcasignada" tabindex="-1" aria-labelledby="modalNuevoPcasignadaLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px; width: 85vw;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalNuevoPcasignadaLabel">
                    <i class="fas fa-plus me-2"></i>Registrar PC Asignada
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoPcasignada" method="POST">
                    <input type="hidden" id="nuevo_id_bien" name="id_bien">

                    <div class="form-group-custom">
                        <label for="nombre_pcasignada" class="form-label">
                            <i class="fas fa-desktop me-1"></i>Nombre de la PC
                        </label>
                        <input type="text"
                               class="form-control"
                               id="nombre_pcasignada"
                               name="nombre_pcasignada"
                               placeholder="Ej: WORKSTATION-01-2024"
                               required>

                        <div id="validacion_mensaje" class="mt-2" style="display: none;">
                            <small id="mensaje_texto" class="d-block"></small>
                        </div>

                        <small class="form-text text-muted mt-1">
                            <i class="fas fa-info-circle me-1"></i>Mínimo 15 caracteres
                        </small>
                    </div>

                    <div class="modal-footer border-0 px-0 pb-0 mt-3">
                        <button type="submit" class="btn btn-success btn-sm" disabled>
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Subir Excel -->
<div class="modal fade" id="modalSubirExcel" tabindex="-1" aria-labelledby="modalSubirExcelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSubirExcelLabel">
                    <i class="fas fa-upload me-2"></i>Subir Excel - Actualizar Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formSubirExcel" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="archivoExcel" class="form-label">
                            <i class="fas fa-file-excel me-2 text-success"></i>Seleccionar archivo Excel
                        </label>
                        <input type="file" class="form-control" id="archivoExcel" name="archivoExcel"
                               accept=".xlsx,.xls" required>
                        <div class="form-text text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Formato requerido: .xlsx o .xls con las columnas exactas del export
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Instrucciones:</h6>
                        <ul class="mb-0">
                            <li>El archivo debe contener las mismas columnas que el export</li>
                            <li>Los ID existentes se actualizarán, los nuevos se insertarán</li>
                            <li>Haz un backup antes de proceder</li>
                        </ul>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Subir y Actualizar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Evitar múltiples ejecuciones
    if (!window.bienesModuleInitialized) {
        window.bienesModuleInitialized = true;

        // Funciones para estados de carga
        function showLoadingState(button) {
            if (button && button.innerHTML) {
                const originalText = button.innerHTML;
                button.dataset.originalText = originalText;
                button.disabled = true;

                button.innerHTML = `<div class="loading-spinner"></div>`;
            }
        }

        function hideLoadingState(button) {
            if (button && button.dataset.originalText) {
                const originalText = button.dataset.originalText;
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }

        // Event listener unificado para todos los botones
        document.addEventListener('click', function(e) {
            // Botón Ver
            // Botón Ver
            if (e.target.closest('.ver-btn')) {
                e.preventDefault();
                const button = e.target.closest('.ver-btn');
                const id_bien = button.closest('.bien-card').dataset.id;

                if (!id_bien) return;

                showLoadingState(button);

                fetch('../LN/ln_ver_bien.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id_bien=' + encodeURIComponent(id_bien)
                })
                    .then(res => res.json())
                    .then(data => {
                        hideLoadingState(button);

                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Llenar modal con datos
                        const equipoInput = document.getElementById('ver_equipo_bien');
                        if (equipoInput) {
                            equipoInput.dataset.idEquipo = data.equipo_bien;
                            equipoInput.value = data.des_nombre_bien || '';
                        }

                        const campos = [
                            'ver_marca_bien', 'ver_modelo_bien', 'ver_procesador_bien',
                            'ver_numdeserie_bien', 'ver_numcontropatri_bien', 'ver_añodeadqs_bien',
                            'ver_numdeordendecom_bien', 'ver_observacion_bien', 'ver_color_bien',
                            'ver_costo_bien', 'ver_piso_bien'  // ← Agregar esta línea
                        ];

                        campos.forEach(campo => {
                            const elemento = document.getElementById(campo);
                            if (elemento) {
                                const key = campo.replace('ver_', '');
                                elemento.value = data[key] || '';
                            }
                        });

                        // Campo Nombre PC
                        const nombrePcElem = document.getElementById('ver_nombre_pc');
                        if (nombrePcElem) {
                            nombrePcElem.value = data.nombre_pcasignada || '-';
                        }

                        // Campos especiales
                        const estadoElem = document.getElementById('ver_estado_bien');
                        if (estadoElem) estadoElem.value = formatearEstado(data.estado_bien);

                        const funcElem = document.getElementById('ver_funcionamiento');
                        if (funcElem) funcElem.value = formatearFuncionamiento(data.funcionamiento);

                        // Mostrar/ocultar campo procesador
                        // Campo PC Asignada (solo mostrar para CPU y LAPTOP)
                        const equipoIdNum = parseInt(data.equipo_bien, 10);
                        const verPcContainer = document.getElementById('ver_pc_container');
                        const verPcInput = document.getElementById('ver_nombre_pcasignada');

                        if (verPcContainer && verPcInput) {
                            if (equipoIdNum === 1 || equipoIdNum === 4) {
                                verPcContainer.style.display = '';
                                verPcInput.value = data.nombre_pcasignada || 'Sin asignar';
                            } else {
                                verPcContainer.style.display = 'none';
                            }
                        }

// Mostrar/ocultar campos según tipo de equipo
                        toggleCamposPorEquipo(data.equipo_bien, false);

                        // Mostrar modal
                        const modal = new bootstrap.Modal(document.getElementById('modalVerBien'), {
                            backdrop: 'static',
                            keyboard: false
                        });
                        modal.show();
                    })
                    .catch(error => {
                        hideLoadingState(button);
                        console.error('Error al obtener datos del bien:', error);
                    });
            }

            // Botón Editar
            if (e.target.closest('.editar-btn')) {
                e.preventDefault();
                const button = e.target.closest('.editar-btn');
                const id_bien = button.closest('.bien-card').dataset.id;

                if (!id_bien) return;

                showLoadingState(button);

                fetch('../LN/ln_editar_bien.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id_bien=' + encodeURIComponent(id_bien)
                })
                    .then(res => res.json())
                    .then(data => {
                        hideLoadingState(button);

                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Llenar formulario de edición
                        const campos = [
                            'editar_id_bien', 'editar_equipo_bien', 'editar_marca_bien', 'editar_modelo_bien',
                            'editar_procesador_bien', 'editar_numdeserie_bien', 'editar_numcontropatri_bien',
                            'editar_estado_bien', 'editar_añodeadqs_bien', 'editar_numdeordendecom_bien',
                            'editar_observacion_bien', 'editar_color_bien', 'editar_costo_bien',
                            'editar_funcionamiento', 'editar_piso_bien'  // ← Agregar esta línea
                        ];

                        const selectPcasignada = document.getElementById('pcasignada');
                        if (selectPcasignada) {
                            selectPcasignada.value = data.id_pcasignada || '';
                        }

                        campos.forEach(campo => {
                            const elemento = document.getElementById(campo);
                            if (elemento) {
                                const key = campo.replace('editar_', '');
                                elemento.value = data[key] || '';
                            }
                        });

                        // Mostrar/ocultar campo procesador
                        // Mostrar/ocultar campos según tipo de equipo
                        toggleCamposPorEquipo(data.equipo_bien, true);

                        const modal = new bootstrap.Modal(document.getElementById('modalEditarBien'), {
                            backdrop: 'static',
                            keyboard: false
                        });
                        modal.show();
                    })
                    .catch(error => {
                        hideLoadingState(button);
                        console.error('Error:', error);
                    });
            }

            // Botón Eliminar
            if (e.target.closest('.btnEliminar')) {
                e.preventDefault();
                const button = e.target.closest('.btnEliminar');
                const id_bien = button.dataset.id;

                if (!id_bien) return;

                if (confirm('¿Estás seguro de que deseas eliminar este bien?')) {
                    showLoadingState(button);

                    const formData = new FormData();
                    formData.append('id_bien', id_bien);

                    fetch('../LN/ln_eliminar_bien_agregado.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            hideLoadingState(button);

                            if (data.success) {
                                alert('Bien eliminado correctamente');
                                window.parent.location.reload();
                            } else {
                                alert('Error: ' + (data.error ?? ''));
                            }
                        })
                        .catch(() => {
                            hideLoadingState(button);
                            alert('Error de conexión al intentar eliminar');
                        });
                }
            }
        });

        // Formulario de edición
        const formEditar = document.getElementById('formEditarBien');
        if (formEditar) {
            formEditar.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                showLoadingState(submitBtn);

                const formData = new FormData(this);

                fetch('../LN/ln_editar_bien.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        hideLoadingState(submitBtn);

                        if (data.success) {
                            alert('Bien actualizado correctamente');
                            window.parent.location.reload();
                        } else {
                            alert('Error al actualizar el bien: ' + (data.error ?? ''));
                        }
                    })
                    .catch(error => {
                        hideLoadingState(submitBtn);
                        alert('Error de conexión');
                    });
            });
        }

        // Funciones auxiliares
        function formatearEstado(codigo) {
            const estados = {
                '1': 'Bueno',
                '2': 'Regular',
                '3': 'Malo',
                '4': 'Baja'
            };
            return estados[codigo] || '';
        }

        function formatearFuncionamiento(codigo) {
            const funcionamientos = {
                '1': 'Operativo',
                '2': 'Inoperativo',
                '3': 'Regular'
            };
            return funcionamientos[String(codigo)] || '';
        }

        // Modal de asignación con jQuery
        if (typeof $ !== 'undefined') {
            $(document).on('click', '.btnAsignacion', function() {
                const button = this;
                showLoadingState(button);
                let idBien = $(this).data('id');

                $.ajax({
                    url: '../LN/ln_get_asignacion_bien.php',
                    type: 'GET',
                    data: { id_bien: idBien },
                    dataType: 'json',
                    success: function(data) {
                        hideLoadingState(button);

                        if (data.success) {
                            let html = `
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981;">
                                        <h6 class="text-success mb-2"><i class="fas fa-user me-2"></i>Transferente</h6>
                                        <p class="mb-0">${data.transferente || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6;">
                                        <h6 class="text-primary mb-2"><i class="fas fa-user-check me-2"></i>Receptor</h6>
                                        <p class="mb-0">${data.receptor || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(168, 85, 247, 0.1); border-left: 4px solid #a855f7;">
                                        <h6 style="color: #a855f7;" class="mb-2"><i class="fas fa-building me-2"></i>Dep. Transferente</h6>
                                        <p class="mb-0">${data.dependencia_transferente || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b;">
                                        <h6 class="text-warning mb-2"><i class="fas fa-building-user me-2"></i>Dep. Receptora</h6>
                                        <p class="mb-0">${data.dependencia_receptora || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(236, 72, 153, 0.1); border-left: 4px solid #ec4899;">
                                        <h6 style="color: #ec4899;" class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Área Transferente</h6>
                                        <p class="mb-0">${data.area_transferente || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(14, 165, 233, 0.1); border-left: 4px solid #0ea5e9;">
                                        <h6 class="text-info mb-2"><i class="fas fa-location-arrow me-2"></i>Área Receptora</h6>
                                        <p class="mb-0">${data.area_receptora || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(185, 28, 28, 0.1); border-left: 4px solid #b91c1c;">
                                        <h6 style="color: #ef4444;" class="mb-2"><i class="fas fa-calendar me-2"></i>Fecha Movimiento</h6>
                                        <p class="mb-0">${data.fecha_movimiento || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 rounded" style="background: rgba(107, 114, 128, 0.1); border-left: 4px solid #6b7280;">
                                        <h6 class="text-secondary mb-2"><i class="fas fa-file-alt me-2"></i>Archivo</h6>
                                        <p class="mb-0">
                                            ${data.archivo_movimiento
                                ? `<a href="../uploads/${data.archivo_movimiento}" target="_blank" class="text-decoration-none">
                                                     <i class="fas fa-download me-2"></i>Ver archivo
                                                   </a>`
                                : '<span class="text-muted">No disponible</span>'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `;
                            $('#infoAsignacion').html(html);
                        } else {
                            $('#infoAsignacion').html(`
                            <div class="text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-info-circle fa-3x text-warning"></i>
                                </div>
                                <h5 class="text-warning">Sin asignación</h5>
                                <p class="text-muted">No se encontró información de asignación para este bien.</p>
                            </div>
                        `);
                        }
                        $('#modalAsignacion').modal('show');
                    },
                    error: function() {
                        hideLoadingState(button);
                        $('#infoAsignacion').html(`
                        <div class="text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                            </div>
                            <h5 class="text-danger">Error</h5>
                            <p class="text-muted">Error al obtener la información de asignación.</p>
                        </div>
                    `);
                        $('#modalAsignacion').modal('show');
                    }
                });
            });
        }

    } // Fin de la verificación de inicialización

    // Abrir modal nuevo pcasignada
    document.getElementById('btnNuevoPcasignada').addEventListener('click', function () {
        const idBien = document.getElementById('editar_id_bien').value;
        document.getElementById('nuevo_id_bien').value = idBien;

        const modal = new bootstrap.Modal(document.getElementById('modalNuevoPcasignada'));
        modal.show();
    });

    // Función para actualizar todos los selects de pcasignada
    function actualizarSelectsPcasignada(nuevoId, nuevoNombre) {
        const select = document.getElementById('pcasignada');
        if (select) {
            // Verificar que no exista ya la opción
            if (!select.querySelector(`option[value="${nuevoId}"]`)) {
                const option = document.createElement('option');
                option.value = nuevoId;
                option.textContent = nuevoNombre;
                select.appendChild(option);

                // Si Select2 está inicializado, actualizarlo de forma segura
                if (select2Initialized && $('#pcasignada').data('select2')) {
                    try {
                        $('#pcasignada').val(nuevoId).trigger('change.select2');

                        // Forzar re-renderizado
                        setTimeout(() => {
                            $('#pcasignada').select2('close').select2('open').select2('close');
                        }, 100);

                    } catch (error) {
                        console.warn('Error al actualizar Select2:', error);
                        // Fallback: seleccionar manualmente
                        option.selected = true;
                    }
                } else {
                    option.selected = true;
                }
                return true;
            }
        }
        return false;
    }

    // Función para verificar duplicados
    // Función para verificar duplicados (MEJORADA)
    function verificarDuplicado(nombre, callback) {
        const formData = new FormData();
        formData.append('action', 'verificar_duplicado');
        formData.append('nombre_pcasignada', nombre);
        formData.append('id_bien', document.getElementById('nuevo_id_bien').value);

        fetch('../LN/ln_registrar_pcasignada.php', {
            method: 'POST',
            body: formData
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.text(); // Cambiar a text() primero
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    callback(data.existe || false);
                } catch (e) {
                    console.error('Error parsing JSON:', text);
                    callback(false);
                }
            })
            .catch(error => {
                console.error('Error en verificarDuplicado:', error);
                callback(false);
            });
    }

    // Función para mostrar mensajes de validación
    function mostrarMensajeValidacion(tipo, mensaje) {
        const divMensaje = document.getElementById('validacion_mensaje');
        const textoMensaje = document.getElementById('mensaje_texto');

        divMensaje.style.display = 'block';

        // Limpiar clases previas
        textoMensaje.className = '';

        if (tipo === 'error') {
            textoMensaje.className = 'text-danger';
            textoMensaje.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${mensaje}`;
        } else if (tipo === 'warning') {
            textoMensaje.className = 'text-warning';
            textoMensaje.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i>${mensaje}`;
        } else if (tipo === 'success') {
            textoMensaje.className = 'text-success';
            textoMensaje.innerHTML = `<i class="fas fa-check-circle me-1"></i>${mensaje}`;
        }
    }

    // Función para validar el nombre
    function validarNombrePc(nombre) {
        if (nombre.length === 0) {
            document.getElementById('validacion_mensaje').style.display = 'none';
            return false;
        }

        if (nombre.length < 15) {
            mostrarMensajeValidacion('warning', `Mínimo 15 caracteres. Faltan ${15 - nombre.length} caracteres.`);
            return false;
        }

        return true;
    }

    // Validación en tiempo real
    document.getElementById('nombre_pcasignada').addEventListener('input', function() {
        const nombre = this.value.trim();
        const submitBtn = document.querySelector('#formNuevoPcasignada button[type="submit"]');

        if (!validarNombrePc(nombre)) {
            submitBtn.disabled = true;
            return;
        }

        // Si pasa la validación de longitud, verificar duplicados
        verificarDuplicado(nombre, function(existe) {
            if (existe) {
                mostrarMensajeValidacion('error', 'Este nombre ya está registrado para este bien.');
                submitBtn.disabled = true;
            } else {
                mostrarMensajeValidacion('success', '¡Nombre válido y disponible!');
                submitBtn.disabled = false;
            }
        });
    });

    // Guardar nuevo pcasignada (MEJORADO)
    document.getElementById('formNuevoPcasignada').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');

        // Deshabilitar botón temporalmente
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';

        fetch('../LN/ln_registrar_pcasignada.php', {
            method: 'POST',
            body: formData
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);

                    if (data.success) {
                        const actualizado = actualizarSelectsPcasignada(data.id, data.nombre);

                        if (!actualizado) {
                            console.warn('No se pudo encontrar ningún select de pcasignada para actualizar');
                        }

                        // Cerrar modal
                        bootstrap.Modal.getInstance(document.getElementById('modalNuevoPcasignada')).hide();

                        // Limpiar formulario
                        document.getElementById('formNuevoPcasignada').reset();
                        document.getElementById('validacion_mensaje').style.display = 'none';

                        alert('PC asignada registrada correctamente');

                    } else {
                        alert('Error: ' + (data.error || 'Error desconocido'));
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', text);
                    alert('Error en la respuesta del servidor');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión con el servidor');
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });

    // Variables globales para Select2
    let select2Initialized = false;
    let select2InitTimeout = null;

    // Función para inicializar Select2 de forma segura
    function initializeSelect2() {
        const selectElement = $('#pcasignada');

        if (!selectElement.length) return;

        // Limpiar timeout previo si existe
        if (select2InitTimeout) {
            clearTimeout(select2InitTimeout);
        }

        // Destruir instancia previa
        if (selectElement.data('select2')) {
            selectElement.select2('destroy');
            select2Initialized = false;
        }

        // Inicializar con delay para asegurar que el DOM esté listo
        select2InitTimeout = setTimeout(() => {
            try {
                selectElement.select2({
                    dropdownParent: $('#modalEditarBien'),
                    placeholder: '🔍 Buscar PC asignada...',
                    allowClear: true,
                    width: '100%',
                    minimumInputLength: 0,
                    closeOnSelect: true,
                    dropdownAutoWidth: true,
                    language: {
                        noResults: function() {
                            return "❌ No se encontraron resultados";
                        },
                        searching: function() {
                            return "⏳ Buscando...";
                        },
                        inputTooShort: function() {
                            return "💡 Escribe para buscar";
                        },
                        loadingMore: function() {
                            return "⏳ Cargando más resultados...";
                        }
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    }
                });

                select2Initialized = true;

                // Agregar event listeners adicionales
                selectElement.on('select2:open', function() {
                    // Enfocar el campo de búsqueda automáticamente
                    setTimeout(() => {
                        $('.select2-search--dropdown .select2-search__field').focus();
                    }, 100);
                });

                selectElement.on('select2:close', function() {
                    // Remover focus del select cuando se cierre
                    $(this).blur();
                });

            } catch (error) {
                console.warn('Error al inicializar Select2:', error);
            }
        }, 150);
    }

    // Event listeners mejorados para el modal
    document.getElementById('modalEditarBien').addEventListener('show.bs.modal', function () {
        // Preparar para la inicialización
        select2Initialized = false;
    });

    document.getElementById('modalEditarBien').addEventListener('shown.bs.modal', function () {
        // Inicializar Select2 cuando el modal esté completamente visible
        initializeSelect2();
    });

    document.getElementById('modalEditarBien').addEventListener('hide.bs.modal', function () {
        // Limpiar timeout si existe
        if (select2InitTimeout) {
            clearTimeout(select2InitTimeout);
            select2InitTimeout = null;
        }
    });

    document.getElementById('modalEditarBien').addEventListener('hidden.bs.modal', function () {
        // Destruir Select2 cuando el modal se oculte
        const selectElement = $('#pcasignada');
        if (selectElement.data('select2')) {
            selectElement.select2('destroy');
        }
        select2Initialized = false;
    });

    // Limpiar validaciones al cerrar el modal
    document.getElementById('modalNuevoPcasignada').addEventListener('hidden.bs.modal', function() {
        document.getElementById('nombre_pcasignada').value = '';
        document.getElementById('validacion_mensaje').style.display = 'none';
        document.querySelector('#formNuevoPcasignada button[type="submit"]').disabled = true;
    });

    // Botón subir Excel
    document.getElementById('btnSubirExcel').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('modalSubirExcel'));
        modal.show();
    });

    // Función para validar archivos Excel antes del envío
    function validarArchivoExcel(file) {
        const errores = [];

        // Verificar extensión
        const extension = file.name.toLowerCase().split('.').pop();
        if (!['xlsx', 'xls'].includes(extension)) {
            errores.push('Solo se permiten archivos .xlsx o .xls');
        }

        // Verificar tamaño (5MB máximo)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            errores.push(`El archivo es demasiado grande. Máximo: ${(maxSize/1024/1024).toFixed(1)}MB`);
        }

        // Verificar tipo MIME
        const tiposPermitidos = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel'
        ];

        if (file.type && !tiposPermitidos.includes(file.type)) {
            errores.push('Tipo de archivo no válido');
        }

        return errores;
    }

    // Formulario subir Excel (VERSIÓN MEJORADA)
    document.getElementById('formSubirExcel').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        const fileInput = this.querySelector('input[type="file"]');

        // Validar archivo seleccionado
        if (!fileInput.files.length) {
            alert('Por favor selecciona un archivo Excel');
            return;
        }

        // Validar extensión
        const fileName = fileInput.files[0].name.toLowerCase();
        if (!fileName.endsWith('.xlsx') && !fileName.endsWith('.xls')) {
            alert('Solo se permiten archivos .xlsx o .xls');
            return;
        }

        // Validar tamaño (máximo 5MB)
        if (fileInput.files[0].size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo 5MB');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';

        fetch('../LN/ln_subir_excel_inventario.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                // Verificar que la respuesta sea OK
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
                }

                // Obtener texto primero para debugging
                return response.text();
            })
            .then(text => {
                // Log para debugging - ELIMINAR en producción
                console.log('Respuesta del servidor:', text);

                // Intentar parsear como JSON
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Error parsing JSON. Respuesta completa:', text);
                    throw new Error('La respuesta del servidor no es JSON válido');
                }

                if (data.success) {
                    let mensaje = `Excel procesado correctamente:\n- Registros actualizados: ${data.actualizados}\n- Registros insertados: ${data.insertados}`;

                    // AGREGAR ESTAS LÍNEAS NUEVAS:
                    if (data.filas_saltadas > 0) {
                        mensaje += `\n- Filas vacías saltadas: ${data.filas_saltadas}`;
                    }
                    mensaje += `\n- Total procesadas: ${data.total_procesadas}`;

                    if (data.warnings && data.warnings.length > 0) {
                        mensaje += `\n\nAdvertencias (${data.total_errores || data.warnings.length}):\n${data.warnings.join('\n')}`;
                    }

                    alert(mensaje);
                    bootstrap.Modal.getInstance(document.getElementById('modalSubirExcel')).hide();

                    // Recargar solo si hubo cambios
                    if (data.actualizados > 0 || data.insertados > 0) {
                        window.parent.location.reload();
                    }
                } else {
                    let errorMsg = data.error || 'Error desconocido';
                    if (data.details && data.details.length > 0) {
                        errorMsg += '\n\nDetalles:\n' + data.details.join('\n');
                    }
                    alert('Error: ' + errorMsg);
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                let errorMessage = 'Error de conexión';

                if (error.message.includes('JSON')) {
                    errorMessage = 'Error: El servidor devolvió una respuesta inválida. Revisa la consola para más detalles.';
                } else if (error.message.includes('HTTP')) {
                    errorMessage = 'Error del servidor: ' + error.message;
                } else {
                    errorMessage = 'Error: ' + error.message;
                }

                alert(errorMessage);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
    });

    // Función para mostrar/ocultar campos según el tipo de equipo
    function toggleCamposPorEquipo(equipoId, isEditMode = false) {
        const prefix = isEditMode ? 'editar_' : 'ver_';
        const equipoIdNum = parseInt(equipoId, 10);

        // Elementos del procesador
        const procesadorField = document.getElementById(prefix + 'procesador_bien');
        const procesadorContainer = procesadorField ? procesadorField.closest('.col-md-6') : null;

        // NUEVA LÍNEA PARA LA SECCIÓN DE PC ASIGNADA
        const seccionPcAsignada = document.getElementById('seccion-pc-asignada');

        // Mostrar/ocultar procesador
        if (procesadorContainer) {
            if (equipoIdNum === 1 || equipoIdNum === 4) { // CPU o LAPTOP
                procesadorContainer.style.display = '';
                if (procesadorField.value === '--') {
                    procesadorField.value = '';
                }
            } else {
                procesadorContainer.style.display = 'none';
                procesadorField.value = '--';
            }
        }

        // NUEVA LÓGICA PARA MOSTRAR/OCULTAR TODA LA SECCIÓN PC ASIGNADA
        if (isEditMode && seccionPcAsignada) {
            if (equipoIdNum === 1 || equipoIdNum === 4) { // CPU o LAPTOP
                seccionPcAsignada.style.display = '';
            } else {
                seccionPcAsignada.style.display = 'none';
                // Limpiar el valor del select
                const pcSelect = document.getElementById('pcasignada');
                if (pcSelect) {
                    pcSelect.value = '';
                    // Si Select2 está activo, actualizarlo
                    if (select2Initialized && $('#pcasignada').data('select2')) {
                        $('#pcasignada').val('').trigger('change.select2');
                    }
                }
            }
        }
    }

    // Event listener para cambios en el select de equipo (modal editar)
    document.getElementById('editar_equipo_bien').addEventListener('change', function() {
        const equipoId = this.value;
        toggleCamposPorEquipo(equipoId, true);
    });

    // ================================
    // SISTEMA DE FILTROS DINÁMICOS
    // ================================

    class FiltrosBienes {
        constructor() {
            this.filtrosActivos = {
                equipo: '',
                ano: '',
                estado: '',
                marca: ''
            };

            this.inicializar();
        }

        inicializar() {
            this.cargarOpcionesUnicas();
            this.configurarEventos();
            this.actualizarContador();
        }

        // Extraer opciones únicas desde las cards existentes
        cargarOpcionesUnicas() {
            const cards = document.querySelectorAll('.bien-card');
            const opciones = {
                equipo: new Set(),
                ano: new Set(),
                estado: new Set(),
                marca: new Set()
            };

            cards.forEach(card => {
                if (card.dataset.equipo && card.dataset.equipo.trim() !== '') {
                    opciones.equipo.add(card.dataset.equipo);
                }
                if (card.dataset.ano && card.dataset.ano.trim() !== '') {
                    opciones.ano.add(card.dataset.ano);
                }
                if (card.dataset.estado && card.dataset.estado.trim() !== '') {
                    opciones.estado.add(card.dataset.estado);
                }
                if (card.dataset.marca && card.dataset.marca.trim() !== '') {
                    opciones.marca.add(card.dataset.marca);
                }
            });

            // Actualizar selectores con opciones dinámicas
            this.actualizarSelect('selectEquipo', Array.from(opciones.equipo).sort(), 'Todas las categorías');
            this.actualizarSelect('selectAno', Array.from(opciones.ano).sort().reverse(), 'Todos los años');
            this.actualizarSelect('selectEstado', Array.from(opciones.estado).sort(), 'Todos los estados');
            this.actualizarSelect('selectMarca', Array.from(opciones.marca).sort(), 'Todas las marcas');
        }

        // Actualizar opciones de un select
        actualizarSelect(selectId, opciones, placeholderText) {
            const select = document.getElementById(selectId);
            if (!select) return;

            // Guardar valor actual
            const valorActual = select.value;

            // Limpiar y agregar opción por defecto
            select.innerHTML = `<option value="">${placeholderText}</option>`;

            // Agregar opciones únicas
            opciones.forEach(opcion => {
                if (opcion && opcion.trim() !== '') {
                    const option = document.createElement('option');
                    option.value = opcion;
                    option.textContent = opcion;
                    select.appendChild(option);
                }
            });

            // Restaurar valor si aún existe
            if (valorActual && Array.from(select.options).some(opt => opt.value === valorActual)) {
                select.value = valorActual;
            }
        }

        // Configurar event listeners
        configurarEventos() {
            // Toggle de visibilidad
            const toggleBtn = document.getElementById('toggleFilters');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    this.toggleVisibilidad();
                });
            }

            // Filtros individuales
            ['selectEquipo', 'selectAno', 'selectEstado', 'selectMarca'].forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.addEventListener('change', () => {
                        this.actualizarFiltro(selectId);
                        this.aplicarFiltros();
                    });
                }
            });

            // Botones de control
            const clearBtn = document.getElementById('clearFilters');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    this.limpiarFiltros();
                });
            }

            const applyBtn = document.getElementById('applyFilters');
            if (applyBtn) {
                applyBtn.addEventListener('click', () => {
                    this.aplicarFiltros();
                });
            }

            // Integrar con búsqueda original existente
            const buscarInput = document.getElementById('buscarBien');
            if (buscarInput) {
                // Remover listener existente y agregar el nuestro
                const nuevoInput = buscarInput.cloneNode(true);
                buscarInput.parentNode.replaceChild(nuevoInput, buscarInput);

                nuevoInput.addEventListener('input', () => {
                    this.aplicarFiltros();
                });
            }
        }

        // Toggle visibilidad de filtros
        toggleVisibilidad() {
            const content = document.getElementById('filtersContent');
            const button = document.getElementById('toggleFilters');
            const icon = button.querySelector('i');
            const text = button.querySelector('span');

            if (content.classList.contains('collapsed')) {
                content.classList.remove('collapsed');
                content.style.height = content.scrollHeight + 'px';
                icon.className = 'fas fa-eye';
                text.textContent = 'Ocultar';
            } else {
                content.classList.add('collapsed');
                content.style.height = '0px';
                icon.className = 'fas fa-eye-slash';
                text.textContent = 'Mostrar';
            }
        }

        // Actualizar filtro individual
        actualizarFiltro(selectId) {
            const select = document.getElementById(selectId);
            const valor = select.value;
            const grupo = select.closest('.filter-group');

            // Mapear selectId a filtro
            const mapeo = {
                'selectEquipo': 'equipo',
                'selectAno': 'ano',
                'selectEstado': 'estado',
                'selectMarca': 'marca'
            };

            const filtroKey = mapeo[selectId];
            if (filtroKey) {
                this.filtrosActivos[filtroKey] = valor;

                // Actualizar estado visual
                if (valor) {
                    grupo.classList.add('active');
                    select.classList.add('active');
                } else {
                    grupo.classList.remove('active');
                    select.classList.remove('active');
                }
            }

            this.actualizarIndicadorFiltros();
        }

        // Aplicar todos los filtros
        aplicarFiltros() {
            const cards = document.querySelectorAll('.bien-card');
            const busqueda = document.getElementById('buscarBien').value.toLowerCase().trim();
            let contadorVisible = 0;

            cards.forEach(card => {
                let mostrar = true;

                // Aplicar filtros por categoría
                if (this.filtrosActivos.equipo && card.dataset.equipo !== this.filtrosActivos.equipo) {
                    mostrar = false;
                }

                if (this.filtrosActivos.ano && card.dataset.ano !== this.filtrosActivos.ano) {
                    mostrar = false;
                }

                if (this.filtrosActivos.estado && card.dataset.estado !== this.filtrosActivos.estado) {
                    mostrar = false;
                }

                if (this.filtrosActivos.marca && card.dataset.marca !== this.filtrosActivos.marca) {
                    mostrar = false;
                }

                // Aplicar búsqueda de texto (mantener funcionalidad original)
                if (busqueda && !card.textContent.toLowerCase().includes(busqueda)) {
                    mostrar = false;
                }

                // Mostrar/ocultar card
                if (mostrar) {
                    card.classList.remove('filtered-out');
                    card.style.display = '';
                    contadorVisible++;
                } else {
                    card.classList.add('filtered-out');
                    card.style.display = 'none';
                }
            });

            this.actualizarContador(contadorVisible);
            this.mostrarMensajeVacio(contadorVisible === 0);

            // Actualizar el contador de búsqueda original
            this.actualizarContadorBusqueda(contadorVisible, busqueda);
        }

        // Actualizar contador de búsqueda original (mantener compatibilidad)
        actualizarContadorBusqueda(visibleCount, filtro) {
            const searchResults = document.getElementById('searchResults');
            const resultsCount = document.getElementById('resultsCount');

            if (searchResults && resultsCount) {
                if (filtro !== '' || Object.values(this.filtrosActivos).some(v => v !== '')) {
                    searchResults.style.display = 'block';
                    resultsCount.textContent = visibleCount;
                } else {
                    searchResults.style.display = 'none';
                }
            }
        }

        // Limpiar todos los filtros
        limpiarFiltros() {
            // Resetear filtros activos
            Object.keys(this.filtrosActivos).forEach(key => {
                this.filtrosActivos[key] = '';
            });

            // Limpiar selects
            ['selectEquipo', 'selectAno', 'selectEstado', 'selectMarca'].forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.value = '';
                    select.classList.remove('active');
                    const grupo = select.closest('.filter-group');
                    if (grupo) grupo.classList.remove('active');
                }
            });

            // Limpiar búsqueda
            const buscarInput = document.getElementById('buscarBien');
            if (buscarInput) {
                buscarInput.value = '';
            }

            // Aplicar filtros vacíos
            this.aplicarFiltros();
            this.actualizarIndicadorFiltros();
        }

        // Actualizar contador de resultados
        actualizarContador(visible = null) {
            const contador = document.getElementById('resultsCount');
            if (!contador) return;

            if (visible === null) {
                visible = document.querySelectorAll('.bien-card:not(.filtered-out)').length;
            }

            const total = document.querySelectorAll('.bien-card').length;
            contador.textContent = visible;

            // Actualizar texto completo
            const textoCompleto = contador.parentElement;
            const spans = textoCompleto.querySelectorAll('span');
            if (spans.length >= 3) {
                spans[2].textContent = `de ${total} bienes`;
            }

            // Cambiar color según resultados
            if (visible === 0) {
                contador.style.color = 'var(--danger-red)';
            } else if (visible < total) {
                contador.style.color = 'var(--warning-orange)';
            } else {
                contador.style.color = 'var(--light-red)';
            }
        }

        // Mostrar mensaje cuando no hay resultados
        mostrarMensajeVacio(mostrar) {
            const mensaje = document.getElementById('noResults');
            const cardsContainer = document.querySelector('.cards-grid');

            if (mensaje) {
                mensaje.style.display = mostrar ? 'block' : 'none';
            }

            if (cardsContainer) {
                cardsContainer.style.opacity = mostrar ? '0.3' : '1';
            }
        }

        // Actualizar indicador de filtros activos
        actualizarIndicadorFiltros() {
            const filtrosSection = document.getElementById('filtersSection');
            if (!filtrosSection) return;

            let badge = filtrosSection.querySelector('.active-filters-badge');
            const cantidad = Object.values(this.filtrosActivos).filter(v => v !== '').length;

            if (cantidad > 0) {
                if (!badge) {
                    badge = document.createElement('div');
                    badge.className = 'active-filters-badge';
                    filtrosSection.style.position = 'relative';
                    filtrosSection.appendChild(badge);
                }
                badge.textContent = cantidad;
            } else {
                if (badge) {
                    badge.remove();
                }
            }
        }

        // Método público para recarga dinámica
        recargarOpciones() {
            this.cargarOpcionesUnicas();
            this.aplicarFiltros();
        }
    }

    // Integrar con el sistema existente
    if (!window.bienesModuleInitialized) {
        window.bienesModuleInitialized = true;
    }

    // Inicializar sistema de filtros
    let filtrosBienesInstance = null;

    // Función de inicialización que se ejecuta después de que el DOM esté listo
    function inicializarFiltros() {
        if (!filtrosBienesInstance) {
            filtrosBienesInstance = new FiltrosBienes();
            window.filtrosBienes = filtrosBienesInstance;
        }
    }

    // Ejecutar después de un pequeño delay para asegurar que todo esté cargado
    setTimeout(inicializarFiltros, 100);

    // Función global para uso externo (para cuando agregues nuevos bienes)
    function recargarFiltros() {
        if (window.filtrosBienes) {
            window.filtrosBienes.recargarOpciones();
        }
    }
</script>
</body>
</html>
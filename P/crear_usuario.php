<?php
session_start();
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_listarPerUserR.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="../libreria/fontawesome/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Variables CSS del login */
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
            color: var(--text-light);
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 600px;
            margin: 80px auto;
            padding: 2rem;
        }

        .main-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 20px 20px 0 0;
        }

        .main-card:hover {
            transform: translateY(-5px);
            box-shadow:
                    0 25px 50px rgba(185, 28, 28, 0.3),
                    0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            color: var(--text-light);
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, select {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1.5px solid transparent !important;
            border-radius: 8px !important;
            color: var(--text-light) !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
            box-sizing: border-box;
        }

        /* Select styling */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23dc2626' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 16px center !important;
            background-size: 16px !important;
            padding-right: 50px !important;
        }

        .form-control:focus, select:focus {
            outline: none !important;
            border-color: var(--primary-red) !important;
            background: rgba(255, 255, 255, 0.06) !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1) !important;
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        select option {
            background: var(--dark-bg) !important;
            color: var(--text-light) !important;
            border: none;
            padding: 8px !important;
        }

        .btn-primary {
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-primary);
            margin-top: 20px;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(185, 28, 28, 0.35);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            margin: 16px 0;
            transition: all 0.3s ease;
        }

        .alert-success {
            background: rgba(5, 150, 105, 0.1);
            color: #10b981;
            border: 1px solid rgba(5, 150, 105, 0.2);
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.1);
        }

        .alert-danger {
            background: rgba(185, 28, 28, 0.1);
            color: var(--accent-red);
            border: 1px solid var(--primary-red);
            box-shadow: 0 4px 20px rgba(185, 28, 28, 0.1);
        }

        /* Loading Animation */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--primary-red);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Icon styling */
        .fas {
            color: var(--accent-red);
            margin-right: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin: 20px auto;
            }

            .main-card {
                padding: 30px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.75rem;
            }
        }

        /* Fix Bootstrap overrides */
        .form-control:not(textarea) {
            height: auto !important;
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }

        .btn-primary:not(:disabled):not(.disabled):active,
        .btn-primary:not(:disabled):not(.disabled).active {
            background-color: var(--primary-red) !important;
            border-color: var(--primary-red) !important;
        }

        /* Hide default Bootstrap focus styles */
        .btn:focus,
        .btn.focus,
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1) !important;
        }

        .seccion {
            display: none;
        }

        /* Fade in animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        $(document).ready(function() {

            $('#usuarioForm').on('submit', function(e) {
                e.preventDefault();

                // Add loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.text();
                submitBtn.addClass('loading').text('Procesando...');

                var formData = $(this).serialize();

                $.ajax({
                    url: '../LN/ln_registrar_usuario.php',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#mensaje_usuario').html('<p class="alert alert-success"><i class="fas fa-check-circle me-2"></i>' + response.message + '</p>');
                            $('#usuarioForm')[0].reset();

                            // Success animation
                            $('.main-card').addClass('animate__pulse');
                            setTimeout(() => $('.main-card').removeClass('animate__pulse'), 600);
                        } else {
                            $('#mensaje_usuario').html('<p class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>' + response.message + '</p>');

                            // Error animation
                            $('.main-card').addClass('error-glitch');
                            setTimeout(() => $('.main-card').removeClass('error-glitch'), 600);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#mensaje_usuario').html('<p class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>Error en el registro: ' + textStatus + '</p>');

                        // Error animation
                        $('.main-card').addClass('error-glitch');
                        setTimeout(() => $('.main-card').removeClass('error-glitch'), 600);
                    },
                    complete: function() {
                        // Remove loading state
                        submitBtn.removeClass('loading').text(originalText);
                    }
                });
            });

            // Add focus effects
            $('.form-control, select').on('focus', function() {
                $(this).parent().find('label').addClass('focused');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $(this).parent().find('label').removeClass('focused');
                }
            });
        });
    </script>
</head>

<body>
<div class="container mt-5">
    <div class="main-card">
        <h1><i class="fas fa-user-plus me-3"></i>Crear Usuario</h1>

        <form id="usuarioForm">
            <div class="form-group">
                <label for="id_persona"><i class="fas fa-link me-2"></i>Vincular Persona:</label>
                <select class="form-control" id="id_persona" name="id_persona">
                    <?php
                    $personasx = obtener_personas_disponibles();
                    foreach ($personasx as $personasx) {
                        echo "<option value='{$personasx['id_persona']}'>{$personasx['nomyap_persona']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nombre_usuario"><i class="fas fa-user me-2"></i>Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>

            <div class="form-group">
                <label for="clave_usuario"><i class="fas fa-lock me-2"></i>Contraseña:</label>
                <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" required>
            </div>

            <div class="form-group">
                <label for="estado_usuario"><i class="fas fa-shield-alt me-2"></i>Tipo de Usuario:</label>
                <select class="form-control" id="estado_usuario" name="estado_usuario">
                    <option value="1">Súper Usuario</option>
                    <option value="2">Editor</option>
                    <option value="3">Deshabilitado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">
                <i class="fas fa-save me-2"></i>Registrar Usuario
            </button>
        </form>

        <div id="mensaje_usuario" class="mt-3"></div>
    </div>
</div>
</body>
</html>
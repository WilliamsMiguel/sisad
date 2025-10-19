<?php
//include '../LN/ln_listarPerUserR.php';
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_listar_nombrebien.php';
$nombres_bien = obtener_lista_nombre_bien(); // función que deberás crear
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Datos</title>
    <link rel="stylesheet" href="../libreria/bootstrap.min.css">
    <script src="../libreria/jquery-3.6.0.min.js"></script>
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
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f1419 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-light);
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
            z-index: 1;
            pointer-events: none;
        }

        /* Contenedor principal */
        .container {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 20px auto;
            padding: 40px;
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 20px 20px 0 0;
        }

        /* Título principal */
        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
            position: relative;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
        }

        /* Títulos de sección */
        .seccion-titulo {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin: 2rem 0 0 0;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .seccion-titulo::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(185, 28, 28, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .seccion-titulo:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
            border-color: var(--primary-red);
            color: var(--light-red);
        }

        .seccion-titulo:hover::before {
            left: 100%;
        }

        /* Secciones del formulario */
        .seccion {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1rem;
            display: none;
            border-top: 2px solid var(--primary-red);
        }

        /* Formularios */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-control-file {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .form-control:focus, .form-control-file:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Estados de validación */
        .form-control.is-invalid, .form-control-file.is-invalid {
            border-color: #ff4757;
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.3);
        }

        /* Checkboxes personalizados */
        .form-check {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            accent-color: var(--primary-red);
            cursor: pointer;
        }

        .form-check-label {
            color: var(--text-gray);
            font-weight: 500;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .form-check-label:hover {
            color: var(--light-red);
        }

        /* Sección de archivos especial */
        .border-danger {
            border-color: var(--primary-red) !important;
            background: rgba(185, 28, 28, 0.05) !important;
        }

        .text-danger {
            color: var(--light-red) !important;
        }

        /* Botones */
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
            margin-top: 2rem;
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

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(185, 28, 28, 0.35);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .btn-primary:hover:not(:disabled)::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled, .btn-secondary {
            background: linear-gradient(135deg, #374151, #4b5563);
            color: var(--text-muted);
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }

        /* Mensajes de alerta */
        .alert {
            border-radius: 8px;
            border: none;
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            margin: 1rem 0;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border-left: 4px solid #22c55e;
            color: #4ade80;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            border-left: 4px solid var(--light-red);
            color: var(--light-red);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.15);
            border-left: 4px solid #f59e0b;
            color: #fbbf24;
        }

        /* Grid responsivo */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.5rem;
        }

        .col-md-6 {
            flex: 0 0 50%;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
            }

            h1 {
                font-size: 2rem;
            }

            .container {
                margin: 10px;
                padding: 20px;
            }

            .seccion-titulo {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }

            .seccion {
                padding: 1.5rem;
            }
        }

        /* Scroll personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--light-red);
        }

        /* Código */
        code {
            background: rgba(185, 28, 28, 0.1);
            border: 1px solid rgba(185, 28, 28, 0.2);
            border-radius: 4px;
            padding: 0.2rem 0.4rem;
            font-family: 'Courier New', monospace;
            color: var(--light-red);
            font-size: 0.875rem;
        }

        /* Efectos de entrada suaves */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
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

        /* Loading state */
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

        /* Mejoras específicas para inputs de archivo */
        .form-control-file {
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed var(--border-color);
        }

        .form-control-file:hover {
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.08);
        }

        /* Estilos para mensajes específicos */
        .font-weight-bold {
            font-weight: 700;
        }

        .bg-light {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .p-3 {
            padding: 1.5rem !important;
        }

        .rounded {
            border-radius: 8px !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .btn-block {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        /* Ajuste para grupos de archivos ocultos */
        #grupo_ln, #grupo_ad, #grupo_img {
            margin-top: 1rem;
        }
    </style>
    <script>
        // Función para verificar si alguna sección está visible y habilitar/deshabilitar el botón
        function verificarSeccionesYBoton() {
            const seccionesVisibles = $('.seccion:visible').length;
            const botonRegistrar = $('button[type="submit"]');

            if (seccionesVisibles === 0) {
                botonRegistrar.prop('disabled', true);
                botonRegistrar.text('Registrar (Despliegue al menos una sección)');
                botonRegistrar.addClass('btn-secondary').removeClass('btn-primary');
            } else {
                botonRegistrar.prop('disabled', false);
                botonRegistrar.text('Registrar');
                botonRegistrar.addClass('btn-primary').removeClass('btn-secondary');
            }
        }

        $(document).ready(function () {

            // Verificar estado inicial del botón
            verificarSeccionesYBoton();

            $('#procesador_bien').hide().val('--');
            $('label[for="procesador_bien"]').hide();

            $('#equipo_bien').on('change', function () {
                const selectedOption = $(this).find('option:selected');
                const nombreEquipo = selectedOption.data('nombre');

                if (nombreEquipo === 'UNIDAD CENTRAL DE PROCESO - CPU' || nombreEquipo === 'LAPTOP') {
                    $('#procesador_bien').show().val('');
                    $('label[for="procesador_bien"]').show();
                } else {
                    $('#procesador_bien').hide().val('--');
                    $('label[for="procesador_bien"]').hide();
                }
            });

            // Modificar el evento click de las secciones para incluir la verificación
            $('.seccion-titulo').on('click', function () {
                const $seccion = $(this).next('.seccion');
                const esCrearMenus = $(this).text().includes('Crear Menús');

                $seccion.slideToggle(() => {
                    // Verificar el estado del botón después de la animación
                    verificarSeccionesYBoton();

                    if (esCrearMenus) {
                        const visible = $seccion.is(':visible');
                        $('#check_p').prop('checked', visible).trigger('change');

                        if (visible) {
                            $('#check_p').on('click.preventCheck', function (e) {
                                e.preventDefault();
                            });
                        } else {
                            $('#check_p').off('click.preventCheck').prop('checked', false).trigger('change');
                        }
                    }
                });
            });

            $('.carpeta-toggle').on('change', function () {
                const target = $(this).data('target');
                if (this.checked) {
                    $(target).slideDown();
                } else {
                    $(target).slideUp();
                    $(target).find('input[type="file"]').val('');
                }
            });

            $('#registroForm').on('submit', function (e) {
                let valid = true;
                $('#mensaje').html('');

                // SECCION VALIDACIONES
                // Validar que la Descripción Área no esté vacía si la sección está visible
                if ($('.seccion-titulo:contains("Registrar Área")').next('.seccion').is(':visible')) {
                    const descripcionArea = $('#descripcion_area').val().trim();
                    if (descripcionArea === '') {
                        e.preventDefault();
                        $('#descripcion_area').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Descripción del Área.</p>');
                        return false;
                    } else {
                        $('#descripcion_area').removeClass('is-invalid');
                    }
                    if ($('#organo').val() === null || $('#organo').val() === '') {
                        $('#organo').addClass('is-invalid');
                        valid = false;
                    } else {
                        $('#organo').removeClass('is-invalid');
                    }

                    if ($('#especialidad').val().trim() === '') {
                        $('#especialidad').addClass('is-invalid');
                        valid = false;
                    } else {
                        $('#especialidad').removeClass('is-invalid');
                    }
                }

                // Validar que la Descripción Dependencia no esté vacía si la sección está visible
                if ($('.seccion-titulo:contains("Registrar Dependencia")').next('.seccion').is(':visible')) {
                    const descripcionDependencia = $('#descripcion_dependencia').val().trim();
                    if (descripcionDependencia === '') {
                        e.preventDefault();
                        $('#descripcion_dependencia').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Descripción de la Dependencia.</p>');
                        return false;
                    } else {
                        $('#descripcion_dependencia').removeClass('is-invalid');
                    }
                }

                // Validar campos de "Registrar Bien" si la sección está visible
                if ($('.seccion-titulo:contains("Registrar Bien")').next('.seccion').is(':visible')) {
                    // Validar Equipo Bien (select)
                    const equipoBien = $('#equipo_bien').val();
                    if (equipoBien === null || equipoBien === '') {
                        e.preventDefault();
                        $('#equipo_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, selecciona un Equipo Bien.</p>');
                        return false;
                    } else {
                        $('#equipo_bien').removeClass('is-invalid');
                    }

                    // Validar Marca
                    if ($('#marca_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#marca_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Marca.</p>');
                        return false;
                    } else {
                        $('#marca_bien').removeClass('is-invalid');
                    }

                    // Validar Modelo
                    if ($('#modelo_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#modelo_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Modelo.</p>');
                        return false;
                    } else {
                        $('#modelo_bien').removeClass('is-invalid');
                    }

                    // Validar Procesador (puedes hacerlo opcional si no siempre se requiere)
                    if ($('#procesador_bien').is(':visible') && $('#procesador_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#procesador_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Procesador.</p>');
                        return false;
                    } else {
                        $('#procesador_bien').removeClass('is-invalid');
                    }

                    // Validar Serie
                    if ($('#numdeserie_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#numdeserie_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Serie.</p>');
                        return false;
                    } else {
                        $('#numdeserie_bien').removeClass('is-invalid');
                    }

                    // Validar Control Patrimonial
                    if ($('#numcontropatri_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#numcontropatri_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Control Patrimonial.</p>');
                        return false;
                    } else {
                        $('#numcontropatri_bien').removeClass('is-invalid');
                    }

                    // Validar Estado del bien (select)
                    const estadoBien = $('#estado_bien').val();
                    if (estadoBien === null || estadoBien === '') {
                        e.preventDefault();
                        $('#estado_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, selecciona el Estado del bien.</p>');
                        return false;
                    } else {
                        $('#estado_bien').removeClass('is-invalid');
                    }

                    // Validar Funcionamiento (select)
                    const funcionamiento = $('#funcionamiento').val();
                    if (funcionamiento === null || funcionamiento === '') {
                        e.preventDefault();
                        $('#funcionamiento').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, selecciona el Funcionamiento.</p>');
                        return false;
                    } else {
                        $('#funcionamiento').removeClass('is-invalid');
                    }

                    // Validar Año del bien
                    if ($('#añodeadqs_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#añodeadqs_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Año del bien.</p>');
                        return false;
                    } else {
                        $('#añodeadqs_bien').removeClass('is-invalid');
                    }

                    // Validar Orden de Compra
                    if ($('#numdeordendecom_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#numdeordendecom_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Orden de Compra.</p>');
                        return false;
                    } else {
                        $('#numdeordendecom_bien').removeClass('is-invalid');
                    }

                    // Validar Observación
                    if ($('#observacion_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#observacion_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa la Observación.</p>');
                        return false;
                    } else {
                        $('#observacion_bien').removeClass('is-invalid');
                    }

                    // Validar Costo
                    if ($('#costo_bien').val().trim() === '') {
                        e.preventDefault();
                        $('#costo_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Costo.</p>');
                        return false;
                    } else {
                        $('#costo_bien').removeClass('is-invalid');
                    }

                    // Validar Piso
                    if ($('#piso_bien').val() === null || $('#piso_bien').val() === '') {
                        e.preventDefault();
                        $('#piso_bien').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, selecciona el Piso.</p>');
                        return false;
                    } else {
                        $('#piso_bien').removeClass('is-invalid');
                    }
                }

                // Validaciones específicas para Registrar Persona
                if ($('.seccion-titulo:contains("Registrar Persona")').next('.seccion').is(':visible')) {
                    const nomyap = $('#nomyap_persona').val().trim();
                    if (nomyap === '') {
                        e.preventDefault();
                        $('#nomyap_persona').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Nombre y Apellido.</p>');
                        return false;
                    } else {
                        $('#nomyap_persona').removeClass('is-invalid');
                    }

                    const dni = $('#dni_persona').val().trim();
                    if (dni === '') {
                        e.preventDefault();
                        $('#dni_persona').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el DNI.</p>');
                        return false;
                    } else {
                        $('#dni_persona').removeClass('is-invalid');
                    }

                    const celular = $('#cell_persona').val().trim();
                    if (celular === '') {
                        e.preventDefault();
                        $('#cell_persona').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Celular.</p>');
                        return false;
                    } else {
                        $('#cell_persona').removeClass('is-invalid');
                    }

                    const correo = $('#correo_persona').val().trim();
                    if (correo === '') {
                        e.preventDefault();
                        $('#correo_persona').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Correo.</p>');
                        return false;
                    } else {
                        $('#correo_persona').removeClass('is-invalid');
                    }

                    const cargo = $('#cargo_persona').val().trim();
                    if (cargo === '') {
                        e.preventDefault();
                        $('#cargo_persona').addClass('is-invalid');
                        $('#mensaje').html('<p class="alert alert-danger">Por favor, completa el Cargo.</p>');
                        return false;
                    } else {
                        $('#cargo_persona').removeClass('is-invalid');
                    }
                }
                // SECCION VALIDACIONES

                // Validar campos visibles requeridos
                $('.seccion:visible').find('input, select, textarea').each(function () {
                    const $input = $(this);
                    if ($input.is(':visible') && $input.prop('required') && $input.val().trim() === "") {
                        $input.addClass('is-invalid');
                        valid = false;
                    } else {
                        $input.removeClass('is-invalid');
                    }
                });

                const descripcionMenu = $('#descripcion_menu').val().trim();
                const algunCheckboxActivo = $('#check_p, #check_ln, #check_ad, #check_libreria, #check_img').is(':checked');

                // Solo validar sección menú si hay descripción o checkboxes activos
                if (descripcionMenu !== '' || algunCheckboxActivo) {
                    // Validar descripción del menú
                    if (descripcionMenu === '') {
                        $('#descripcion_menu').addClass('is-invalid');
                        $('#mensaje').append('<p class="alert alert-danger">Por favor, completa la Descripción del Menú.</p>');
                        valid = false;
                    } else {
                        $('#descripcion_menu').removeClass('is-invalid');
                    }

                    // Validar archivos por carpeta
                    const carpetas = [
                        { check: '#check_p', input: '#nombrearchivo_menu', nombre: 'P/' },
                        { check: '#check_ln', input: '#nombrearchivo_ln', nombre: 'LN/' },
                        { check: '#check_ad', input: '#nombrearchivo_ad', nombre: 'AD/' },
                        { check: '#check_libreria', input: '#nombrearchivo_libreria', nombre: 'libreria/' },
                        { check: '#check_img', input: '#nombrearchivo_img', nombre: 'P/img/' }
                    ];

                    carpetas.forEach(({ check, input, nombre }) => {
                        if ($(check).is(':checked')) {
                            const files = $(input)[0].files;
                            if (files.length === 0) {
                                valid = false;
                                $(input).addClass('is-invalid');
                                $('#mensaje').append(`<p class="alert alert-danger">Selecciona al menos un archivo para la carpeta <strong>${nombre}</strong>.</p>`);
                            } else {
                                $(input).removeClass('is-invalid');
                            }
                        }
                    });
                } else {
                    $('#descripcion_menu').removeClass('is-invalid');
                }

                if (!valid) {
                    e.preventDefault();
                    return;
                }

                // Envío AJAX
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '../LN/ln_registro.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('Respuesta cruda:', response);
                        const respuesta = response.trim().toLowerCase();
                        console.log('Respuesta procesada:', JSON.stringify(respuesta));

                        // SECCION VALIDACIONES
                        if (respuesta === 'duplicado_menu') {
                            $('#mensaje').html('<p class="alert alert-warning">⚠ El menú ya existe en la base de datos. No se registró.</p>');
                        } else if (respuesta === 'duplicado_area') {
                            $('#mensaje').html('<p class="alert alert-warning">⚠ El archivo ya existe en la base de datos. No se registró el área.</p>');
                        }

                        else if (respuesta === 'ok') {
                            $('#mensaje').html('<p class="alert alert-success">✅ Registro exitoso.</p>');
                            $('#registroForm')[0].reset();

                            $('#procesador_bien').hide().val('--');
                            $('label[for="procesador_bien"]').hide();
                            $('.form-control, .form-control-file').removeClass('is-invalid');

                            $('.carpeta-toggle').each(function () {
                                const target = $(this).data('target');

                                if (this.id === 'check_p') {
                                    const crearMenusVisible = $('.seccion-titulo:contains("Crear Menús")').next('.seccion').is(':visible');
                                    $(this).prop('checked', crearMenusVisible);
                                    crearMenusVisible ? $(target).slideDown() : $(target).slideUp();
                                } else {
                                    $(this).prop('checked', false);
                                    $(target).slideUp();
                                }

                                $(target).find('input[type="file"]').val('');
                            });

                            // Recargar la página después de 2 segundos
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#mensaje').html('<p class="alert alert-danger">❌ Error en el registro. Inténtalo nuevamente.</p>');
                        }
                        // SECCION VALIDACIONES
                    },
                    error: function () {
                        $('#mensaje').html('<p class="alert alert-danger">Error en el registro. Inténtalo nuevamente.</p>');
                    }
                });
            });
        });

        // Limpia caracteres que no sean dígitos, punto o coma
        function limpiarValor(valor) {
            return valor.replace(/[^\d,\.]/g, '');
        }

        // Convierte a formato numérico estándar (punto como separador decimal)
        function normalizarValor(valor) {
            return valor.replace(/\./g, '').replace(',', '.');
        }

        // Formatea número para mostrar
        function formatearValor(numero) {
            return new Intl.NumberFormat('es-PE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(numero);
        }

        function procesarCostoBien(inputElement) {
            let valor = limpiarValor(inputElement.value);
            const partes = valor.split(/[\.,]/);
            if (partes.length > 2) {
                partes.splice(2);
                valor = partes.join('.');
            }

            let numero = parseFloat(normalizarValor(valor));
            if (!isNaN(numero)) {
                numero = Math.floor(numero * 100) / 100;
                inputElement.value = formatearValor(numero); // solo para mostrar
                inputElement.dataset.formateado = "true";
                inputElement.dataset.valorLimpio = numero.toFixed(2); // guardamos valor limpio aparte
                return numero.toFixed(2);
            } else {
                inputElement.value = '';
                inputElement.dataset.formateado = "false";
                inputElement.dataset.valorLimpio = '';
                return '';
            }
        }

        // Formatea al salir del campo
        $('#costo_bien').on('blur', function () {
            procesarCostoBien(this);
        });

        // Antes de enviar: siempre enviamos el valor limpio
        $('form').on('submit', function () {
            const input = document.getElementById('costo_bien');
            if (input.dataset.valorLimpio) {
                input.value = input.dataset.valorLimpio; // enviamos número puro
            }
        });
    </script>
</head>
<body>
<?php //echo $_SESSION['id_persona_usuario']; ?>

<div class="container mt-5">
    <h1 class="text-center">Registro de Datos</h1>
    <form id="registroForm" enctype="multipart/form-data">

        <!-- Registrar Área -->
        <h2 class="seccion-titulo" style="cursor: pointer;">Registrar Área</h2>
        <div class="seccion">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descripcion_area">Descripción Área:</label>
                        <input type="text" class="form-control" id="descripcion_area" name="descripcion_area" placeholder="Ingrese la descripción del área">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="organo">Órgano:</label>
                        <select class="form-control" id="organo" name="organo">
                            <option value="" disabled selected>Seleccione un órgano</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="jurisdiccional">Jurisdiccional</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="especialidad">Especialidad:</label>
                <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Ingrese especialidad">
            </div>
        </div>

        <!-- Registrar Dependencia -->
        <h2 class="seccion-titulo" style="cursor: pointer;">Registrar Dependencia</h2>
        <div class="seccion">
            <div class="form-group">
                <label for="descripcion_dependencia">Descripción Dependencia:</label>
                <input type="text" class="form-control" id="descripcion_dependencia" name="descripcion_dependencia" placeholder="Ingrese la descripción de la dependencia">
            </div>
        </div>

        <!-- Registrar Bien -->
        <h2 class="seccion-titulo" style="cursor: pointer;">Registrar Bien</h2>
        <div class="seccion">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="equipo_bien">Equipo Bien:</label>
                        <select class="form-control" id="equipo_bien" name="equipo_bien">
                            <option value="">Seleccione un equipo</option>
                            <?php
                            foreach ($nombres_bien as $bien) {
                                echo '<option value="' . $bien['id_nombre_bien'] . '" data-nombre="' . htmlspecialchars($bien['des_nombre_bien']) . '">' . htmlspecialchars($bien['des_nombre_bien']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marca_bien">Marca:</label>
                        <input type="text" class="form-control" id="marca_bien" name="marca_bien" placeholder="Ingrese la marca">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="modelo_bien">Modelo:</label>
                        <input type="text" class="form-control" id="modelo_bien" name="modelo_bien" placeholder="Ingrese el modelo">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="procesador_bien">Procesador:</label>
                        <input type="text" class="form-control" id="procesador_bien" name="procesador_bien" placeholder="Ingrese el procesador">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numdeserie_bien">Serie:</label>
                        <input type="text" class="form-control" id="numdeserie_bien" name="numdeserie_bien" placeholder="Ingrese el número de serie">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numcontropatri_bien">Control Patrimonial:</label>
                        <input type="text" class="form-control" id="numcontropatri_bien" name="numcontropatri_bien" placeholder="Ingrese el control patrimonial">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_bien">Estado del bien:</label>
                        <select class="form-control" id="estado_bien" name="estado_bien">
                            <option value="">Seleccione el estado</option>
                            <option value="1">Bueno</option>
                            <option value="2">Regular</option>
                            <option value="3">Malo</option>
                            <option value="4">Baja</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="funcionamiento">Funcionamiento:</label>
                        <select class="form-control" id="funcionamiento" name="funcionamiento">
                            <option value="">Seleccione el funcionamiento</option>
                            <option value="1">Operativo</option>
                            <option value="2">Inoperativo</option>
                            <option value="3">Regular</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="añodeadqs_bien">Año del bien:</label>
                        <input type="text" class="form-control" id="añodeadqs_bien" name="añodeadqs_bien" placeholder="Ingrese el año">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numdeordendecom_bien">Orden de Compra:</label>
                        <input type="text" class="form-control" id="numdeordendecom_bien" name="numdeordendecom_bien" placeholder="Ingrese la orden de compra">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="observacion_bien">Observación:</label>
                        <input type="text" class="form-control" id="observacion_bien" name="observacion_bien" placeholder="Ingrese observaciones">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="color_bien">Color:</label>
                        <input type="text" class="form-control" id="color_bien" name="color_bien" placeholder="Ingrese el color">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="piso_bien">Piso:</label>
                        <select class="form-control" id="piso_bien" name="piso_bien">
                            <option value="">Seleccione el piso</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="costo_bien">Costo:</label>
                <input type="text" class="form-control" id="costo_bien" name="costo_bien" placeholder="Ingrese el costo">
            </div>
        </div>

        <!-- Registrar Persona -->
        <h2 class="seccion-titulo" style="cursor: pointer;">👤 Registrar Persona</h2>
        <div class="seccion">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nomyap_persona">Nombre y Apellido:</label>
                        <input type="text" class="form-control" id="nomyap_persona" name="nomyap_persona" placeholder="Ingrese nombre y apellido">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dni_persona">DNI:</label>
                        <input type="text" class="form-control" id="dni_persona" name="dni_persona" placeholder="Ingrese el DNI">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cell_persona">Celular:</label>
                        <input type="text" class="form-control" id="cell_persona" name="cell_persona" placeholder="Ingrese el celular">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="correo_persona">Correo:</label>
                        <input type="email" class="form-control" id="correo_persona" name="correo_persona" placeholder="Ingrese el correo electrónico">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="cargo_persona">Cargo:</label>
                <input type="text" class="form-control" id="cargo_persona" name="cargo_persona" placeholder="Ingrese el cargo">
            </div>
        </div>

        <!-- Subida de archivos con control de carpetas -->
        <h2 class="seccion-titulo text-danger" style="cursor: pointer;">Crear Menús / Subir Archivos</h2>
        <div class="seccion border border-danger p-3 rounded bg-light">

            <p class="text-danger font-weight-bold">
                ⚠ Esta sección permite subir archivos que reemplazarán archivos existentes en diferentes carpetas del sistema.<br>
                Si el nombre coincide con un archivo existente, se realizará una copia en la subcarpeta <code>/backup_menu</code> correspondiente antes de sobrescribirlo.
            </p>

            <!-- Descripción general del menú -->
            <div class="form-group">
                <label for="descripcion_menu"><strong>Descripción del Menú:</strong></label>
                <input type="text" class="form-control" id="descripcion_menu" name="descripcion_menu" placeholder="Ej. Menú de usuarios, Menú de reportes...">
            </div>

            <!-- 1. Carpeta P -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="activar_p" class="form-check-input carpeta-toggle" id="check_p" data-target="#grupo_p">
                    <label class="form-check-label" for="check_p"><strong>Habilitar subida a carpeta P/</strong></label>
                </div>
                <div id="grupo_p">
                    <label for="nombrearchivo_menu">Archivos para carpeta <code>P/</code>:</label>
                    <input type="file" class="form-control-file border border-secondary p-2" id="nombrearchivo_menu" name="nombrearchivo_menu[]" multiple accept=".php">
                </div>
            </div>

            <!-- 2. Carpeta LN -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="activar_ln" class="form-check-input carpeta-toggle" id="check_ln" data-target="#grupo_ln">
                    <label class="form-check-label" for="check_ln"><strong>Habilitar subida a carpeta LN/</strong></label>
                </div>
                <div id="grupo_ln" style="display: none;">
                    <label for="nombrearchivo_ln">Archivos para carpeta <code>LN/</code>:</label>
                    <input type="file" class="form-control-file border border-secondary p-2" id="nombrearchivo_ln" name="nombrearchivo_ln[]" multiple>
                </div>
            </div>

            <!-- 3. Carpeta AD -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="activar_ad" class="form-check-input carpeta-toggle" id="check_ad" data-target="#grupo_ad">
                    <label class="form-check-label" for="check_ad"><strong>Habilitar subida a carpeta AD/</strong></label>
                </div>
                <div id="grupo_ad" style="display: none;">
                    <label for="nombrearchivo_ad">Archivos para carpeta <code>AD/</code>:</label>
                    <input type="file" class="form-control-file border border-secondary p-2" id="nombrearchivo_ad" name="nombrearchivo_ad[]" multiple>
                </div>
            </div>

            <!-- 4. Carpeta P/img -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="activar_img" class="form-check-input carpeta-toggle" id="check_img" data-target="#grupo_img">
                    <label class="form-check-label" for="check_img"><strong>Habilitar subida a carpeta P/img/</strong></label>
                </div>
                <div id="grupo_img" style="display: none;">
                    <label for="nombrearchivo_img">Archivos para carpeta <code>P/img/</code>:</label>
                    <input type="file" class="form-control-file border border-secondary p-2" id="nombrearchivo_img" name="nombrearchivo_img[]" multiple>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
    </form>
    <div id="mensaje" class="mt-3"></div>
</div>
</body>
</html>
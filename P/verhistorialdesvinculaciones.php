<?php
// Obtener la lista de movimientos y sus detalles desde la capa LN
session_start();
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_vermovimientos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Movimientos</title>

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

        .search-label {
            color: var(--text-gray);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            margin-top: 8px;
        }

        .search-input:focus + .search-icon {
            color: var(--primary-red);
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
            min-width: 1200px;
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
            vertical-align: middle;
        }

        .modern-table tbody td:last-child {
            border-right: none;
        }

        .modern-table tbody td:first-child {
            color: var(--primary-red);
            font-weight: 700;
        }

        .detalle-row {
            display: none;
            background: rgba(10, 10, 10, 0.95) !important;
        }

        .detalle-row:hover {
            background: rgba(10, 10, 10, 0.95) !important;
            transform: none !important;
        }

        .detalle-row td {
            padding: 0 !important;
        }

        .detalleContenido {
            padding: 25px;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
            border-radius: 15px;
            margin: 10px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .cerrarDetalle {
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
            font-size: 24px;
            color: var(--primary-red);
            font-weight: bold;
            transition: all 0.3s ease;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(185, 28, 28, 0.1);
            border-radius: 50%;
        }

        .cerrarDetalle:hover {
            color: var(--text-light);
            background: var(--primary-red);
            transform: rotate(90deg) scale(1.1);
        }

        /* Botones modernos */
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: var(--text-light);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 15px rgba(185, 28, 28, 0.3);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.4);
            color: var(--text-light);
            text-decoration: none;
        }

        .btn-modern:active {
            transform: translateY(-1px);
        }

        .btn-modern:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Enlaces modernos */
        .modern-link {
            color: var(--accent-red);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding: 4px 8px;
            border-radius: 6px;
            background: rgba(220, 38, 38, 0.1);
            font-size: 0.85rem;
        }

        .modern-link:hover {
            color: var(--text-light);
            background: var(--accent-red);
            transform: translateY(-1px);
            text-decoration: none;
        }

        .no-document {
            color: var(--text-muted);
            font-style: italic;
            font-size: 0.8rem;
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
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid var(--text-light);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .main-container {
                padding: 30px 15px;
            }

            .modern-table {
                font-size: 0.8rem;
                min-width: 1000px;
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

            .btn-modern {
                padding: 8px 14px;
                font-size: 0.75rem;
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
        .btn-modern:focus {
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
            <i class="fas fa-exchange-alt"></i>
            Sistema de Movimientos
        </h1>
        <p class="header-subtitle">Historial de desvinculaciones y reasignaciones</p>
    </div>

    <!-- Sección de controles -->
    <div class="controls-section">
        <div class="search-container">
            <label for="buscarReceptor" class="search-label">
                <i class="fas fa-search"></i> Buscar receptor
            </label>
            <input type="text" id="buscarReceptor" class="search-input" placeholder="Escribe el nombre del receptor...">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <!-- Contenedor de tabla -->
    <div class="table-container">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user-arrow-up"></i> TRANSFERENTE</th>
                    <th><i class="fas fa-user-arrow-down"></i> RECEPTOR</th>
                    <th><i class="fas fa-building"></i> DEPENDENCIA</th>
                    <th><i class="fas fa-building-flag"></i> DEPENDENCIA DESTINO</th>
                    <th><i class="fas fa-map-marker-alt"></i> ÁREA</th>
                    <th><i class="fas fa-map-marked-alt"></i> ÁREA DESTINO</th>
                    <th><i class="fas fa-calendar"></i> FECHA</th>
                    <th><i class="fas fa-file-alt"></i> DOCUMENTO</th>
                    <th><i class="fas fa-cogs"></i> ACCIONES</th>
                </tr>
                </thead>
                <tbody id="listaHistorialMovimientos">
                <?php foreach ($movimientosHistorial as $mov): ?>
                    <tr data-id="<?php echo $mov['id_movimiento_historial']; ?>">
                        <td><?php echo $mov['id_movimiento_historial']; ?></td>
                        <td title="<?php echo htmlspecialchars($mov['transferente']); ?>"><?php echo htmlspecialchars($mov['transferente']); ?></td>
                        <td title="<?php echo htmlspecialchars($mov['receptor']); ?>"><?php echo htmlspecialchars($mov['receptor']); ?></td>
                        <td title="<?php echo htmlspecialchars($mov['dependencia']); ?>"><?php echo htmlspecialchars($mov['dependencia']); ?></td>
                        <td title="<?php echo htmlspecialchars($mov['dependencia_destino']); ?>"><?php echo htmlspecialchars($mov['dependencia_destino']); ?></td>
                        <td title="<?php echo htmlspecialchars($mov['area_trans']); ?>"><?php echo htmlspecialchars($mov['area_trans']); ?></td>
                        <td title="<?php echo htmlspecialchars($mov['area_des']); ?>"><?php echo htmlspecialchars($mov['area_des']); ?></td>
                        <td><?php echo $mov['fecha_movimiento']; ?></td>
                        <td>
                            <?php if (!empty($mov['archivo_historial'])): ?>
                                <a href="../DOCS_REASIGNACIONES/<?php echo $mov['archivo_historial']; ?>" target="_blank" class="modern-link">
                                    <i class="fas fa-eye"></i> Ver archivo
                                </a>
                            <?php else: ?>
                                <span class="no-document">Sin documento</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="btn-modern btnVerDetalleHistorial" data-id="<?php echo $mov['id_movimiento_historial']; ?>">
                                <i class="fas fa-info-circle"></i>
                                Ver Detalle
                            </button>
                        </td>
                    </tr>
                    <tr class="detalle-row" id="detalle-historial-<?php echo $mov['id_movimiento_historial']; ?>">
                        <td colspan="10">
                            <div class="detalleContenido"></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Búsqueda mejorada
        $('#buscarReceptor').on('keyup', function() {
            const valor = $(this).val().toLowerCase().trim();
            const searchIcon = $('.search-icon');

            // Cambiar icono temporalmente
            searchIcon.removeClass('fa-search').addClass('fa-spinner fa-spin');

            setTimeout(function() {
                $('#listaHistorialMovimientos tr').each(function() {
                    if ($(this).hasClass('detalle-row')) return;

                    const coincide = $(this).text().toLowerCase().indexOf(valor) > -1;

                    if (coincide || valor === '') {
                        $(this).show();
                    } else {
                        $(this).hide();
                        // Ocultar también el detalle si está visible
                        const id = $(this).data('id');
                        $('#detalle-historial-' + id).hide();
                    }
                });

                // Restaurar icono
                searchIcon.removeClass('fa-spinner fa-spin').addClass('fa-search');
            }, 200);
        });

        // Manejo de detalles mejorado
        $(document).on('click', '.btnVerDetalleHistorial', function() {
            const idHistorial = $(this).data('id');
            const filaDetalle = $('#detalle-historial-' + idHistorial);
            const contenedorDetalle = filaDetalle.find('.detalleContenido');
            const button = $(this);

            // Si ya está visible, ocultarlo
            if (filaDetalle.is(':visible')) {
                filaDetalle.slideUp(400, function() {
                    contenedorDetalle.empty();
                });
                return;
            }

            // Cerrar otros detalles abiertos
            $('.detalle-row:visible').slideUp(300, function() {
                $(this).find('.detalleContenido').empty();
            });

            // Estado de carga
            const originalContent = button.html();
            button.html('<span class="loading-spinner"></span> Cargando...').prop('disabled', true);

            // Petición AJAX
            $.ajax({
                url: '../LN/ln_detalle_historial_reasignacion.php',
                method: 'POST',
                data: { id_historial: idHistorial },
                success: function(respuesta) {
                    contenedorDetalle.html(respuesta);
                    filaDetalle.slideDown(500);

                    // Agregar botón de cierre
                    const closeBtn = $('<span class="cerrarDetalle" title="Cerrar">&times;</span>');
                    contenedorDetalle.prepend(closeBtn);

                    // Manejar cierre
                    closeBtn.on('click', function() {
                        filaDetalle.slideUp(400, function() {
                            contenedorDetalle.empty();
                        });
                    });
                },
                error: function() {
                    contenedorDetalle.html(`
                        <div style="color: var(--danger-red); text-align: center; padding: 30px; background: rgba(239, 68, 68, 0.1); border-radius: 10px; margin: 10px;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 15px; display: block;"></i>
                            <strong>Error al cargar el detalle</strong>
                            <br><small style="color: var(--text-muted); margin-top: 10px; display: block;">Intente nuevamente más tarde</small>
                        </div>
                    `);
                    filaDetalle.slideDown(500);
                },
                complete: function() {
                    // Restaurar botón
                    button.html(originalContent).prop('disabled', false);
                }
            });
        });

        // Efecto de sombra en scroll
        $('.table-wrapper').on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            if (scrollTop > 0) {
                $('thead').css('box-shadow', '0 2px 10px rgba(0, 0, 0, 0.3)');
            } else {
                $('thead').css('box-shadow', 'none');
            }
        });
    });
</script>
</body>
</html>
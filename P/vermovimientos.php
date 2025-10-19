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
    <title>Ver Movimientos</title>
    <link href="../libreria/bootstrap.min.css" rel="stylesheet">
    <link href="../libreria/select2.min.css" rel="stylesheet"/>
    <script src="../libreria/jquery-3.6.0.min.js"></script>
    <script src="../libreria/select2.min.js"></script>
    <script src="../libreria/bootstrap.bundle.min.js"></script>

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

        .container {
            position: relative;
            z-index: 10;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-red), var(--primary-red));
            border-radius: 2px;
        }

        .search-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-subtle);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .search-container:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
        }

        .search-input {
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 12px;
            padding: 14px 20px;
            color: var(--text-light);
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
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

        .search-label {
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #movimientosTable {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            max-height: 70vh;
            overflow-y: auto;
            box-shadow: var(--shadow-subtle);
            scrollbar-width: thin;
            scrollbar-color: var(--primary-red) transparent;
        }

        #movimientosTable::-webkit-scrollbar {
            width: 8px;
        }

        #movimientosTable::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        #movimientosTable::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-red), var(--dark-red));
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        #movimientosTable::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead th {
            background: linear-gradient(135deg, var(--dark-bg), var(--card-bg));
            color: var(--text-light);
            font-weight: 700;
            padding: 20px 15px;
            text-align: left;
            font-size: 0.85rem;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 2px solid var(--primary-red);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        tbody tr:hover {
            background: rgba(185, 28, 28, 0.1);
            transform: translateX(3px);
        }

        tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.04);
        }

        tbody tr:nth-child(even):hover {
            background: rgba(185, 28, 28, 0.15);
        }

        tbody td {
            padding: 15px;
            color: var(--text-gray);
            font-size: 0.9rem;
            border: none;
            vertical-align: middle;
            font-weight: 500;
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            margin: 2px;
            box-shadow: var(--shadow-primary);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.4);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.5);
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .btn-warning {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }

        .btn-warning:hover {
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.5);
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .subirArchivoFirmado {
            background: linear-gradient(135deg, var(--card-bg), rgba(74, 74, 78, 0.8));
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 16px;
            color: var(--text-light);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .subirArchivoFirmado:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, rgba(74, 74, 78, 0.9), rgba(90, 90, 94, 0.9));
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-light);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border-bottom: 1px solid var(--border-color);
            padding: 25px 30px;
        }

        .modal-title {
            color: var(--text-light);
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.025em;
        }

        .btn-close {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            opacity: 0.8;
            transition: all 0.3s ease;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .btn-close:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.1);
        }

        .modal-body {
            padding: 30px;
            color: var(--text-light);
        }

        .modal-footer {
            background: rgba(15, 23, 42, 0.3);
            border-top: 1px solid var(--border-color);
            padding: 20px 30px;
        }

        .detalle-row td {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), var(--card-bg));
            backdrop-filter: blur(15px);
        }

        .detalleContenido {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
        }

        .cerrarDetalle {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: var(--text-light);
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-primary);
        }

        .cerrarDetalle:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.4);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .select2-container--default .select2-selection--single {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            height: 45px;
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-light);
            line-height: 45px;
            font-weight: 500;
        }

        .select2-dropdown {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            backdrop-filter: blur(20px);
        }

        .select2-results__option {
            color: var(--text-light);
            background: transparent;
            transition: all 0.3s ease;
            padding: 10px 15px;
        }

        .select2-results__option:hover {
            background: var(--primary-red);
        }

        .alert {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            backdrop-filter: blur(15px);
            color: var(--text-light);
            margin-bottom: 20px;
            padding: 15px 20px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(21, 128, 61, 0.2);
            border-color: rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .alert-warning {
            background: rgba(217, 119, 6, 0.2);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid var(--primary-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        /* Filas con desvinculados */
        tbody tr[style*="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2)"] {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(217, 119, 6, 0.1)) !important;
            border-left: 4px solid #f59e0b;
        }

        tbody tr[style*="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2)"]:hover {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(217, 119, 6, 0.2)) !important;
        }

        /* Links estilizados */
        a {
            color: var(--accent-red);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--light-red);
            text-decoration: underline;
        }

        a[style*="color: #60a5fa"] {
            color: #60a5fa !important;
        }

        a[style*="color: #60a5fa"]:hover {
            color: #93c5fd !important;
        }

        a[style*="color: #34d399"] {
            color: #34d399 !important;
        }

        a[style*="color: #34d399"]:hover {
            color: #6ee7b7 !important;
        }

        @media (max-width: 1024px) {
            .container {
                padding: 20px 15px;
            }

            table {
                font-size: 0.85rem;
            }

            thead th, tbody td {
                padding: 12px 8px;
            }
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 2rem;
            }

            .search-container {
                padding: 1.5rem;
            }

            table {
                font-size: 0.8rem;
            }

            thead th, tbody td {
                padding: 10px 6px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 0.7rem;
            }

            .modal-header, .modal-body, .modal-footer {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px 10px;
            }

            h2 {
                font-size: 1.8rem;
            }

            .search-container {
                padding: 1rem;
            }

            #movimientosTable {
                max-height: 60vh;
            }
        }
    </style>
</head>
<body>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="container mt-5 fade-in">
    <h2>Movimientos Realizados</h2>

    <div class="search-container">
        <label for="buscarReceptor" class="search-label">Buscador</label>
        <input type="text" id="buscarReceptor" class="search-input" placeholder="Ingresa al menos tres letras...">
    </div>

    <div id="movimientosTable" class="table-responsive">
        <table>
            <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 12%;">Transferente</th>
                <th style="width: 12%;">Receptor</th>
                <th style="width: 12%;">Dependencia</th>
                <th style="width: 12%;">Dep. Destino</th>
                <th style="width: 10%;">Área</th>
                <th style="width: 10%;">Área Destino</th>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 15%;">Documento</th>
                <th style="width: 14%;">Acciones</th>
            </tr>
            </thead>
            <tbody id="listaMovimientos">
            <?php foreach ($movimientosActualVer as $mov): ?>
                <?php
                $estilo = ($mov['tiene_desvinculado'] > 0)
                    ? 'background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(217, 119, 6, 0.2));'
                    : '';
                ?>
                <tr data-id="<?php echo $mov['id_movimiento']; ?>" style="<?php echo $estilo; ?>">
                    <td><?php echo $mov['id_movimiento']; ?></td>
                    <td><?php echo htmlspecialchars($mov['transferente']); ?></td>
                    <td><?php echo htmlspecialchars($mov['receptor']); ?></td>
                    <td><?php echo htmlspecialchars($mov['dependencia']); ?></td>
                    <td><?php echo htmlspecialchars($mov['dependencia_destino']); ?></td>
                    <td><?php echo htmlspecialchars($mov['area_trans']); ?></td>
                    <td><?php echo htmlspecialchars($mov['area_des']); ?></td>
                    <td><?php echo $mov['fecha_movimiento']; ?></td>
                    <td>
                        <?php if($mov['estado_movimiento'] == 0): ?>
                            <a href="../LN/ln_generar_documento.php?id_movimiento=<?php echo $mov['id_movimiento']; ?>" target="_blank" style="color: #60a5fa; text-decoration: none;">Generar documento</a><br><br>
                            <input type="file" class="form-control subirArchivoFirmadoPDF" name="subirArchivoFirmadoPDF" accept=".pdf" required>
                            <button class="subirArchivoFirmado">Subir Documento</button>
                        <?php else: ?>
                            <a href="../<?php echo $mov['archivo_movimiento']; ?>" target="_blank" style="color: #34d399; text-decoration: none;">Ver archivo</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm editar">Editar</button>
                        <button class="btn btn-primary btn-sm detalleVer">Detalle</button>
                    </td>
                </tr>
                <tr class="detalle-row" id="detalle-<?php echo $mov['id_movimiento']; ?>">
                    <td colspan="9">
                        <div class="detalleContenido">
                            <!-- El detalle del movimiento se cargará aquí -->
                        </div>
                    </td>
                    <td>
                        <button class="cerrarDetalle">&times;</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para Editar Movimiento -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <!-- El contenido se cargará aquí vía AJAX -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Desvincular Bienes -->
    <div class="modal fade" id="modalDesvincularBienes" tabindex="-1" aria-labelledby="modalDesvincularBienesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDesvincularBienesLabel">🔗 Desvincular Bienes Seleccionados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="contenidoDesvincular">
                    <!-- Aquí se cargará dinámicamente el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    $(document).ready(function() {
        hideLoading();

        // Asegurarse de que todas las filas de detalle estén ocultas al cargar
        $('.detalle-row').hide().removeClass('show');

        // Cargar movimientos según el número de filas seleccionado
        $('#numFilas').change(function() {
            showLoading();
            var numFilas = $(this).val();
            $.ajax({
                url: '../LN/ln_ver_movimientos.php',
                type: 'POST',
                data: { numFilas: numFilas },
                success: function(response) {
                    $('#listaMovimientos').html(response);
                    // Asegurar que las nuevas filas de detalle estén ocultas después de cambiar número de filas
                    $('.detalle-row').hide().removeClass('show');
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    alert("Error al cargar los movimientos.");
                }
            });
        });

        // Clic para mostrar el detalle del movimiento
        $(document).on('click', '.detalleVer', function(event) {
            event.preventDefault();
            showLoading();
            var id_movimientoDetalle = $(this).closest('tr').data('id');
            var detalleRow = $('#detalle-' + id_movimientoDetalle);

            // Si el detalle ya está visible, lo ocultamos
            if (detalleRow.hasClass('show')) {
                detalleRow.removeClass('show').hide();
                hideLoading();
                return;
            }

            // Cerrar otros detalles que estén abiertos
            $('.detalle-row').removeClass('show').hide();

            $.ajax({
                url: '../LN/ln_detallemovimiento.php',
                type: 'POST',
                data: { id_movimientoDetalle: id_movimientoDetalle },
                success: function(response) {
                    detalleRow.find('.detalleContenido').html(response);
                    // Mostrar el div debajo de la fila con animación
                    detalleRow.show().addClass('show');
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    alert("Error al cargar el detalle del movimiento.");
                }
            });
        });

        // Cerrar el detalle al hacer clic en la "X"
        $(document).on('click', '.cerrarDetalle', function() {
            $(this).closest('.detalle-row').removeClass('show').hide();
        });

        $(document).on('click', '.editar', function() {
            showLoading();
            var id_movimientoEdi = $(this).closest('tr').data('id');

            $.ajax({
                url: '../LN/ln_editar_movimiento.php',
                type: 'POST',
                data: { id_movimientoEdi: id_movimientoEdi },
                success: function(response) {
                    $('#modalContent').html(response);
                    $('#editarModal').modal('show');
                    hideLoading();

                    // Guardar cambios desde el modal
                    $('#guardarCambiosBtnX').on('click', function(){
                        showLoading();
                        var formData = new FormData($('#editarMovimientoForm')[0]);

                        $('#listaBienesAgregarX li').each(function() {
                            formData.append('bienes[]', $(this).data('id'));
                        });

                        $.ajax({
                            url: '../LN/ln_guardar_bienes.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                hideLoading();
                                if (response === 'success') {
                                    alert("Bienes agregados correctamente.");
                                    $('#editarModal').modal('hide');
                                    var id_movimiento = $('input[name="id_movimientoEdi"]').val();

                                    $.ajax({
                                        url: '../LN/ln_detallemovimiento.php',
                                        type: 'POST',
                                        data: { id_movimientoDetalle: id_movimiento },
                                        success: function(detalleResponse) {
                                            $('#detalle-' + id_movimiento).find('.detalleContenido').html(detalleResponse);
                                        },
                                        error: function() {
                                            alert("Error al actualizar los detalles del movimiento.");
                                        }
                                    });
                                } else {
                                    alert("Error al guardar los bienes.");
                                }
                            },
                            error: function() {
                                hideLoading();
                                alert("Error en la petición de guardado.");
                            }
                        });
                    });

                    // Abrir modal para agregar bien
                    $('#agregarBienBtnX').on('click', function() {
                        showLoading();
                        $.ajax({
                            url: '../LN/ln_listar_bienes.php',
                            success: function(response) {
                                $('#ModalAgregarBien').html(response);
                                $('#bienAgregar').select2({
                                    placeholder: "Seleccionar bien",
                                    allowClear: true,
                                    width: '100%',
                                    dropdownParent: $('#editarModal'),
                                    maximumSelectionLength: 5,
                                    dropdownAutoWidth: true,
                                    maximumInputLength: 100,
                                    minimumResultsForSearch: 5
                                });
                                hideLoading();

                                $('#agregarBienAgregarX').on('click', function() {
                                    var idBienSeleccionado = $('#bienAgregar').val();
                                    var textoBienSeleccionado = $('#bienAgregar option:selected').text();

                                    if (idBienSeleccionado) {
                                        var nuevoBien = $('<li class="list-group-item" data-id="' + idBienSeleccionado + '">' + textoBienSeleccionado + '</li>');
                                        $('#listaBienesAgregarX').append(nuevoBien);
                                        $('#bienAgregar').val('').trigger('change');
                                        $('#guardarCambiosBtnX').css('display', 'block');
                                        $('#eliminarMovimientoBtnX').css('display', 'none');
                                        $('#agregarBienBtnX').css('display', 'none');
                                    } else {
                                        alert("Por favor, selecciona un bien.");
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                hideLoading();
                                alert("Error al registrar el movimiento.");
                            }
                        });
                    });

                    // Eliminar movimiento
                    $('#eliminarMovimientoBtnX').on('click', function(){
                        if (confirm("¿Estás seguro de que deseas eliminar este movimiento?")) {
                            showLoading();
                            var idMovimiento = $('#editarMovimientoForm input[name="id_movimientoEdi"]').val();

                            $.ajax({
                                url: '../LN/ln_eliminar_movimiento.php',
                                type: 'POST',
                                data: { idMovimiento: idMovimiento },
                                success: function(response) {
                                    hideLoading();
                                    if (response === 'success') {
                                        alert("Movimiento eliminado correctamente.");
                                        $('#editarModal').modal('hide');
                                        cargarListaMovimientos();
                                    } else {
                                        alert("Error al eliminar el movimiento.");
                                    }
                                },
                                error: function() {
                                    hideLoading();
                                    alert("Error en la petición de eliminación del movimiento.");
                                }
                            });
                        }
                    });
                },
                error: function() {
                    hideLoading();
                    alert("Error al cargar el formulario de edición.");
                }
            });
        });

        // Eliminar bien
        $(document).on('click', '.eliminarBien', function() {
            var bienID = $(this).data('id');
            var bienRow = $(this).closest('tr');

            if (confirm("¿Estás seguro de que deseas eliminar este bien?")) {
                showLoading();
                $.ajax({
                    url: '../LN/ln_eliminar_bien.php',
                    type: 'POST',
                    data: { bienID: bienID, id_movimiento: $('#editarMovimientoForm input[name="id_movimientoEdi"]').val() },
                    success: function(response) {
                        hideLoading();
                        if (response === 'success') {
                            bienRow.remove();
                            if ($('#tablaBienesAsociados tr').length === 0) {
                                $('#eliminarMovimientoBtnX').show();
                            }
                        } else {
                            alert("Error al eliminar el bien.");
                        }
                    },
                    error: function() {
                        hideLoading();
                        alert("Error en la petición de eliminación.");
                    }
                });
            }
        });

        // Escuchar cambios en el campo de búsqueda
        $('#buscarReceptor').on('keyup', function() {
            var query = $(this).val();
            showLoading();

            $.ajax({
                url: '../LN/ln_ver_movimientos_tipeo.php',
                type: 'POST',
                data: { search: query },
                success: function(response) {
                    $('#listaMovimientos').html(response);
                    // Asegurar que las nuevas filas de detalle estén ocultas después de la búsqueda
                    $('.detalle-row').hide().removeClass('show');
                    hideLoading();
                },
                error: function() {
                    hideLoading();
                    alert("Error al buscar los movimientos.");
                }
            });
        });

        // SUBIR EL PDF
        $(document).on('click', '.subirArchivoFirmado', function() {
            const row = $(this).closest("tr");
            const id_movimiento = row.data("id");
            const fileInput = row.find(".subirArchivoFirmadoPDF")[0];

            if (fileInput && fileInput.files.length > 0) {
                showLoading();
                const formData = new FormData();
                formData.append("archivo_movimiento", fileInput.files[0]);
                formData.append("id_movimientoA", id_movimiento);

                $.ajax({
                    url: "../LN/ln_actualizarDoc_movimiento.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        hideLoading();
                        cargarListaMovimientos();
                    },
                    error: function() {
                        hideLoading();
                        alert("Hubo un problema al subir el archivo.");
                    }
                });
            } else {
                alert("Por favor, selecciona un archivo PDF.");
            }
        });

        function cargarListaMovimientos() {
            showLoading();
            var numFilas = $('#numFilas').val();
            $.ajax({
                url: '../LN/ln_ver_movimientos.php',
                type: 'POST',
                data: { numFilas: numFilas },
                success: function(response) {
                    $('#listaMovimientos').html(response);
                    // Asegurar que las nuevas filas de detalle estén ocultas
                    $('.detalle-row').hide().removeClass('show');
                    hideLoading();
                },
                error: function() {
                    hideLoading();
                    alert("Error al cargar los movimientos.");
                }
            });
        }

        $(document).off('click', '#btnDesvincular').on('click', '#btnDesvincular', function () {
            const checkboxes = document.querySelectorAll('.checkboxBien:checked');
            if (checkboxes.length === 0) {
                alert("Por favor, selecciona al menos un bien para desvincular.");
                return;
            }

            if (confirm("¿Estás seguro de que deseas desvincular estos bienes?")) {
                showLoading();
                const idsSeleccionados = Array.from(checkboxes).map(cb => cb.value);

                $.ajax({
                    url: '../LN/ln_modal_desvincular.php',
                    type: 'POST',
                    data: {
                        ids_bienes: idsSeleccionados,
                        id_movimiento: $('input[name="id_movimientoEdi"]').val()
                    },
                    success: function(response) {
                        $('#contenidoDesvincular').html(response);
                        $('#modalDesvincularBienes').modal('show');
                        hideLoading();
                    },
                    error: function() {
                        hideLoading();
                        alert("Error al cargar el modal de desvinculación.");
                    }
                });
            }
        });

        $(document).on('submit', '#formDesvincularBienes', function(e) {
            e.preventDefault();
            const fileInput = $('input[name="archivo_actual"]')[0];

            if (!fileInput.disabled && fileInput.files.length === 0) {
                $('#mensajeDesvinculacion').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>⚠️ Atención:</strong> Debe adjuntar un archivo PDF antes de continuar.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                    `);
                return;
            }

            showLoading();
            const formData = new FormData(this);

            $.ajax({
                url: '../LN/ln_guardar_desvinculacion.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(resp) {
                    hideLoading();
                    if (resp.trim() === 'ok') {
                        $('#mensajeDesvinculacion').html(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>✅ ¡Éxito!</strong> Los bienes fueron reasignados correctamente.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                                </div>
                            `);

                        setTimeout(() => {
                            $('#modalDesvincularBienes').modal('hide');
                            location.reload();
                        }, 2000);
                    } else {
                        $('#mensajeDesvinculacion').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>❌ Error:</strong> ${resp}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                                </div>
                            `);
                    }
                },
                error: function() {
                    hideLoading();
                    $('#mensajeDesvinculacion').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>❌ Error:</strong> Hubo un problema al procesar la solicitud.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        `);
                }
            });
        });

        // Add smooth scrolling for table
        $('#movimientosTable').on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const maxScroll = $(this)[0].scrollHeight - $(this).outerHeight();
            const scrollPercent = scrollTop / maxScroll;

            // Add glow effect based on scroll position
            const glowIntensity = scrollPercent * 0.3;
            $(this).css('box-shadow', `0 8px 32px rgba(186, 28, 28, ${glowIntensity})`);
        });

        // Add hover effects for table rows
        $(document).on('mouseenter', 'tbody tr', function() {
            $(this).css('transform', 'translateX(5px)');
        }).on('mouseleave', 'tbody tr', function() {
            $(this).css('transform', 'translateX(0)');
        });

        // Add click effect for buttons
        $(document).on('mousedown', '.btn', function() {
            $(this).css('transform', 'translateY(-2px) scale(0.98)');
        }).on('mouseup mouseleave', '.btn', function() {
            $(this).css('transform', 'translateY(-2px) scale(1)');
        });
    });
</script>
</body>
</html>
<?php
require_once '../cache_control.php'; // Solo esto
require_once '../LN/ln_listaR.php'; // Incluye la lógica de negocio
$areas = obtener_areas();
$dependencia = obtener_dependencias();
$bienes = obtener_bienes();
$persona = obtener_personas();
$menus = obtener_menuss();
$nombres_bien = obtener_nombre_bien();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Registros - Dashboard Moderno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../libreria/gsap.min.js"></script>
    <link rel="stylesheet" href="../libreria/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../libreria/css-y-js-listarR/Estilos_ListarR.css">


    <style>
        /* Variables CSS adaptadas del login */
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
            color: var(--text-light);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ==== MODAL STYLES - Adaptado del login ==== */
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        /* Modal Content - Estilo del login */
        .modal-content {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-primary), var(--shadow-subtle);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            position: relative;
            max-width: 520px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.8) translateY(50px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .modal.active .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            border-radius: 20px 20px 0 0;
        }

        /* Close Button */
        .close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: var(--text-muted);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .close:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(185, 28, 28, 0.1));
            border-color: var(--accent-red);
            color: var(--light-red);
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.3);
        }

        /* Modal Title */
        .modal-content h2 {
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 30px 0;
            text-align: center;
            letter-spacing: -0.025em;
            position: relative;
        }

        .modal-content h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            border-radius: 2px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--text-light);
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Controls - Estilo del login */
        .form-control {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 0;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* File Input */
        input[type="file"] {
            position: relative;
            overflow: hidden;
        }

        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border: none;
            border-radius: 8px;
            color: white;
            padding: 8px 16px;
            margin-right: 15px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.3);
        }

        /* Current File Display */
        #archivo-actual {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--text-gray);
            font-size: 14px;
            margin: 0;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        /* Botones - Estilo del login */
        .modern-btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 28px;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-primary);
            margin: 5px;
        }

        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(185, 28, 28, 0.35);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        .modern-btn:active {
            transform: translateY(0);
        }

        .modern-btn i {
            margin-right: 8px;
        }

        /* Variantes de botones */
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.25);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            box-shadow: 0 8px 28px rgba(245, 158, 11, 0.35);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.25);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 8px 28px rgba(220, 38, 38, 0.35);
        }

        .btn-primary {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 8px 28px rgba(5, 150, 105, 0.35);
        }

        .btn-activate {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.25);
        }

        .btn-activate:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 8px 28px rgba(5, 150, 105, 0.35);
        }

        .btn-deactivate {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            box-shadow: 0 4px 20px rgba(107, 114, 128, 0.25);
        }

        .btn-deactivate:hover {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
            box-shadow: 0 8px 28px rgba(107, 114, 128, 0.35);
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

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-content {
                padding: 30px 20px;
                margin: 20px;
                max-width: none;
            }

            .modal-content h2 {
                font-size: 1.5rem;
            }

            .modern-btn {
                padding: 12px 24px;
                font-size: 0.875rem;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .modal-content,
            .modern-btn,
            .close,
            .form-control {
                transition: none;
            }

            .modal-content {
                transform: none;
            }

            .modern-btn::before {
                display: none;
            }
        }

        /* Focus Management */
        .modal:focus-within .modal-content {
            outline: 2px solid var(--primary-red);
            outline-offset: 4px;
        }

        /* Error message styling */
        p[style*="color: red"] {
            background: rgba(185, 28, 28, 0.1);
            border: 1px solid var(--primary-red);
            border-radius: 8px;
            padding: 12px 16px;
            margin: 16px 0;
            color: var(--accent-red) !important;
            text-align: center;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Animaciones de entrada suaves */
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

</head>
<body>

<div class="main-container">
    <!-- Header -->
    <div class="header">
        <h1 class="main-title">
            <i class="fas fa-database"></i>
            Gestión de Registros
        </h1>
        <p class="subtitle">Dashboard administrativo para la gestión de áreas, dependencias, personas y menús</p>
    </div>

    <!-- Estadísticas generales -->
    <div class="stats-container">
        <div class="stat-card">
            <span class="stat-number" id="totalAreas"><?php echo count($areas); ?></span>
            <div class="stat-label">Áreas Totales</div>
        </div>
        <div class="stat-card">
            <span class="stat-number" id="totalDependencias"><?php echo count($dependencia); ?></span>
            <div class="stat-label">Dependencias</div>
        </div>
        <div class="stat-card">
            <span class="stat-number" id="totalPersonas"><?php echo count($persona); ?></span>
            <div class="stat-label">Personas</div>
        </div>
        <div class="stat-card">
            <span class="stat-number" id="totalMenus"><?php echo count($menus); ?></span>
            <div class="stat-label">Menús</div>
        </div>
    </div>

    <div class="search-controls" style="display: flex; justify-content: flex-end;">
        <button class="toggle-all-btn" id="toggleAll">
            <i class="fas fa-expand-arrows-alt"></i>
            Expandir Todo
        </button>
    </div>

    <br>


    <!-- Contenedor de tablas -->
    <div class="tables-container">
        <!-- Tabla de Áreas -->
        <div class="table-accordion" data-table="areas">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <div class="accordion-title">
                    <i class="fas fa-map-marker-alt accordion-icon"></i>
                    Áreas
                </div>
                <div class="accordion-meta">
                        <span class="record-count">
                            <span class="count-number"><?php echo count($areas); ?></span> registros
                        </span>
                    <i class="fas fa-chevron-down chevron"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="table-search-container">
                    <input type="text" class="table-search-input" placeholder="Buscar..." onkeyup="filtrarTabla(this)">
                </div>
                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                        <tr>
                            <th><i class="fas fa-edit"></i> Descripción</th>
                            <th><i class="fas fa-edit"></i> Organo</th>
                            <th><i class="fas fa-edit"></i> Especialidad</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($areas as $area): ?>
                            <tr>
                                <td contenteditable="true" onBlur="actualizarRegistro('area', '<?php echo $area['id_area']; ?>', 'descripcion_area', this.innerText)">
                                    <?php echo $area['descripcion_area']; ?>
                                </td>
                                <td contenteditable="true" onBlur="actualizarRegistro('area', '<?php echo $area['id_area']; ?>', 'organo', this.innerText)">
                                    <?php echo $area['organo']; ?>
                                </td>
                                <td contenteditable="true" onBlur="actualizarRegistro('area', '<?php echo $area['id_area']; ?>', 'especialidad', this.innerText)">
                                    <?php echo $area['especialidad']; ?>
                                </td>
                                <td>
                                        <span class="status-badge <?php echo $area['estado_area'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $area['estado_area'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                </td>
                                <td>
                                    <button onclick="cambiarEstado('area', '<?php echo $area['id_area']; ?>', '<?php echo $area['estado_area'] == 1 ? 0 : 1; ?>')" class="modern-btn <?php echo $area['estado_area'] == 1 ? 'btn-deactivate' : 'btn-activate'; ?>">
                                        <i class="fas fa-<?php echo $area['estado_area'] == 1 ? 'pause' : 'play'; ?>"></i>
                                        <?php echo $area['estado_area'] == 1 ? 'Inactivar' : 'Activar'; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabla de Dependencias -->
        <div class="table-accordion" data-table="dependencias">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <div class="accordion-title">
                    <i class="fas fa-building accordion-icon"></i>
                    Dependencias
                </div>
                <div class="accordion-meta">
                        <span class="record-count">
                            <span class="count-number"><?php echo count($dependencia); ?></span> registros
                        </span>
                    <i class="fas fa-chevron-down chevron"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="table-search-container">
                    <input type="text" class="table-search-input" placeholder="Buscar..." onkeyup="filtrarTabla(this)">
                </div>

                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                        <tr>
                            <th><i class="fas fa-edit"></i> Descripción</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dependencia as $dep): ?>
                            <tr>
                                <td contenteditable="true" onBlur="actualizarRegistro('dependencia', '<?php echo $dep['id_dependencia']; ?>', 'descripcion_dependencia', this.innerText)">
                                    <?php echo $dep['descripcion_dependencia']; ?>
                                </td>
                                <td>
                                        <span class="status-badge <?php echo $dep['estado_dependencia'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $dep['estado_dependencia'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                </td>
                                <td>
                                    <button onclick="cambiarEstado('dependencia', '<?php echo $dep['id_dependencia']; ?>', '<?php echo $dep['estado_dependencia'] == 1 ? 0 : 1; ?>')" class="modern-btn <?php echo $dep['estado_dependencia'] == 1 ? 'btn-deactivate' : 'btn-activate'; ?>">
                                        <i class="fas fa-<?php echo $dep['estado_dependencia'] == 1 ? 'pause' : 'play'; ?>"></i>
                                        <?php echo $dep['estado_dependencia'] == 1 ? 'Inactivar' : 'Activar'; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabla de Menús -->
        <div class="table-accordion" data-table="menus">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <div class="accordion-title">
                    <i class="fas fa-list accordion-icon"></i>
                    Menús
                </div>
                <div class="accordion-meta">
                        <span class="record-count">
                            <span class="count-number"><?php echo count($menus); ?></span> registros
                        </span>
                    <i class="fas fa-chevron-down chevron"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="table-search-container">
                    <input type="text" class="table-search-input" placeholder="Buscar..." onkeyup="filtrarTabla(this)">
                </div>

                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                        <tr>
                            <th><i class="fas fa-edit"></i> Descripción</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td contenteditable="true" onBlur="actualizarRegistro('menu', '<?php echo $menu['id_menu']; ?>', 'descripcion_menu', this.innerText)">
                                    <?php echo $menu['descripcion_menu']; ?>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $menu['estado_menu'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $menu['estado_menu'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (trim($menu['descripcion_menu']) != 'Ver registros / Editar'): ?>
                                        <button onclick="cambiarEstado('menu', '<?php echo $menu['id_menu']; ?>', '<?php echo $menu['estado_menu'] == 1 ? 0 : 1; ?>')" class="modern-btn <?php echo $menu['estado_menu'] == 1 ? 'btn-deactivate' : 'btn-activate'; ?>">
                                            <i class="fas fa-<?php echo $menu['estado_menu'] == 1 ? 'pause' : 'play'; ?>"></i>
                                            <?php echo $menu['estado_menu'] == 1 ? 'Inactivar' : 'Activar'; ?>
                                        </button>
                                    <?php endif; ?>

                                    <button
                                            onclick="abrirModalEditar(this)"
                                            class="modern-btn btn-edit"
                                            data-id="<?php echo $menu['id_menu']; ?>"
                                            data-descripcion="<?php echo htmlspecialchars($menu['descripcion_menu']); ?>"
                                            data-archivo="<?php echo htmlspecialchars($menu['nombrearchivo_menu']); ?>"
                                    >
                                        <i class="fas fa-pen"></i> Editar
                                    </button>

                                    <?php if ($menu['asignado'] == 0): ?>
                                        <button
                                                onclick="eliminarRegistro('menu', '<?php echo $menu['id_menu']; ?>')"
                                                class="modern-btn btn-delete"
                                        >
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Tabla de Personas -->
        <div class="table-accordion" data-table="personas">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <div class="accordion-title">
                    <i class="fas fa-users accordion-icon"></i>
                    Personas
                </div>
                <div class="accordion-meta">
                        <span class="record-count">
                            <span class="count-number"><?php echo count($persona); ?></span> registros
                        </span>
                    <i class="fas fa-chevron-down chevron"></i>
                </div>
            </div>
            <div class="accordion-content">
                <div class="table-search-container">
                    <input type="text" class="table-search-input" placeholder="Buscar..." onkeyup="filtrarTabla(this)">
                </div>

                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Nombre y Apellido</th>
                            <th><i class="fas fa-id-card"></i> DNI</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($persona as $per): ?>
                            <tr>
                                <td contenteditable="true" onBlur="actualizarRegistro('persona', '<?php echo $per['id_persona']; ?>', 'nomyap_persona', this.innerText)">
                                    <?php echo $per['nomyap_persona']; ?>
                                </td>
                                <td contenteditable="true" onBlur="actualizarRegistro('persona', '<?php echo $per['id_persona']; ?>', 'dni_persona', this.innerText)">
                                    <?php echo $per['dni_persona']; ?>
                                </td>
                                <td>
                                        <span class="status-badge <?php echo $per['estado_persona'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $per['estado_persona'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                </td>
                                <td>
                                    <button onclick="cambiarEstado('persona', '<?php echo $per['id_persona']; ?>', '<?php echo $per['estado_persona'] == 1 ? 0 : 1; ?>')" class="modern-btn <?php echo $per['estado_persona'] == 1 ? 'btn-deactivate' : 'btn-activate'; ?>">
                                        <i class="fas fa-<?php echo $per['estado_persona'] == 1 ? 'pause' : 'play'; ?>"></i>
                                        <?php echo $per['estado_persona'] == 1 ? 'Inactivar' : 'Activar'; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Tabla de Nombres de Bien -->
        <div class="table-accordion" data-table="nombre_bien">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <div class="accordion-title">
                    <i class="fas fa-tag accordion-icon"></i>
                    Categorias
                </div>
                <div class="accordion-meta">
                <span class="record-count">
                    <span class="count-number"><?php echo count($nombres_bien); ?></span> registros
                </span>
                    <i class="fas fa-chevron-down chevron"></i>
                </div>
            </div>
            <div class="accordion-content">

                <!--  Contenedor flex para alinear botón y buscador -->
                <div class="table-header-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; margin-top: 20px;">
                    <!--  Botón Agregar Categoría -->
                    <div class="table-action-button-container">
                        <button onclick="abrirModalAgregarNombreBien()" class="modern-btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar Categoría
                        </button>
                    </div>

                    <div class="table-search-container">
                        <input type="text" class="table-search-input" placeholder="Buscar..." onkeyup="filtrarTabla(this)">
                    </div>
                </div>


                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                        <tr>
                            <th><i class="fas fa-edit"></i> Descripción</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nombres_bien as $nb): ?>
                            <tr>
                                <td contenteditable="true" onBlur="actualizarRegistro('nombre_bien', '<?php echo $nb['id_nombre_bien']; ?>', 'des_nombre_bien', this.innerText)">
                                    <?php echo $nb['des_nombre_bien']; ?>
                                </td>
                                <td>
                            <span class="status-badge <?php echo $nb['estado_nombre_bien'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $nb['estado_nombre_bien'] == 1 ? 'Activo' : 'Inactivo'; ?>
                            </span>
                                </td>
                                <td>
                                    <button onclick="cambiarEstado('nombre_bien', '<?php echo $nb['id_nombre_bien']; ?>', '<?php echo $nb['estado_nombre_bien'] == 1 ? 0 : 1; ?>')" class="modern-btn <?php echo $nb['estado_nombre_bien'] == 1 ? 'btn-deactivate' : 'btn-activate'; ?>">
                                        <i class="fas fa-<?php echo $nb['estado_nombre_bien'] == 1 ? 'pause' : 'play'; ?>"></i>
                                        <?php echo $nb['estado_nombre_bien'] == 1 ? 'Inactivar' : 'Activar'; ?>
                                    </button>

                                    <button onclick="abrirModalEditarNombreBien(this)" class="modern-btn btn-edit"
                                            data-id="<?php echo $nb['id_nombre_bien']; ?>"
                                            data-descripcion="<?php echo htmlspecialchars($nb['des_nombre_bien']); ?>">
                                        <i class="fas fa-pen"></i> Editar
                                    </button>

                                    <button onclick="eliminarRegistroNombreBien('nombre_bien', '<?php echo $nb['id_nombre_bien']; ?>')" class="modern-btn btn-delete">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Modal Editar Menú -->
    <div id="modal-editar" class="modal" style="display:none;" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-content" role="document">
            <button class="close" onclick="cerrarModalEditar()" aria-label="Cerrar modal">&times;</button>
            <h2 id="modal-title">Editar Menú</h2>
            <form id="form-editar-menu" enctype="multipart/form-data">
                <input type="hidden" id="editar-id" name="id_menu">
                <div class="form-group">
                    <label for="editar-descripcion">Descripción:</label>
                    <input type="text" id="editar-descripcion" name="descripcion_menu" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Archivo Actual:</label>
                    <p id="archivo-actual"></p>
                </div>
                <div class="form-group">
                    <label for="editar-archivo">Actualizar Archivo:</label>
                    <input type="file" id="editar-archivo" name="nombrearchivo_menu" class="form-control" multiple accept=".php">
                </div>
                <!-- Nuevos campos añadidos -->
                <div class="form-group">
                    <label for="editar-ln">Actualizar Archivo LN (.php):</label>
                    <input type="file" id="editar-ln" name="nombrearchivo_ln" class="form-control" accept=".php">
                </div>
                <div class="form-group">
                    <label for="editar-ad">Actualizar Archivo AD (.php):</label>
                    <input type="file" id="editar-ad" name="nombrearchivo_ad" class="form-control" accept=".php">
                </div>
                <div class="form-group">
                    <label for="editar-img">Actualizar Imagen:</label>
                    <input type="file" id="editar-img" name="nombrearchivo_img" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editar-js">Actualizar JS:</label>
                    <input type="file" id="editar-js" name="nombrearchivo_js" class="form-control" accept=".js">
                </div>
                <button type="submit" class="modern-btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>


<!-- Modal Editar Nombre Bien -->
<div id="modal-editar-nombre-bien" class="modal" style="display:none;" role="dialog" aria-labelledby="modal-nb-title" aria-hidden="true">
    <div class="modal-content" role="document">
        <button class="close" onclick="cerrarModalEditarNombreBien()" aria-label="Cerrar modal">&times;</button>
        <h2 id="modal-nb-title">Editar Nombre del Bien</h2>
        <form id="form-editar-nombre-bien">
            <input type="hidden" id="editar-id-nb" name="id_nombre_bien">
            <div class="form-group">
                <label for="editar-descripcion-nb">Descripción:</label>
                <input type="text" id="editar-descripcion-nb" name="des_nombre_bien" class="form-control" required>
            </div>
            <button type="submit" class="modern-btn btn-primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>

<!-- Modal Agregar Nombre de Bien -->
<div id="modal-agregar-nombrebien" class="modal" style="display:none;" role="dialog" aria-labelledby="modal-title-nb">
    <div class="modal-content" role="document">
        <button class="close" onclick="cerrarModalAgregarNombreBien()" aria-label="Cerrar modal">&times;</button>
        <h2 id="modal-title-nb">Agregar Nueva Categoria</h2>
        <form id="form-agregar-nombrebien">
            <div class="form-group">
                <label for="nuevonombrebien">Descripción:</label>
                <input type="text" id="nuevonombrebien" name="des_nombre_bien" class="form-control" required>
            </div>
            <button type="submit" class="modern-btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </form>
    </div>
</div>







<!-- Scripts JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../libreria/css-y-js-listarR/listarR.js"></script>
</body>
</html>
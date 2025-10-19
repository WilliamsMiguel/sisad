<?php
// P/principal.php
require_once '../cache_control.php'; // Solo esto
include '../LN/ln.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Obtener datos del usuario
$persona = obtener_datos_personaLN($_SESSION['id_persona_usuario']);
$estado_usuario = $_SESSION['estado_usuario']; // Necesitamos agregar esto desde ln.php
$id_usuario = $_SESSION['id_usuario'];         // Necesitamos agregar esto también

// Obtener menús según el tipo de usuario
if ($estado_usuario == 1) {
    $menus = listar_menus_activos(); // Superusuario: todos los menús
} else {
    $menus = listar_menus_por_usuarioLN($id_usuario); // Editor: solo menús asignados
}

// Recuperar los datos de la persona
$persona = obtener_datos_personaLN($_SESSION['id_persona_usuario']);

if ($persona) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>SISAD - Sistema de Asignación y Desplazamiento - NCPPP</title>
        <link href="../libreria/bootstrap.min.css" rel="stylesheet">
        <script src="../libreria/jquery-3.6.0.min.js"></script>
        <link rel="icon" href="img/pj.png" type="image/x-icon">
        <link href="../libreria/fontawesome/css/all.min.css" rel="stylesheet">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

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
                background: linear-gradient(135deg, #0f172a 0%, #1e293b  50%, #0f1419 100%);
                min-height: 100vh;
                color: var(--text-light);
                position: relative;
            }

            .container-fluid {
                height: 100vh;
                position: relative;
            }

            /* Sidebar Styles */
            .sidebar {
                background: var(--card-bg);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-right: 1px solid var(--border-color);
                height: 100vh;
                padding: 0;
                position: relative;
                box-shadow: var(--shadow-subtle);
            }

            .sidebar::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 2px;
                background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
                border-radius: 20px 20px 0 0;
            }

            .user-section {
                padding: 2rem 1.5rem;
                border-bottom: 1px solid var(--border-color);
                position: relative;
            }

            .logout-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: rgba(185, 28, 28, 0.1);
                border: 1px solid var(--primary-red);
                color: var(--accent-red);
                padding: 0.5rem 1rem;
                border-radius: 8px;
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .logout-btn:hover {
                background: var(--primary-red);
                color: white;
                transform: translateY(-1px);
                box-shadow: var(--shadow-primary);
                text-decoration: none;
            }

            .welcome-text {
                font-size: 0.875rem;
                color: var(--text-muted);
                margin-bottom: 0.5rem;
                font-weight: 400;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .user-name {
                font-size: 1.125rem;
                font-weight: 600;
                color: var(--text-light);
            }

            /* Menu Styles */
            .menu-container {
                padding: 1.5rem 1rem;
                height: calc(100vh - 120px);
                overflow-y: auto;
            }

            .menu-container::-webkit-scrollbar {
                width: 6px;
            }

            .menu-container::-webkit-scrollbar-track {
                background: transparent;
            }

            .menu-container::-webkit-scrollbar-thumb {
                background: var(--primary-red);
                border-radius: 3px;
            }

            .menu-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .menu-item {
                margin-bottom: 0.5rem;
            }

            .menu-link {
                display: flex;
                align-items: center;
                padding: 1rem 1.25rem;
                background: rgba(255, 255, 255, 0.04);
                border: 1.5px solid transparent;
                border-radius: 12px;
                color: var(--text-gray);
                text-decoration: none;
                font-weight: 500;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                position: relative;
            }

            .menu-link:hover {
                background: rgba(255, 255, 255, 0.08);
                border-color: var(--primary-red);
                color: var(--text-light);
                transform: translateX(4px);
                text-decoration: none;
            }

            .menu-link i {
                width: 20px;
                margin-right: 12px;
                text-align: center;
            }

            .menu-activo {
                background: linear-gradient(135deg, var(--primary-red), var(--dark-red)) !important;
                border-color: var(--primary-red) !important;
                color: white !important;
                transform: translateX(4px) !important;
                box-shadow: var(--shadow-primary) !important;
            }

            /* Content Area */
            .content-area {
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                height: 100vh;
                padding: 0;
                border-left: 1px solid var(--border-color);
                position: relative;
            }

            .content-header {
                background: var(--card-bg);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border-bottom: 1px solid var(--border-color);
                padding: 1.5rem 2rem;
                position: relative;
            }

            .content-header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
            }

            .content-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-light);
                margin: 0;
                background: linear-gradient(135deg, var(--light-red), var(--primary-red));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .content-subtitle {
                font-size: 0.875rem;
                color: var(--text-muted);
                margin-top: 0.25rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .content-body {
                padding: 2rem;
                height: calc(100vh - 100px);
                overflow-y: auto;
                position: relative;
            }

            .content-body::-webkit-scrollbar {
                width: 8px;
            }

            .content-body::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 4px;
            }

            .content-body::-webkit-scrollbar-thumb {
                background: var(--primary-red);
                border-radius: 4px;
            }

            /* Modal Styles */
            .modal {
                z-index: 9999 !important;
            }

            .modal-backdrop {
                z-index: 9998 !important;
                backdrop-filter: blur(10px) !important;
                background-color: rgba(0, 0, 0, 0.8) !important;
            }

            .modal-content {
                background: var(--card-bg) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 1px solid var(--border-color) !important;
                border-radius: 20px !important;
                box-shadow: var(--shadow-primary), var(--shadow-subtle) !important;
            }

            .modal-header {
                background: rgba(15, 23, 42, 0.8) !important;
                border-bottom: 1px solid var(--border-color) !important;
                border-radius: 20px 20px 0 0 !important;
            }

            .modal-header .modal-title {
                color: var(--text-light) !important;
                font-weight: 600 !important;
            }

            .modal-body {
                color: var(--text-gray) !important;
                background: transparent !important;
            }

            .modal-footer {
                background: rgba(15, 23, 42, 0.4) !important;
                border-top: 1px solid var(--border-color) !important;
                border-radius: 0 0 20px 20px !important;
            }

            .btn-close {
                background: transparent !important;
                border: none !important;
                color: var(--text-light) !important;
                font-size: 1.5rem !important;
                opacity: 0.8 !important;
            }

            .btn-close:hover {
                opacity: 1 !important;
                color: var(--accent-red) !important;
            }

            .modal .btn-primary {
                background: linear-gradient(135deg, var(--primary-red), var(--dark-red)) !important;
                border: none !important;
                border-radius: 8px !important;
                font-weight: 500 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                transition: all 0.3s ease !important;
            }

            .modal .btn-primary:hover {
                background: linear-gradient(135deg, var(--light-red), var(--primary-red)) !important;
                transform: translateY(-1px) !important;
                box-shadow: var(--shadow-primary) !important;
            }

            .modal .btn-secondary {
                background: rgba(148, 163, 184, 0.2) !important;
                border: 1px solid var(--border-color) !important;
                color: var(--text-light) !important;
                border-radius: 8px !important;
                font-weight: 500 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                transition: all 0.3s ease !important;
            }

            .modal .btn-secondary:hover {
                background: rgba(148, 163, 184, 0.3) !important;
                transform: translateY(-1px) !important;
                color: var(--text-light) !important;
            }

            .modal .form-control {
                background: rgba(255, 255, 255, 0.04) !important;
                border: 1.5px solid transparent !important;
                color: var(--text-light) !important;
                border-radius: 8px !important;
                font-weight: 500 !important;
                transition: all 0.3s ease !important;
            }

            .modal .form-control:focus {
                background: rgba(255, 255, 255, 0.06) !important;
                border-color: var(--primary-red) !important;
                box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1) !important;
                color: var(--text-light) !important;
            }

            .modal .form-control::placeholder {
                color: rgba(255, 255, 255, 0.5) !important;
            }

            .modal .form-label {
                color: var(--text-light) !important;
                font-weight: 600 !important;
                font-size: 0.875rem !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                margin-bottom: 6px !important;
            }


            /* Responsive Design */
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                    position: fixed;
                    z-index: 1000;
                    transition: transform 0.3s ease;
                }

                .sidebar.show {
                    transform: translateX(0);
                }

                .content-area {
                    margin-left: 0;
                }

                .modal {
                    z-index: 10000 !important;
                }

                .modal-backdrop {
                    z-index: 9999 !important;
                }
            }

            /* Fade in animation */
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
        </style>

        <script>
            // Función para cargar contenido via AJAX con jQuery
            function cargarContenido(menu_id) {
                // Obtener el menú anterior para comparar
                const menuAnterior = sessionStorage.getItem('menu_activo');

                // Guardar el ID del menú actual en sessionStorage
                sessionStorage.setItem('menu_activo', menu_id);

                // Sin animación de carga
                $('#contenido_dinamico').html('');

                $.ajax({
                    url: 'contenido_menu.php',
                    type: 'POST',
                    data: { id_menu: menu_id },
                    success: function(response) {
                        // ✅ VERIFICAR SI ES EL MÓDULO DE MOVIMIENTO
                        const esMovimiento = response.includes('movimiento.php') || response.toLowerCase().includes('registrar movimiento');

                        if (esMovimiento) {
                            // Verificar si venimos de otro módulo (cambió el menu_id)
                            const cambioDeModulo = menuAnterior !== menu_id.toString();

                            if (cambioDeModulo) {
                                // Venimos de otro módulo, recargar página
                                sessionStorage.setItem('debe_cargar_movimiento', 'true');
                                location.reload();
                            } else {
                                // Ya estamos en el módulo después de recargar
                                sessionStorage.removeItem('debe_cargar_movimiento');
                                $('#contenido_dinamico').html(response);
                                $('#contenido_dinamico .modal').appendTo('body');
                                initializeDynamicModals();
                            }
                        } else {
                            // Cargar normalmente con AJAX
                            sessionStorage.removeItem('debe_cargar_movimiento');
                            $('#contenido_dinamico').html(response);
                            $('#contenido_dinamico .modal').appendTo('body');
                            initializeDynamicModals();
                        }
                    },
                    error: function() {
                        $('#contenido_dinamico').html(`
                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error al cargar el contenido
                    </div>
                </div>
            `);
                    }
                });
            }

            // Función para inicializar modales dinámicos
            function initializeDynamicModals() {
                // ✅ limpiar backdrop huérfanos
                $('.modal-backdrop').remove();

                // Remover handlers viejos antes de volver a aplicar
                $(document).off('show.bs.modal hidden.bs.modal');

                // Manejo de pila de modales
                $(document).on('show.bs.modal', '.modal', function () {
                    let zIndex = 1040 + (10 * $('.modal:visible').length);
                    $(this).css('z-index', zIndex);

                    setTimeout(() => {
                        $('.modal-backdrop')
                            .not('.modal-stack')
                            .css('z-index', zIndex - 1)
                            .addClass('modal-stack');
                    }, 0);
                });

                $(document).on('hidden.bs.modal', '.modal', function () {
                    if ($('.modal:visible').length > 0) {
                        $('body').addClass('modal-open');
                    } else {
                        // limpiar si ya no hay modales abiertos
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');
                    }
                });

                // Inicializar tooltips (si existen)
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            }

            // Espera que el DOM y jQuery estén listos
            $(document).ready(function() {

                // ✅ NUEVO: Restaurar menú activo al recargar la página
                const menuActivoGuardado = sessionStorage.getItem('menu_activo');
                if (menuActivoGuardado) {
                    // Marcar visualmente el menú como activo
                    $(`.menu-link[onclick*="cargarContenido(${menuActivoGuardado})"]`).addClass('menu-activo');

                    // Recargar el contenido del módulo
                    cargarContenido(menuActivoGuardado);
                } else {
                    // Carga contenido por defecto solo si no hay menú guardado
                    $('#contenido_dinamico').load('contenido_default.php', function() {
                        $('#contenido_dinamico .modal').appendTo('body');
                        initializeDynamicModals();
                    });
                }

                // Maneja el clic en los enlaces del menú
                $('.menu-link').on('click', function() {
                    $('.menu-link').removeClass('menu-activo');
                    $(this).addClass('menu-activo');
                });


                // Maneja el clic en los enlaces del menú
                $('.menu-link').on('click', function() {
                    $('.menu-link').removeClass('menu-activo');
                    $(this).addClass('menu-activo');
                });

                // Efectos de hover mejorados
                $('.menu-link').hover(
                    function() { $(this).find('i').addClass('fa-bounce'); },
                    function() { $(this).find('i').removeClass('fa-bounce'); }
                );
            });

            // Función utilitaria para abrir modales programáticamente
            function openModal(modalId) {
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            }

            // Función utilitaria para cerrar todos los modales
            function closeAllModals() {
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
            }
        </script>

    </head>
    <body>
    <div class="container-fluid p-0">
        <div class="row g-0 h-100">
            <!-- Sidebar del Menú -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <!-- Sección de Usuario -->
                <div class="user-section">
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i> Salir
                    </a>
                    <div class="welcome-text">Bienvenido</div>
                    <div class="user-name"><?php echo htmlspecialchars($persona["nomyap_persona"]); ?></div>
                </div>

                <!-- Menú -->
                <div class="menu-container">
                    <ul class="menu-list">
                        <?php
                        $menu_icons = [
                            'fas fa-tachometer-alt', 'fas fa-users', 'fas fa-file-alt',
                            'fas fa-cogs', 'fas fa-chart-bar', 'fas fa-database',
                            'fas fa-tasks', 'fas fa-user-shield', 'fas fa-bell'
                        ];
                        $icon_index = 0;
                        foreach ($menus as $menu):
                            ?>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link" onclick="cargarContenido(<?php echo $menu['id_menu']; ?>)">
                                    <i class="<?php echo $menu_icons[$icon_index % count($menu_icons)]; ?>"></i>
                                    <?php echo htmlspecialchars($menu['descripcion_menu']); ?>
                                </a>
                            </li>
                            <?php
                            $icon_index++;
                        endforeach;
                        ?>
                    </ul>
                </div>
            </nav>

            <!-- Zona de Contenido -->
            <main class="col-md-9 col-lg-10 content-area">
                <div class="content-header">
                    <h1 class="content-title">SISAD</h1>
                    <p class="content-subtitle">Sistema de Asignación y Desplazamiento - NCPPP</p>
                </div>

                <div class="content-body">
                    <div id="contenido_dinamico"></div>
                </div>
            </main>
        </div>
    </div>

    <script src="../libreria/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
} else {
    echo "<p>No se encontraron datos para la persona asociada.</p>";
}
?>
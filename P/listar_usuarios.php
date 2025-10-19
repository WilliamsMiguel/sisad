<?php
session_start(); // si no está
$id_usuario_actual = $_SESSION['id_usuario'];
require_once '../cache_control.php'; // Solo esto
// P/listar_usuarios.php
require_once '../LN/ln_listar_Usuarios.php';

$usuarios = obtener_lista_usuarios();
?>

<head>
    <style>
        /* Variables CSS basadas en el estilo del login */
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
            position: relative;
        }

        /* Grid sutil de fondo sin animación */
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

        /* Contenedor principal */
        .table-container {
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

        .modern-title {
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

        /* Sección de búsqueda */
        .search-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-subtle);
            display: flex;
            justify-content: center;
        }

        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 14px 20px 14px 50px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 12px;
            color: var(--text-light);
            font-size: 1rem;
            font-weight: 500;
            backdrop-filter: blur(8px);
            position: relative;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Tabla moderna */
        .table-wrapper {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
            position: relative;
        }

        .table {
            width: 100%;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--dark-bg), var(--card-bg));
            color: var(--text-light);
            padding: 20px 16px;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 2px solid var(--primary-red);
            white-space: nowrap;
        }

        .table thead th i {
            margin-right: 8px;
            color: var(--accent-red);
            opacity: 0.8;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(185, 28, 28, 0.1);
        }

        .table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.04);
        }

        .table tbody tr:nth-child(even):hover {
            background: rgba(185, 28, 28, 0.15);
        }

        .table tbody td {
            padding: 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-gray) !important;
            font-weight: 500;
            vertical-align: middle;
        }

        .table tbody td:last-child {
            border-right: none;
        }

        /* Selectores modernos */
        .form-select {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--text-light);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-select:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-red);
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        .form-select option {
            background: var(--dark-bg);
            color: var(--text-light);
        }

        /* Botones modernos */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 8px;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #4e92ef, #23487a);
            color: white;
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5ba0f7, #2a5690);
            box-shadow: var(--shadow-primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--success-green), #059669);
            color: white;
            border: 1px solid var(--border-color);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #10b981, #047857);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-orange), #d97706);
            color: var(--dark-bg);
            font-weight: 700;
            border: 1px solid var(--border-color);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f59e0b, #b45309);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        /* Modales modernos */
        .modal {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            box-shadow: var(--shadow-subtle) !important;
        }

        .modal h4 {
            color: var(--text-light);
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .modal label {
            color: var(--text-light);
            font-weight: 500;
            margin-left: 8px;
        }

        .modal input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-red);
            margin-right: 8px;
        }

        .modal input[type="password"],
        .modal .form-control {
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            color: var(--text-light);
            font-weight: 500;
            width: 100%;
        }

        .modal input[type="password"]:focus,
        .modal .form-control:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        /* Spans de estado */
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
        }

        .status-superusuario {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: var(--text-light);
        }

        .status-editor {
            background: linear-gradient(135deg, var(--success-green), #059669);
            color: var(--text-light);
        }

        .status-deshabilitado {
            background: linear-gradient(135deg, var(--text-muted), #64748b);
            color: var(--text-light);
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
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .table-container {
                padding: 30px 15px;
            }

            .table {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 20px 10px;
            }

            .modern-title {
                font-size: 2rem;
            }

            .modern-header {
                padding: 30px 20px;
            }

            .search-container {
                padding: 20px 15px;
            }

            .table {
                font-size: 0.8rem;
            }

            .table thead th,
            .table tbody td {
                padding: 12px 8px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 0.75rem;
                margin-bottom: 4px;
            }

            .search-input {
                padding: 12px 16px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .table-container {
                padding: 15px 10px;
            }

            .modern-title {
                font-size: 1.8rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table thead th,
            .table tbody td {
                padding: 10px 6px;
            }

            .modal {
                width: 90% !important;
                left: 5% !important;
            }
        }
    </style>
</head>

<div class="table-container">
    <!-- Header moderno -->
    <div class="modern-header">
        <h1 class="modern-title">
            <i class="fas fa-users"></i>
            Administrar Usuarios
        </h1>
        <p class="header-subtitle">Gestión de roles y permisos del sistema</p>
    </div>

    <!-- Sección de búsqueda -->
    <div class="search-container">
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..." class="search-input">
    </div>

    <!-- Tabla moderna -->
    <div class="table-wrapper">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-user"></i> Usuario</th>
                <th><i class="fas fa-id-card"></i> ID Persona</th>
                <th><i class="fas fa-user-tag"></i> Rol</th>
                <th><i class="fas fa-cogs"></i> Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                        <td><?= htmlspecialchars($row['id_persona_usuario']) ?></td>
                        <td>
                            <?php if ($row['id_usuario'] != $id_usuario_actual): ?>
                                <form class="estado-form" data-id="<?= $row['id_usuario'] ?>">
                                    <select name="estado_usuario" class="form-select estado-select">
                                        <option value="1" <?= $row['estado_usuario'] == 1 ? 'selected' : '' ?>>Superusuario</option>
                                        <option value="2" <?= $row['estado_usuario'] == 2 ? 'selected' : '' ?>>Editor</option>
                                        <option value="3" <?= $row['estado_usuario'] == 3 ? 'selected' : '' ?>>Deshabilitado</option>
                                    </select>
                                </form>
                            <?php else: ?>
                                <span class="status-badge <?= $row['estado_usuario'] == 1 ? 'status-superusuario' : ($row['estado_usuario'] == 2 ? 'status-editor' : 'status-deshabilitado') ?>">
                                    <?= $row['estado_usuario'] == 1 ? 'Superusuario' : ($row['estado_usuario'] == 2 ? 'Editor' : 'Deshabilitado') ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['estado_usuario'] == 2 && $row['id_usuario'] != $id_usuario_actual): ?>
                                <button class="btn btn-sm btn-secondary" onclick="abrirModalModulos(<?= $row['id_usuario'] ?>)">
                                    <i class="fas fa-puzzle-piece"></i> Asignar Módulos
                                </button>
                            <?php endif; ?>
                            <?php if ($row['id_usuario'] != $id_usuario_actual): ?>
                                <button class="btn btn-sm btn-warning" onclick="abrirModalRestablecer(<?= $row['id_usuario'] ?>)">
                                    <i class="fas fa-key"></i> Restablecer
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">No se encontraron usuarios.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Asignar Módulos -->
<div id="modalAsignarModulos" class="modal" style="display:none; position:fixed; top:10%; left:30%; width:40%; padding:30px; z-index:999;">
    <h4><i class="fas fa-puzzle-piece"></i> Asignar Módulos al Usuario</h4>
    <form id="formAsignarModulos">
        <div id="modulosCheckboxes" style="margin-bottom: 20px;"></div>
        <input type="hidden" id="usuarioEditorId" name="id_usuario">
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <button type="button" class="btn btn-secondary" onclick="cerrarModalModulos()">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    </form>
</div>

<!-- Modal Restablecer Contraseña -->
<div id="modalRestablecer" class="modal" style="display:none; position:fixed; top:10%; left:30%; width:40%; padding:30px; z-index:999;">
    <h4><i class="fas fa-key"></i> Restablecer Contraseña</h4>
    <form id="formRestablecer">
        <input type="hidden" id="usuarioIdRestablecer" name="id_usuario">

        <div style="margin-bottom: 20px;">
            <label for="nuevaContrasena"><strong>Nueva Contraseña:</strong></label>
            <input type="password" id="nuevaContrasena" name="nueva_contrasena" class="form-control" required style="margin-top:8px;">
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <button type="button" class="btn btn-secondary" onclick="cerrarModalRestablecer()">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    </form>
</div>

<script>
    function cerrarModalModulos() {
        document.getElementById("modalAsignarModulos").style.display = "none";
    }

    function abrirModalModulos(id_usuario) {
        document.getElementById("usuarioEditorId").value = id_usuario;

        // 1. Obtener TODOS los módulos disponibles
        fetch('../LN/ln_listar_menus.php')
            .then(res => res.json())
            .then(menus => {
                const container = document.getElementById('modulosCheckboxes');
                container.innerHTML = '';

                // 2. Obtener los módulos asignados
                fetch(`../LN/ln_obtener_modulos_usuario.php?id_usuario=${id_usuario}`)
                    .then(res => res.json())
                    .then(asignados => {
                        menus.forEach(menu => {
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'modulos[]';
                            checkbox.value = menu.id_menu;
                            if (asignados.includes(menu.id_menu)) {
                                checkbox.checked = true;
                            }

                            const label = document.createElement('label');
                            label.textContent = ' ' + menu.descripcion_menu;

                            container.appendChild(checkbox);
                            container.appendChild(label);
                            container.appendChild(document.createElement('br'));
                        });

                        document.getElementById("modalAsignarModulos").style.display = "block";
                    });
            });
    }

    function abrirModalRestablecer(id_usuario) {
        document.getElementById("usuarioIdRestablecer").value = id_usuario;
        document.getElementById("nuevaContrasena").value = '';
        document.getElementById("modalRestablecer").style.display = "block";
    }

    function cerrarModalRestablecer() {
        document.getElementById("modalRestablecer").style.display = "none";
    }

    document.getElementById("formRestablecer").addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('../LN/ln_restablecer_contrasena.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(data => {
                alert(data);
                cerrarModalRestablecer();
                cargarContenido(8); // Refrescar lista de usuarios
            });
    });

    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', function () {
            const form = this.closest('.estado-form');
            const id_usuario = form.getAttribute('data-id');
            const nuevo_estado = this.value;

            fetch('../LN/ln_cambiar_estado_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_usuario=${id_usuario}&estado_usuario=${nuevo_estado}`
            })
                .then(res => res.text())
                .then(data => {
                    alert("Estado actualizado correctamente.");
                    cargarContenido(8); // Vuelve a cargar el módulo 'Listar Usuarios'
                });
        });
    });

    // Guardar módulos seleccionados
    document.getElementById('formAsignarModulos').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('../LN/ln_asignar_modulos_usuario.php', {
            method: 'POST',
            body: formData
        }).then(res => res.text())
            .then(data => {
                alert(data);
                cerrarModalModulos();
                cargarContenido(8); // Refresca la vista de usuarios después de guardar módulos
            });
    });

    document.getElementById('buscarUsuario').addEventListener('keyup', function() {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll('.table tbody tr');

        filas.forEach(fila => {
            const textoFila = fila.innerText.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? '' : 'none';
        });
    });
</script>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta y Login</title>
    <link rel="icon" href="P/img/pj.png" type="image/x-icon">
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
            background: linear-gradient(135deg, #0f172a 0%, #1e293b  50%, #0f1419 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Partículas flotantes de fondo */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 1px;
            height: 1px;
            background: var(--text-muted);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.2; }
            50% { transform: translateY(-15px) translateX(5px); opacity: 0.4; }
        }

        /* Grid sutil de fondo */
        .grid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                    linear-gradient(rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 30s linear infinite;
            z-index: 1;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 450px;
            margin: 80px auto;
            padding: 40px;
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-red), 0 20px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            opacity: 1;
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .container.hidden {
            display: none;
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

        h1 {
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 4px;
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
        }

        h2 {
            font-size: 1.05rem;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 28px;
            font-weight: 500;
            letter-spacing: 0.025em;
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

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid transparent;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-red);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
            transform: translateY(-1px);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .link-button {
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
        }

        .link-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .link-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(185, 28, 28, 0.35);
            background: linear-gradient(135deg, var(--light-red), var(--primary-red));
        }

        .link-button:hover::before {
            left: 100%;
        }

        .link-button:active {
            transform: translateY(0);
        }

        .link-buttonMIO {
            color: var(--accent-red);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .link-buttonMIO::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1.5px;
            bottom: -4px;
            left: 50%;
            background: var(--accent-red);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .link-buttonMIO:hover {
            color: var(--light-red);
        }

        .link-buttonMIO:hover::after {
            width: 100%;
        }

        /* Modal moderno */
        #result-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 1;
            visibility: visible;
            transition: all 0.3s ease;
        }

        #result-modal.hidden {
            opacity: 0;
            visibility: hidden;
        }

        #modal-content {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            box-shadow: var(--shadow-red), 0 20px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            transform: scale(1);
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        #result-modal.hidden #modal-content {
            transform: scale(0.8);
        }

        #modal-data {
            padding: 30px;
            color: var(--text-light);
        }

        /* Estilos para el contenido dinámico del modal */
        #modal-data table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        #modal-data table thead {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
        }

        #modal-data table th {
            padding: 15px 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            color: var(--text-light);
            border: none;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        #modal-data table td {
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: var(--text-gray);
            transition: all 0.3s ease;
        }

        #modal-data table tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        #modal-data table tbody tr:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(204, 0, 0, 0.2);
        }

        #modal-data table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Estilo para filas desvinculadas con diseño moderno */
        #modal-data table tr.desvinculado {
            background: linear-gradient(135deg, rgba(255, 99, 99, 0.15), rgba(204, 0, 0, 0.1)) !important;
            border-left: 4px solid var(--accent-red);
            animation: pulseRed 2s ease-in-out infinite alternate;
        }

        #modal-data table tr.desvinculado td {
            color: #ffaaaa;
            text-shadow: 0 0 5px rgba(255, 99, 99, 0.3);
        }

        @keyframes pulseRed {
            0% { box-shadow: 0 0 5px rgba(255, 99, 99, 0.3); }
            100% { box-shadow: 0 0 15px rgba(255, 99, 99, 0.6); }
        }

        #modal-data table tr.desvinculado:hover {
            background: linear-gradient(135deg, rgba(255, 99, 99, 0.25), rgba(204, 0, 0, 0.2)) !important;
            transform: scale(1.02);
        }

        /* Mensajes de error y vacío */
        #modal-data p {
            text-align: center;
            padding: 30px;
            margin: 20px 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        #modal-data p[style*="color: red"] {
            background: linear-gradient(135deg, rgba(204, 0, 0, 0.2), rgba(153, 0, 0, 0.1));
            border: 2px solid var(--primary-red);
            color: var(--accent-red) !important;
            box-shadow: 0 8px 25px rgba(204, 0, 0, 0.3);
            animation: shake 0.5s ease-in-out;
        }

        /* Mensaje cuando no hay datos */
        #modal-data p:not([style*="color: red"]) {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: var(--text-gray);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Scrollbar personalizada para el modal */
        #modal-content::-webkit-scrollbar {
            width: 8px;
        }

        #modal-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        #modal-content::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        #modal-content::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }

        /* Estilos para impresión mejorados */
        @media print {
            #modal-data table {
                background: white !important;
                box-shadow: none !important;
            }

            #modal-data table th {
                background: #f5f5f5 !important;
                color: black !important;
                border: 1px solid #333 !important;
            }

            #modal-data table td {
                color: black !important;
                border: 1px solid #333 !important;
            }

            #modal-data table tr.desvinculado {
                background-color: #ffcccc !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                border-left: 4px solid #cc0000 !important;
                animation: none !important;
            }

            #modal-data table tr.desvinculado td {
                color: #990000 !important;
                text-shadow: none !important;
            }
        }

        #modal-content button {
            margin: 10px;
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #modal-content button:hover {
            background: linear-gradient(135deg, var(--accent-red), var(--primary-red));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(204, 0, 0, 0.4);
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

        /* Animaciones de entrada */
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

        /* Responsive design */
        @media (max-width: 480px) {
            .container {
                margin: 20px;
                padding: 30px 20px;
            }

            h1 {
                font-size: 2rem;
            }
        }

        /* Loading animation */
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

        .logo-pj {
            width: 160px;   /* ajusta según lo que necesites */
            height: auto;   /* mantiene la proporción */
            display: block;
            margin: 0 auto 20px auto; /* centrado y con espacio abajo */
        }

    </style>
    <script>
        /* Crear partículas sutiles */
        function createParticles() {
            const particles = document.querySelector('.particles');
            if (!particles) return;

            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                particles.appendChild(particle);
            }
        }

        // Funciones originales mantenidas
        function buscarBienes() {
            const dni = document.getElementById('dni').value;
            const button = event.target;

            if (dni.trim() === '') {
                alert('Por favor, ingrese un DNI válido.');
                return;
            }

            // Agregar efecto de carga
            button.classList.add('loading');
            button.disabled = true;

            // Crear objeto FormData para enviar los datos por POST
            const formData = new FormData();
            formData.append('dniP', dni);

            // Realizar la solicitud AJAX
            fetch('LN/ln_ver_bienes_dni.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.text(); // Recibir respuesta como texto
                })
                .then(data => {
                    // Mostrar los resultados en el modal
                    const modal = document.getElementById('result-modal');
                    const modalContent = document.getElementById('modal-data');
                    modalContent.innerHTML = data;
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al procesar la solicitud.');
                })
                .finally(() => {
                    // Quitar efecto de carga
                    button.classList.remove('loading');
                    button.disabled = false;
                });
        }

        function cerrarModal() {
            const modal = document.getElementById('result-modal');
            modal.classList.add('hidden');
        }

        // Función para alternar entre secciones con animación mejorada
        function toggleSection(showLogin) {
            const consultaSection = document.getElementById('consulta-section');
            const loginSection = document.getElementById('login-section');

            if (showLogin) {
                // Fade out consulta
                consultaSection.style.opacity = '0';
                consultaSection.style.transform = 'translateY(-20px)';

                setTimeout(() => {
                    consultaSection.classList.add('hidden');
                    loginSection.classList.remove('hidden');
                    loginSection.style.opacity = '0';
                    loginSection.style.transform = 'translateY(20px)';

                    // Fade in login
                    setTimeout(() => {
                        loginSection.style.opacity = '1';
                        loginSection.style.transform = 'translateY(0)';
                        loginSection.classList.add('fade-in');
                    }, 50);
                }, 300);
            } else {
                // Fade out login
                loginSection.style.opacity = '0';
                loginSection.style.transform = 'translateY(-20px)';

                setTimeout(() => {
                    loginSection.classList.add('hidden');
                    consultaSection.classList.remove('hidden');
                    consultaSection.style.opacity = '0';
                    consultaSection.style.transform = 'translateY(20px)';

                    // Fade in consulta
                    setTimeout(() => {
                        consultaSection.style.opacity = '1';
                        consultaSection.style.transform = 'translateY(0)';
                        consultaSection.classList.add('fade-in');
                    }, 50);
                }, 300);
            }
        }

        function imprimirModal() {
            const modalContent = document.getElementById('modal-data').innerHTML;

            if (!modalContent.trim()) {
                alert('No hay datos para imprimir.');
                return;
            }

            const ventanaImpresion = window.open('', '_blank');
            ventanaImpresion.document.open();
            ventanaImpresion.document.write(`
            <html>
            <head>
                <title>Reporte de Bienes Asignados - SISAD NCPP</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    h2 {
                        text-align: center;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #333;
                        padding: 6px 8px;
                        text-align: left;
                        font-size: 12px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    @media print {
                        button {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <h2>Sistema de Asignación y Desplazamiento de Bienes Informáticos - NCPP</h2>
                ${modalContent}
            </body>
            </html>
        `);
            ventanaImpresion.document.close();
            ventanaImpresion.focus();
            ventanaImpresion.print();
            ventanaImpresion.close();
        }

        // Inicializar efectos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();

            // Agregar efectos de focus a los inputs
            const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Efecto de aparición inicial
            setTimeout(() => {
                document.querySelector('.container:not(.hidden)').classList.add('fade-in');
            }, 100);
        });

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModal();
            }
        });
    </script>
</head>
<body>
<!-- Efectos de fondo -->
<div class="grid-bg"></div>
<div class="particles"></div>

<!-- Consulta de bienes -->
<div class="container
        <?php echo (isset($_GET['error']) && $_GET['error'] == 1) ? 'hidden' : ''; ?>"
     id="consulta-section">

    <div class="logo-container">
        <img src="P/img/pj.png" alt="Poder Judicial del Perú" class="logo-pj">
    </div>

    <h1>SISAD-NCPP</h1>
    <h2>Consultar Bienes Asignados</h2>
    <label for="dni">Ingrese su DNI:</label>
    <input type="text" id="dni" maxlength="8" placeholder="DNI" required>
    <br>
    <button class="link-button" onclick="buscarBienes()">Buscar</button>
    <br><br>
    <div style="text-align: center;">
        <br><br>
        <a href="#" class="link-buttonMIO" onclick="toggleSection(true)">Ingresar al sistema</a>
    </div>
</div>

<!-- Modal para mostrar resultados -->
<div id="result-modal" class="hidden">
    <div id="modal-content">
        <div id="modal-data">
            <!-- Aquí se carga el contenido dinámico -->
        </div>
        <button onclick="cerrarModal()">Cerrar</button>
        <button onclick="imprimirModal()">Imprimir</button>
    </div>
</div>

<!-- Formulario de login -->
<div
        class="container <?php echo (isset($_GET['error']) && $_GET['error'] == 1) ? '' : 'hidden'; ?>"
        id="login-section">

    <div class="logo-container">
        <img src="P/img/pj.png" alt="Poder Judicial del Perú" class="logo-pj">
    </div>

    <h1>SISAD-NCPP</h1>
    <h2>Iniciar Sesión</h2>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
    }
    ?>

    <form action="LN/ln.php" method="POST">
        <label for="nombre_usuario">Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
        <label for="clave_usuario">Contraseña:</label>
        <input type="password" id="clave_usuario" name="clave_usuario" required>
        <br>

        <button class="link-button" type="submit">Entrar</button>
        <div style="text-align: center;">
            <br><br>
            <a href="#" class="link-buttonMIO" onclick="toggleSection(false)">Consultar bienes asignados</a>
        </div>
    </form>
    <br>
</div>
</body>
</html>
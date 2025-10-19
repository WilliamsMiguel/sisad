<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="P/estilos.css"> <!-- Vincula el archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>SISAD-NCPP</h1>
        <h2>Iniciar Sesión</h2>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
        }
        ?>

        <form action="LN/ln.php" method="POST">
            <label for="nombre_usuario" style="font-weight: bold;">Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>
            <label for="clave_usuario" style="font-weight: bold;">Contraseña:</label>
            <input type="password" id="clave_usuario" name="clave_usuario" required>
            <button type="submit">Entrar</button>
             
        </form>
    </div>
</body>
</html>

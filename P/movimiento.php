<?php
// P/movimiento.php
include '../LN/ln_listaR.php';

// Obtener listas de personas, dependencias y áreas
$personas = obtener_personas(); // Función en LN para listar personas
$dependencias = obtener_dependencias(); // Función en LN para listar dependencias
$areas = obtener_areas(); // Función en LN para listar áreas

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Movimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registrar Movimiento</h2>
        <form action="../LN/ln_movimiento.php" method="post" enctype="multipart/form-data">
            
            <!-- Transferente -->
            <div class="mb-3">
                <label for="transferente">Transferente</label>
                <select class="form-control" name="id_transferente_movimiento" id="transferente" required>
                    <option value="">Seleccionar Transferente</option>
                    <?php foreach ($personas as $persona): ?>
                        <option value="<?php echo $persona['id_persona']; ?>">
                            <?php echo htmlspecialchars($persona['nomyap_persona']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Receptor -->
            <div class="mb-3">
                <label for="receptor">Receptor</label>
                <select class="form-control" name="id_receptor_movimiento" id="receptor" required>
                    <option value="">Seleccionar Receptor</option>
                    <?php foreach ($personas as $persona): ?>
                        <option value="<?php echo $persona['id_persona']; ?>">
                            <?php echo htmlspecialchars($persona['nomyap_persona']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dependencia Transferente -->
            <div class="mb-3">
                <label for="dependencia_transferente">Dependencia Transferente</label>
                <select class="form-control" name="id_dependencia_transferente_movimiento" id="dependencia_transferente" required>
                    <option value="">Seleccionar Dependencia Transferente</option>
                    <?php foreach ($dependencias as $dependencia): ?>
                        <option value="<?php echo $dependencia['id_dependencia']; ?>">
                            <?php echo htmlspecialchars($dependencia['descripcion_dependencia']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dependencia Receptora -->
            <div class="mb-3">
                <label for="dependencia_receptora">Dependencia Receptora</label>
                <select class="form-control" name="id_dependencia_receptor_movimiento" id="dependencia_receptora" required>
                    <option value="">Seleccionar Dependencia Receptora</option>
                    <?php foreach ($dependencias as $dependencia): ?>
                        <option value="<?php echo $dependencia['id_dependencia']; ?>">
                            <?php echo htmlspecialchars($dependencia['descripcion_dependencia']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Área Transferente -->
            <div class="mb-3">
                <label for="area_transferente">Área Transferente</label>
                <select class="form-control" name="id_area_transferente_movimiento" id="area_transferente" required>
                    <option value="">Seleccionar Área Transferente</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo $area['id_area']; ?>">
                            <?php echo htmlspecialchars($area['descripcion_area']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Área Receptora -->
            <div class="mb-3">
                <label for="area_receptora">Área Receptora</label>
                <select class="form-control" name="id_area_receptor_movimiento" id="area_receptora" required>
                    <option value="">Seleccionar Área Receptora</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo $area['id_area']; ?>">
                            <?php echo htmlspecialchars($area['descripcion_area']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fecha Movimiento -->
            <div class="mb-3">
                <label for="fecha_movimiento">Fecha del Movimiento</label>
                <input type="date" class="form-control" name="fecha_movimiento" id="fecha_movimiento" required>
            </div>

            <!-- Archivo del Movimiento -->
            <div class="mb-3">
                <label for="archivo_movimiento">Subir Archivo (PDF)</label>
                <input type="file" class="form-control" name="archivo_movimiento" id="archivo_movimiento" accept=".pdf" required>
            </div>

            <!-- Botón de enviar -->
            <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
        </form>
    </div>
</body>
</html>

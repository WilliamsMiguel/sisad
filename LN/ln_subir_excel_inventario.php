<?php
// Configuración inicial
use Shuchkin\SimpleXLSX;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para enviar respuesta JSON
function sendJsonResponse($data) {
    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(['success' => false, 'error' => 'Método no permitido']);
}

try {
    // Verificar archivo
    if (!isset($_FILES['archivoExcel']) || $_FILES['archivoExcel']['error'] !== UPLOAD_ERR_OK) {
        sendJsonResponse(['success' => false, 'error' => 'Error al subir archivo']);
    }

    $archivo = $_FILES['archivoExcel']['tmp_name'];
    $extension = strtolower(pathinfo($_FILES['archivoExcel']['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, ['xlsx', 'xls'])) {
        sendJsonResponse(['success' => false, 'error' => 'Solo archivos .xlsx o .xls']);
    }

    // Incluir dependencias
    session_start();
    require_once '../AD/ad.php';

    // Librería SimpleXLSX
    if (!class_exists('SimpleXLSX')) {
        require_once __DIR__ . '/../libreria/SimpleXLSX.php';
    }

    // Leer Excel
    if ($xlsx = SimpleXLSX::parse($archivo)) {
        $rows = $xlsx->rows();
    } else {
        sendJsonResponse(['success' => false, 'error' => 'Error al leer Excel: ' . SimpleXLSX::parseError()]);
    }

    // Verificar datos
    if (count($rows) < 2) {
        sendJsonResponse(['success' => false, 'error' => 'Archivo vacío']);
    }

    // Verificar encabezados
    $encabezadosEsperados = [
        'id_bien', 'equipo_bien', 'marca_bien', 'modelo_bien', 'procesador_bien',
        'numdeserie_bien', 'numcontropatri_bien', 'estado_bien', 'añodeadqs_bien',
        'numdeordendecom_bien', 'color_bien', 'observacion_bien', 'costo_bien',
        'funcionamiento', 'id_pcasignada'
    ];

    $encabezados = $rows[0];
    for ($i = 0; $i < count($encabezadosEsperados); $i++) {
        if (!isset($encabezados[$i]) || trim($encabezados[$i]) !== $encabezadosEsperados[$i]) {
            sendJsonResponse([
                'success' => false,
                'error' => "Error en encabezado columna " . ($i+1) . ". Esperado: '{$encabezadosEsperados[$i]}', encontrado: '" . ($encabezados[$i] ?? 'VACÍO') . "'"
            ]);
        }
    }

    // Conectar BD
    $conn = conectar();
    if (!$conn || $conn->connect_error) {
        sendJsonResponse(['success' => false, 'error' => 'Error conexión BD']);
    }

    $conn->autocommit(false);
    $actualizados = 0;
    $insertados = 0;
    $filasSaltadas = 0;
    $errores = [];

    // Procesar filas
    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];
        $filaNumero = $i + 1;

        try {
            // LIMPIAR Y VALIDAR DATOS
            $id_bien = isset($row[0]) && trim($row[0]) !== '' ? (int)trim($row[0]) : null;
            $equipo_bien = isset($row[1]) ? trim($row[1]) : '';
            $marca_bien = isset($row[2]) ? trim($row[2]) : '';
            $modelo_bien = isset($row[3]) ? trim($row[3]) : '';
            $procesador_bien = isset($row[4]) && trim($row[4]) !== '' ? trim($row[4]) : null;
            $numdeserie_bien = isset($row[5]) && trim($row[5]) !== '' ? trim($row[5]) : null;
            $numcontropatri_bien = isset($row[6]) && trim($row[6]) !== '' ? trim($row[6]) : null;
            $estado_bien = isset($row[7]) && trim($row[7]) !== '' ? (int)$row[7] : null;
            $añodeadqs_bien = isset($row[8]) && trim($row[8]) !== '' ? (int)$row[8] : null;
            $numdeordendecom_bien = isset($row[9]) && trim($row[9]) !== '' ? trim($row[9]) : null;
            $color_bien = isset($row[10]) && trim($row[10]) !== '' ? trim($row[10]) : null;
            $observacion_bien = isset($row[11]) && trim($row[11]) !== '' ? trim($row[11]) : null;
            $costo_bien = isset($row[12]) && trim($row[12]) !== '' ? (float)$row[12] : null;
            $funcionamiento = isset($row[13]) && trim($row[13]) !== '' ? (int)$row[13] : null;
            $id_pcasignada = isset($row[14]) && trim($row[14]) !== '' ? (int)$row[14] : null;

            // VERIFICAR SI LA FILA TIENE AL MENOS ALGUNOS DATOS RELEVANTES
            $tieneAlgunDato = !empty($equipo_bien) || !empty($marca_bien) || !empty($modelo_bien) ||
                !empty($estado_bien) || !empty($funcionamiento) || $id_bien !== null;

            if (!$tieneAlgunDato) {
                $filasSaltadas++;
                continue; // Saltar fila completamente vacía
            }

            // LÓGICA DE ACTUALIZACIÓN vs INSERCIÓN
            if ($id_bien !== null) {
                // Verificar si existe
                $checkStmt = $conn->prepare("SELECT * FROM bien WHERE id_bien = ?");
                $checkStmt->bind_param("i", $id_bien);
                $checkStmt->execute();
                $result = $checkStmt->get_result();
                $existingRecord = $result->fetch_assoc();
                $checkStmt->close();

                if ($existingRecord) {
                    // ACTUALIZAR SOLO CAMPOS NO VACÍOS (preservar datos existentes)
                    $updateFields = [];
                    $updateValues = [];
                    $types = '';

                    if (!empty($equipo_bien)) {
                        $updateFields[] = "equipo_bien = ?";
                        $updateValues[] = $equipo_bien;
                        $types .= 's';
                    }
                    if (!empty($marca_bien)) {
                        $updateFields[] = "marca_bien = ?";
                        $updateValues[] = $marca_bien;
                        $types .= 's';
                    }
                    if (!empty($modelo_bien)) {
                        $updateFields[] = "modelo_bien = ?";
                        $updateValues[] = $modelo_bien;
                        $types .= 's';
                    }
                    if ($procesador_bien !== null) {
                        $updateFields[] = "procesador_bien = ?";
                        $updateValues[] = $procesador_bien;
                        $types .= 's';
                    }
                    if ($numdeserie_bien !== null) {
                        $updateFields[] = "numdeserie_bien = ?";
                        $updateValues[] = $numdeserie_bien;
                        $types .= 's';
                    }
                    if ($numcontropatri_bien !== null) {
                        $updateFields[] = "numcontropatri_bien = ?";
                        $updateValues[] = $numcontropatri_bien;
                        $types .= 's';
                    }
                    if ($estado_bien !== null) {
                        $updateFields[] = "estado_bien = ?";
                        $updateValues[] = $estado_bien;
                        $types .= 'i';
                    }
                    if ($añodeadqs_bien !== null) {
                        $updateFields[] = "añodeadqs_bien = ?";
                        $updateValues[] = $añodeadqs_bien;
                        $types .= 'i';
                    }
                    if ($numdeordendecom_bien !== null) {
                        $updateFields[] = "numdeordendecom_bien = ?";
                        $updateValues[] = $numdeordendecom_bien;
                        $types .= 's';
                    }
                    if ($color_bien !== null) {
                        $updateFields[] = "color_bien = ?";
                        $updateValues[] = $color_bien;
                        $types .= 's';
                    }
                    if ($observacion_bien !== null) {
                        $updateFields[] = "observacion_bien = ?";
                        $updateValues[] = $observacion_bien;
                        $types .= 's';
                    }
                    if ($costo_bien !== null) {
                        $updateFields[] = "costo_bien = ?";
                        $updateValues[] = $costo_bien;
                        $types .= 'd';
                    }
                    if ($funcionamiento !== null) {
                        $updateFields[] = "funcionamiento = ?";
                        $updateValues[] = $funcionamiento;
                        $types .= 'i';
                    }
                    if ($id_pcasignada !== null) {
                        $updateFields[] = "id_pcasignada = ?";
                        $updateValues[] = $id_pcasignada;
                        $types .= 'i';
                    }

                    // Solo actualizar si hay campos para actualizar
                    if (!empty($updateFields)) {
                        $sql = "UPDATE bien SET " . implode(", ", $updateFields) . " WHERE id_bien = ?";
                        $updateValues[] = $id_bien;
                        $types .= 'i';

                        $updateStmt = $conn->prepare($sql);
                        $updateStmt->bind_param($types, ...$updateValues);

                        if ($updateStmt->execute()) {
                            if ($updateStmt->affected_rows > 0) {
                                $actualizados++;
                            }
                        } else {
                            $errores[] = "Error UPDATE fila $filaNumero: " . $updateStmt->error;
                        }
                        $updateStmt->close();
                    }
                } else {
                    // INSERTAR NUEVO REGISTRO CON ID (solo si hay datos mínimos)
                    if (empty($equipo_bien) || empty($marca_bien) || empty($modelo_bien)) {
                        $errores[] = "Fila $filaNumero: Faltan datos obligatorios para inserción (equipo, marca, modelo)";
                        continue;
                    }

                    $insertStmt = $conn->prepare("INSERT INTO bien 
                        (id_bien, equipo_bien, marca_bien, modelo_bien, procesador_bien,
                         numdeserie_bien, numcontropatri_bien, estado_bien, añodeadqs_bien,
                         numdeordendecom_bien, color_bien, observacion_bien, costo_bien,
                         funcionamiento, id_pcasignada) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $insertStmt->bind_param("issssssissdsii",
                        $id_bien, $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien,
                        $numdeserie_bien, $numcontropatri_bien, $estado_bien, $añodeadqs_bien,
                        $numdeordendecom_bien, $color_bien, $observacion_bien, $costo_bien,
                        $funcionamiento, $id_pcasignada
                    );

                    if ($insertStmt->execute()) {
                        $insertados++;
                    } else {
                        $errores[] = "Error INSERT ID fila $filaNumero: " . $insertStmt->error;
                    }
                    $insertStmt->close();
                }
            } else {
                // INSERTAR SIN ID (solo si hay datos mínimos obligatorios)
                if (empty($equipo_bien) || empty($marca_bien) || empty($modelo_bien)) {
                    $errores[] = "Fila $filaNumero: Faltan datos obligatorios para inserción (equipo, marca, modelo)";
                    continue;
                }

                $insertStmt = $conn->prepare("INSERT INTO bien 
                    (equipo_bien, marca_bien, modelo_bien, procesador_bien,
                     numdeserie_bien, numcontropatri_bien, estado_bien, añodeadqs_bien,
                     numdeordendecom_bien, color_bien, observacion_bien, costo_bien,
                     funcionamiento, id_pcasignada) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $insertStmt->bind_param("sssssssissdsii",
                    $equipo_bien, $marca_bien, $modelo_bien, $procesador_bien,
                    $numdeserie_bien, $numcontropatri_bien, $estado_bien, $añodeadqs_bien,
                    $numdeordendecom_bien, $color_bien, $observacion_bien, $costo_bien,
                    $funcionamiento, $id_pcasignada
                );

                if ($insertStmt->execute()) {
                    $insertados++;
                } else {
                    $errores[] = "Error INSERT fila $filaNumero: " . $insertStmt->error;
                }
                $insertStmt->close();
            }

        } catch (Exception $rowError) {
            $errores[] = "Error fila $filaNumero: " . $rowError->getMessage();
        }
    }

    // Confirmar / rollback
    if (count($errores) > 0 && ($actualizados + $insertados) == 0) {
        $conn->rollback();
        $conn->close();
        sendJsonResponse(['success' => false, 'error' => 'Errores críticos', 'details' => $errores]);
    }

    $conn->commit();
    $conn->close();

    // Respuesta con estadísticas detalladas
    $response = [
        'success' => true,
        'actualizados' => $actualizados,
        'insertados' => $insertados,
        'filas_saltadas' => $filasSaltadas,
        'total_procesadas' => count($rows) - 1, // Sin contar encabezados
        'message' => 'Procesamiento completado'
    ];

    if (!empty($errores)) {
        $response['warnings'] = array_slice($errores, 0, 10); // Mostrar máximo 10 errores
        $response['total_errores'] = count($errores);
    }

    sendJsonResponse($response);

} catch (Exception $e) {
    if (isset($conn) && $conn) {
        $conn->rollback();
        $conn->close();
    }
    sendJsonResponse(['success' => false, 'error' => $e->getMessage()]);
}
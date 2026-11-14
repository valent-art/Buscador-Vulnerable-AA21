<?php
// ✅ CÓDIGO SEGURO: Uso de Consultas Preparadas (Prepared Statements)
require_once '../config/conexion.php';

// Capturamos el parámetro de búsqueda
$q = $_GET['q'] ?? '';

// Verificamos que no esté vacío (opcional pero recomendado)
if (trim($q) === '') {
    http_response_code(400);
    echo json_encode(["error" => "El término de búsqueda no puede estar vacío."]);
    exit;
}

try {
    // 1. Fase de Preparación: Se envía la plantilla SQL con el marcador de posición (?)
    $sql = "SELECT id, nombre, categoria, precio, stock FROM productos WHERE nombre LIKE :busqueda";
    $stmt = $pdo->prepare($sql);

    // 2. Fase de Ejecución: Se enlaza el valor real como texto literal
    // El comodín % se agrega al valor, NO a la consulta SQL.
    $termino = "%" . $q . "%";
    $stmt->execute([':busqueda' => $termino]);

    // Obtenemos los resultados
    $resultado = $stmt->fetchAll();

    // Respuesta exitosa
    http_response_code(200);
    echo json_encode([
        "estado" => "exito",
        "total"  => count($resultado),
        "data"   => $resultado
    ], JSON_UNESCAPED_UNICODE);

} catch (\PDOException $e) {
    // Manejo de errores (no exponer detalles internos en producción)
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta de búsqueda."]);
    exit;
}
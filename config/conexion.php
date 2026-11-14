<?php
// Configuración de credenciales del servidor MySQL$ [cite: 74] [cite: 117]host    = 'localhost';
$db      = 'clase_backend';
$user    = 'root';
$pass    = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones de configuración del Driver PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza PDOException ante errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Devuelve arreglos asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                // Desactiva la emulación; fuerza Prepared Statements reales
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión con la base de datos: " . $e->getMessage()]);
    exit;
}
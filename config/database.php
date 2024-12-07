<?php
$host = 'localhost';
$dbname = 'sistema_vigilancia';
$username = 'root';
$password = '';

try {
    // Crear conexión usando mysqli
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Establecer el conjunto de caracteres a utf8mb4
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    // Manejo de errores
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Configurar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
?> 
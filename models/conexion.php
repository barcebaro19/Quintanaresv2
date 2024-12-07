<?php
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $db = "sistema_vigilancia";

    // Crear la conexión
    $conexion = new mysqli($servidor, $usuario, $contrasena, $db);

    // Establecer el conjunto de caracteres
    $conexion->set_charset('utf8');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Falla en la conexión: " . $conexion->connect_error);
    }

    // echo "Conexión exitosa a la base de datos";
?>
<?php
include "../models/conexion.php";

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["email"]) && !empty($_POST["celular"]) && !empty($_POST["contraseña"])) {
        
        // Obtener los datos del formulario
        $id = $_POST["id"];
        $email = $_POST["email"];
        $celular = $_POST["celular"];
        $contraseña = $_POST["contraseña"];

        try {
            // Llamar al procedimiento almacenado
            $stmt = $conexion->prepare("CALL actualizar_usuario(?, ?, ?, ?)");
            $stmt->bind_param("isss", $id, $email, $celular, $contraseña);
            
            if ($stmt->execute()) {
                header("Location: ../tablausu.php?mensaje=actualizado");
                exit();
            } else {
                throw new Exception("Error al actualizar los datos");
            }

        } catch (Exception $e) {
            header("Location: ../tablausu.php?mensaje=error");
            exit();
        }

    } else {
        header("Location: ../tablausu.php?mensaje=campos_vacios");
        exit();
    }
}

// Cerrar la conexión
$conexion->close();
?>
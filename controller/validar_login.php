<?php
session_start();
require_once "../models/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    // Consulta para verificar credenciales y obtener el rol
    $sql = "SELECT u.id, u.nombre, u.apellido, u.email, r.nombre_rol, r.id_rol 
            FROM usuarios u 
            JOIN roles r ON u.id_rol = r.id_rol 
            WHERE u.cedula = '$cedula' AND u.password = '$password'";
    
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Guardar datos en sesión incluyendo el id_rol
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nombre_rol'] = $usuario['nombre_rol'];
        $_SESSION['id_rol'] = $usuario['id_rol'];

        // Redirigir según el rol
        switch($usuario['nombre_rol']) {
            case 'administrador':
                header('Location: ../admin.php');
                break;
            case 'vigilante':
                header('Location: ../vigilante.php');
                break;
            case 'usuario':
                header('Location: ../usuario.php');
                break;
            default:
                $_SESSION['error'] = 'Rol de usuario no válido';
                header('Location: ../login.php');
        }
        exit();
    } else {
        $_SESSION['error'] = 'Cédula o contraseña incorrecta';
        header('Location: ../login.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}
?> 
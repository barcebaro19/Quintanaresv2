<?php
session_start();
include "../models/conexion.php";

if (isset($_POST['login'])) {
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener el rol
    $stmt = $conexion->prepare("SELECT u.id, u.nombre, u.apellido, u.email, ur.contraseña, r.nombre_rol 
                               FROM usuarios u 
                               JOIN usu_roles ur ON u.id = ur.usuarios_id 
                               JOIN roles r ON ur.roles_idroles = r.idroles 
                               WHERE u.id = ? AND ur.contraseña = ?");
    $stmt->bind_param("is", $cedula, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nombre_rol'] = $user['nombre_rol'];

        // Redirigir según el rol
        switch ($user['nombre_rol']) {
            case 'administrador':
                header("Location: ../Administrador1.php");
                break;
            case 'vigilante':
                header("Location: ../vigilante.php");
                break;
            case 'propietario':
                header("Location: ../usuario.php");
                break;
        }
        exit();
    } else {
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        header("Location: ../login.php");
        exit();
    }
} else {
    // Si no se envió el formulario correctamente
    $_SESSION['error'] = 'Acceso no válido';
    header("Location: ../login.php");
    exit();
}
?> 
<?php
session_start();
include "../models/conexion.php";


if (isset($_POST['login'])) {
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conexion->prepare ("select id, nombre, apellido, contraseña, roles_idroles from usuarios join usu_roles on id = usuarios_id
where id = ? and contraseña = ?");
    $stmt->bind_param("is", $cedula, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['roles_idroles'];

        // Redirigir según el rol
        switch ($user['roles_idroles']) {
            case 'administrador':
                header("Location: Administrador1.php");
                break;
            case 'vigilante':
                header("Location: vigilante.php");
                break;
            case 'propietario':
                header("Location: usuario.php");
                break;
        }
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }
}
?> 
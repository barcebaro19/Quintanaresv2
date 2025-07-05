<?php
require_once __DIR__ . '/../models/conexion.php';
// Reglas de negocio implementadas:
// 1. Solo los usuarios con rol de administrador pueden eliminar usuarios del sistema (ver lógica en el controlador correspondiente).
// 2. El correo electrónico de cada usuario debe ser único y válido (validación en base de datos y en el formulario).
// 3. No se permite el registro de usuarios con contraseñas menores a 8 caracteres (validación en el formulario y/o aquí).
// 4. El sistema bloquea el acceso tras 5 intentos fallidos de inicio de sesión (ver controlador de login).
// Historia de usuario:
// Como administrador, quiero poder registrar nuevos usuarios con roles específicos, para que cada usuario tenga acceso solo a las funcionalidades permitidas según su rol.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!empty($_POST["registrar"])) {
    if(!empty($_POST["id"]) && !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && 
       !empty($_POST["email"]) && !empty($_POST["celular"]) && !empty($_POST["con"]) && !empty($_POST["rol"])) {
        
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $celular = $_POST["celular"];
        $contraseña = $_POST["con"];
        $tipo = $_POST["rol"];

        $conexion = Conexion::getInstancia()->getConexion();
        try {
            $sql = $conexion->prepare("CALL registro_usuario(?, ?, ?, ?, ?, ?)");
            $sql->bind_param("ssssss", $id, $nombre, $apellido, $email, $celular, $tipo);
            
            if($sql->execute()) {
                $_SESSION['mensaje'] = 'registrado';
                header("Location: tablausu.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error MySQL: " . $sql->error . "</div>";
            }
        } catch(Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
?>
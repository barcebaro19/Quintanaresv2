<?php
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
        $rol = $_POST["rol"];

        try {
            $sql = $conexion->prepare("CALL registro_usuario(?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param("ssssssi", $id, $nombre, $apellido, $email, $celular, $contraseña, $rol);
            
            if($sql->execute()) {
                $_SESSION['mensaje'] = 'registrado';
                header("Location: tablausu.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Usuario ya registrado</div>";
            }
        } catch(Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
?>
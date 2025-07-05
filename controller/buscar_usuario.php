<?php
require_once "models/conexion.php";

function buscarUsuarios($valor) {
    $conn = Conexion::getInstancia()->getConexion();
    
    $sql = "SELECT 
        u.id,
        u.nombre,
        u.apellido,
        u.email,
        u.celular,
        u.tipo AS nombre_rol
    FROM 
        usuarios u";
    
    if(!empty($valor)) {
        $sql .= " WHERE u.nombre LIKE ? OR u.id LIKE ?";
        $stmt = $conn->prepare($sql);
        $busqueda = "%$valor%";
        $stmt->bind_param("ss", $busqueda, $busqueda);
    } else {
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    return $stmt->get_result();
}
?> 
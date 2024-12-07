<?php
include "models/conexion.php";

function buscarUsuarios($valor) {
    global $conexion;
    
    $sql = "SELECT 
        u.id,
        u.nombre,
        u.apellido,
        u.email,
        u.celular,
        ur.contraseña,
        r.nombre_rol
    FROM 
        usu_roles ur 
    INNER JOIN 
        usuarios u ON ur.usuarios_id = u.id 
    INNER JOIN 
        roles r ON ur.roles_idroles = r.idroles";
    
    if(!empty($valor)) {
        $sql .= " WHERE u.nombre LIKE ? OR u.id LIKE ?";
        $stmt = $conexion->prepare($sql);
        $busqueda = "%$valor%";
        $stmt->bind_param("ss", $busqueda, $busqueda);
    } else {
        $stmt = $conexion->prepare($sql);
    }
    
    $stmt->execute();
    return $stmt->get_result();
}
?> 
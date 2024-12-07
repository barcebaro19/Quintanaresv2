<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <?php
    include "models/conexion.php";

    // Obtener el ID del usuario a modificar
    $id = $_GET['id'];
    
    // Consultar los datos del usuario
    $sql = "SELECT u.*, ur.contraseña 
            FROM usuarios u 
            INNER JOIN usu_roles ur ON u.id = ur.usuarios_id 
            WHERE u.id = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        echo "Error al obtener los datos del usuario";
        exit;
    }
    ?>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8 space-y-8">
            <div class="text-center">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-4 mb-6 inline-block">
                    <i class="fas fa-user-edit text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Modificar Usuario</h2>
                <p class="text-sm text-gray-600">Actualice los campos permitidos</p>
            </div>

            <form action="controller/modificar_usuario.php" method="POST" class="mt-8 space-y-6">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                <input type="hidden" name="btnmodificar" value="ok">
                
                <div class="rounded-md shadow-sm space-y-4">
                    <!-- Campos de solo lectura -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                        <input type="text" value="<?php echo $usuario['id']; ?>" readonly
                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>

                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" value="<?php echo $usuario['nombre']; ?>" readonly
                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>

                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <input type="text" value="<?php echo $usuario['apellido']; ?>" readonly
                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>

                    <!-- Campos editables -->
                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="group">
                        <label for="celular" class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                        <input type="text" name="celular" value="<?php echo $usuario['celular']; ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="group">
                        <label for="contraseña" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="text" name="contraseña" value="<?php echo $usuario['contraseña']; ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <button type="button" onclick="window.location.href='tablausu.php'" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </button>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 
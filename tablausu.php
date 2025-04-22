<?php
include "models/conexion.php";
include "controller/buscar_usuario.php";

$resultado = null;

if(isset($_POST['buscar'])) {
    $valor = isset($_POST['nom']) ? $_POST['nom'] : '';
    $resultado = buscarUsuarios($valor);
} else {
    $resultado = buscarUsuarios('');
}
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .gradient-background {
            background: linear-gradient(-45deg, 
                rgba(147, 51, 234, 0.7),
                rgba(79, 70, 229, 0.7),
                rgba(59, 130, 246, 0.7),
                rgba(236, 72, 153, 0.7)
            );
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="gradient-background min-h-screen">
    <?php include 'components/header.php'; ?>

    <div class="container mx-auto px-4 py-8 pt-20">
        <div class="glass-effect rounded-xl p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestión de Usuarios</h1>
                <p class="text-gray-600">Administra los usuarios del sistema</p>
            </div>

            <!-- Búsqueda y Acciones -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <form action="tablausu.php" method="POST" class="flex-1 flex gap-4">
                    <div class="relative flex-1">
                        <input type="text" 
                               name="nom"
                               class="input input-bordered w-full pl-10" 
                               placeholder="Buscar por cédula o nombre..."
                               value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : ''; ?>">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button type="submit" name="buscar" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    <button type="button" onclick="limpiarBusqueda()" class="btn btn-ghost">
                        <i class="fas fa-sync-alt mr-2"></i>Limpiar
                    </button>
                </form>
                <div class="flex gap-2">
                    <a href="controller/exportar_usuarios.php" class="btn btn-secondary h-12 px-6 text-lg">
                        <i class="fas fa-file-excel mr-2"></i>Exportar Excel
                    </a>
                    <a href="registrarusu.php" class="btn btn-primary h-12 px-6 text-lg">
                        <i class="fas fa-user-plus mr-2"></i>Nuevo Usuario
                    </a>
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="px-4 py-3">Cédula</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Apellido</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Celular</th>
                            <th class="px-4 py-3">Contraseña</th>
                            <th class="px-4 py-3">Rol</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($resultado && $resultado->num_rows > 0) {
                            while($row = $resultado->fetch_assoc()) {
                        ?>
                        <tr class="table-row hover:bg-white/50">
                            <td class="px-4 py-3"><?php echo $row['id']?></td>
                            <td class="px-4 py-3"><?php echo $row['nombre']?></td>
                            <td class="px-4 py-3"><?php echo $row['apellido']?></td>
                            <td class="px-4 py-3"><?php echo $row['email']?></td>
                            <td class="px-4 py-3"><?php echo $row['celular']?></td>
                            <td class="px-4 py-3"><?php echo $row['contraseña']?></td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    <?php 
                                    echo $row['nombre_rol'] == 'administrador' ? 'bg-purple-100 text-purple-800' : 
                                        ($row['nombre_rol'] == 'vigilante' ? 'bg-blue-100 text-blue-800' : 
                                        'bg-green-100 text-green-800');
                                    ?>">
                                    <?php echo $row['nombre_rol']?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <a href="modificarusu.php?id=<?php echo $row['id']; ?>" 
                                       class="action-btn btn btn-ghost btn-sm text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $row['id']; ?>)" 
                                            class="action-btn btn btn-ghost btn-sm text-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <a href="generate_pdf.php?id=<?php echo $row['id']; ?>" 
                                       class="action-btn btn btn-ghost btn-sm text-green-600"
                                       target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500">No se encontraron resultados</p>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <dialog id="modal_eliminar" class="modal modal-bottom sm:modal-middle">
        <form method="dialog" class="modal-box">
            <h3 class="font-bold text-lg">¿Confirmar eliminación?</h3>
            <p class="py-4">Esta acción no se puede deshacer.</p>
            <div class="modal-action">
                <button class="btn">Cancelar</button>
                <button class="btn btn-error" onclick="eliminarUsuario()">Eliminar</button>
            </div>
        </form>
    </dialog>

    <?php include 'components/footer.php'; ?>

    <script>
        let usuarioIdEliminar = null;

        function confirmarEliminar(id) {
            usuarioIdEliminar = id;
            document.getElementById('modal_eliminar').showModal();
        }

        function eliminarUsuario() {
            if (usuarioIdEliminar) {
                window.location.href = `controller/eliminar_usuario.php?id=${usuarioIdEliminar}`;
            }
        }

        function limpiarBusqueda() {
            window.location.href = 'tablausu.php';
        }
    </script>
</body>
</html>
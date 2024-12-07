<?php
session_start();
if(!isset($_SESSION['nombre'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Vehículos | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .dashboard-container {
            flex: 1;
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
            display: flex;
            flex-direction: column;
        }

        .navbar-menu {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        main {
            flex: 1;
            padding-top: 5rem;
            padding-bottom: 2rem;
        }

        .vehicle-card {
            background: white;
            border-radius: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .vehicle-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 1.5rem 1rem;
        }

        .vehicle-card-content {
            padding: 1rem 1.5rem 1.5rem;
        }

        .vehicle-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .vehicle-card-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            color: #6B7280;
        }

        .vehicle-card-info i {
            color: #4F46E5;
            margin-right: 0.5rem;
        }

        /* Estilos responsivos */
        @media (max-width: 767px) {
            main {
                padding-top: 4rem;
            }

            .vehicle-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Navbar -->
        <nav class="navbar-menu">
            <div class="container mx-auto flex justify-between items-center p-4">
                <a href="usuario.php" class="text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <h1 class="text-xl font-bold text-gray-800">Mis Vehículos</h1>
                <div class="flex-none gap-2">
                    <!-- Aquí puedes agregar más opciones si es necesario -->
                </div>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <button onclick="document.getElementById('modal-agregar-vehiculo').showModal()" 
                        class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar Vehículo
                </button>
            </div>

            <!-- Lista de Vehículos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Vehículo -->
                <div class="vehicle-card animate__animated animate__fadeIn">
                    <div class="vehicle-card-header">
                        <div class="text-3xl text-indigo-600">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="dropdown dropdown-end">
                            <button tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a class="text-blue-600">
                                    <i class="fas fa-edit mr-2"></i>Editar
                                </a></li>
                                <li><a class="text-red-600">
                                    <i class="fas fa-trash-alt mr-2"></i>Eliminar
                                </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="vehicle-card-content">
                        <h3 class="vehicle-card-title">Toyota Corolla</h3>
                        <div class="vehicle-card-info">
                            <p><i class="fas fa-hashtag"></i>ABC-123</p>
                            <p><i class="fas fa-palette"></i>Negro</p>
                            <p><i class="fas fa-calendar-alt"></i>2020</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal Agregar Vehículo -->
        <dialog id="modal-agregar-vehiculo" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Agregar Nuevo Vehículo</h3>
                <form method="POST" action="controller/agregar_vehiculo.php">
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Marca y Modelo</span>
                            </label>
                            <input type="text" name="modelo" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Placa</span>
                            </label>
                            <input type="text" name="placa" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Color</span>
                            </label>
                            <input type="text" name="color" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Año</span>
                            </label>
                            <input type="number" name="anio" class="input input-bordered" required>
                        </div>
                    </div>
                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn" onclick="document.getElementById('modal-agregar-vehiculo').close()">Cancelar</button>
                    </div>
                </form>
            </div>
        </dialog>

        <!-- Footer -->
        <?php include 'components/footer.php'; ?>
    </div>
</body>
</html>
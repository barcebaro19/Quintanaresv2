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
    <title>Panel Usuario | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .dashboard-container {
            flex: 1;
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding-bottom: 0;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.15);
        }

        .action-card {
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .action-card:hover::before {
            transform: translateX(100%);
        }

        .action-card:hover {
            transform: translateY(-5px);
        }

        .avatar-circle {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
        }

        .welcome-text {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .action-icon {
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .table-container {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .btn-custom {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            transition: 0.5s;
        }

        .btn-custom:hover::after {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Navbar -->
        <nav class="navbar-menu">s
            <div class="navbar container mx-auto">
                <div class="flex-1">
                    <a href="usuario.php" class="text-xl font-bold text-gray-800">
                        <i class="fas fa-parking text-indigo-600 mr-2"></i>
                        Parkovisco
                    </a>
                </div>
                <div class="flex-none gap-2">
                    <!-- Notificaciones -->
                    <div class="dropdown dropdown-end">
                        <button class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="badge badge-sm badge-primary indicator-item">2</span>
                            </div>
                        </button>
                        <div class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow">
                            <div class="card-body">
                                <span class="font-bold text-lg">2 Notificaciones</span>
                                <div class="divide-y">
                                    <div class="py-3">
                                        <p class="text-sm">Su reserva ha sido confirmada</p>
                                        <span class="text-xs text-gray-500">Hace 5 minutos</span>
                                    </div>
                                    <div class="py-3">
                                        <p class="text-sm">Recordatorio: Pago pendiente</p>
                                        <span class="text-xs text-gray-500">Hace 1 hora</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perfil -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="avatar-circle w-10 h-10 rounded-full flex items-center justify-center text-white cursor-pointer">
                            <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <div class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-900">
                                    <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?php echo $_SESSION['email']; ?>
                                </p>
                            </div>
                            <div class="divide-y divide-gray-100">
                                <li><a href="perfil.php" class="text-gray-700">
                                    <i class="fas fa-user mr-2"></i> Mi Perfil
                                </a></li>
                                <li><a href="mis_vehiculos.php" class="text-gray-700">
                                    <i class="fas fa-car mr-2"></i> Mis Vehículos
                                </a></li>
                                <li><a href="historial_reservas.php" class="text-gray-700">
                                    <i class="fas fa-history mr-2"></i> Historial
                                </a></li>
                                <li><a href="controller/logout.php" class="text-red-500">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </a></li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="container mx-auto px-4 py-8 pt-20">
            <!-- Información del Usuario -->
            <div class="glass-card p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-24 h-24 avatar-circle rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg float-animation">
                        <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                    </div>
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl font-bold welcome-text mb-2">Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
                        <p class="text-gray-600 text-lg">¿Qué deseas hacer hoy?</p>
                    </div>
                </div>
            </div>

            <!-- Acciones Principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Generar Reserva -->
                <div class="glass-card p-8 action-card">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-plus text-3xl text-white action-icon"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Generar Reserva</h3>
                        <p class="text-gray-600 mb-6">Reserva un espacio para tu vehículo de manera rápida y sencilla</p>
                        <button onclick="window.location.href='generar_reserva.php'" 
                                class="btn btn-primary btn-custom w-full text-lg h-12">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Reservar Ahora
                        </button>
                    </div>
                </div>

                <!-- Cancelar Reserva -->
                <div class="glass-card p-8 action-card">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-times text-3xl text-white action-icon"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Cancelar Reserva</h3>
                        <p class="text-gray-600 mb-6">¿Cambio de planes? Cancela tu reserva sin complicaciones</p>
                        <button onclick="window.location.href='cancelar_reserva.php'" 
                                class="btn btn-error btn-custom w-full text-lg h-12">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar Reserva
                        </button>
                    </div>
                </div>

                <!-- Reportar Incidente -->
                <div class="glass-card p-8 action-card">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-exclamation-triangle text-3xl text-white action-icon"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Reportar Incidente</h3>
                        <p class="text-gray-600 mb-6">¿Algún problema? Reporta cualquier incidente con tu vehículo</p>
                        <button onclick="window.location.href='reportar_incidente.php'" 
                                class="btn btn-warning btn-custom w-full text-lg h-12">
                            <i class="fas fa-flag mr-2"></i>
                            Reportar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Resumen de Actividad -->
            <div class="glass-card p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Actividad Reciente</h3>
                    <button class="btn btn-ghost btn-sm">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Actualizar
                    </button>
                </div>
                <div class="overflow-x-auto table-container">
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 font-semibold text-gray-600">Fecha</th>
                                <th class="px-6 py-4 font-semibold text-gray-600">Tipo</th>
                                <th class="px-6 py-4 font-semibold text-gray-600">Estado</th>
                                <th class="px-6 py-4 font-semibold text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">2024-04-12</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge bg-blue-100 text-blue-800">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Reserva
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="status-badge bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Activa
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="btn btn-ghost btn-sm text-blue-600 hover:bg-blue-50">
                                        <i class="fas fa-eye mr-2"></i>
                                        Ver Detalles
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php include 'components/footer.php'; ?>
    </div>
</body>
</html> 
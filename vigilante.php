<?php
session_start();
if(isset($_SESSION['nombre']));
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Vigilante | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
            min-height: 100vh;
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

        .stat-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .nav-link {
            padding: 1rem;
            border-radius: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #4B5563;
            margin-bottom: 0.5rem;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #4F46E5;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .nav-link i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .action-button {
            transition: all 0.3s ease;
            border-radius: 1rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        .action-button:hover {
            transform: translateY(-2px);
        }

        .action-button i {
            font-size: 1.25rem;
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
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge i {
            font-size: 0.75rem;
        }

        .record-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 1rem;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .record-card:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateX(4px);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .pulse-on-hover:hover {
            animation: pulse 2s infinite;
        }

        .gradient-text {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            background: rgba(255, 255, 255, 0.9);
        }

        .logout-button {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #EF4444;
            transition: all 0.3s ease;
            background: rgba(239, 68, 68, 0.1);
        }

        .logout-button:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .stat-trend {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .trend-up {
            color: #10B981;
        }

        .trend-down {
            color: #EF4444;
        }
    </style>
</head>
<body class="dashboard-container">
    <?php include 'components/header.php'; ?>

    <div class="flex min-h-screen">
        <!-- Sidebar mejorado -->
        <aside class="glass-card w-72 fixed h-full pt-16 m-4 overflow-hidden">
            <div class="p-6">
                <!-- Perfil mejorado -->
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold gradient-text">Panel de Vigilante</h3>
                            <div class="flex items-center gap-2 text-green-600">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-sm font-medium">En servicio</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navegación mejorada -->
                <nav class="space-y-1">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-car-side"></i>
                        <span>Control de Entrada</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Control de Salida</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Registro de Visitas</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Reportar Incidente</span>
                    </a>
                </nav>

                <!-- Información del turno -->
                <div class="mt-8 p-4 bg-indigo-50 rounded-xl">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-clock text-indigo-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800">Turno Actual</h4>
                    </div>
                    <p class="text-sm text-gray-600">Inicio: 8:00 AM</p>
                    <p class="text-sm text-gray-600">Fin: 4:00 PM</p>
                </div>
            </div>

            <!-- Footer con botón de cerrar sesión -->
            <div class="sidebar-footer">
                <button onclick="window.location.href='controller/logout.php'" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </div>
        </aside>

        <!-- Contenido Principal mejorado -->
        <main class="flex-1 ml-80 p-8 pt-20">
            <!-- Stats Cards mejorados -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="glass-card p-6 pulse-on-hover">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-gradient-to-br from-green-400 to-green-600 text-white">
                            <i class="fas fa-car text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">45</div>
                            <div class="text-sm font-medium text-gray-500">Vehículos Actuales</div>
                        </div>
                    </div>
                </div>

                <!-- Espacios Disponibles -->
                <div class="glass-card p-6 pulse-on-hover">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-gradient-to-br from-blue-400 to-blue-600 text-white">
                            <i class="fas fa-parking text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">28</div>
                            <div class="text-sm font-medium text-gray-500">Espacios Libres</div>
                        </div>
                    </div>
                </div>

                <!-- Espacios para Visitantes -->
                <div class="glass-card p-6 pulse-on-hover">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-gradient-to-br from-purple-400 to-purple-600 text-white">
                            <i class="fas fa-user-clock text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">15</div>
                            <div class="text-sm font-medium text-gray-500">Espacios Visitantes</div>
                        </div>
                    </div>
                </div>

                <!-- Espacios Reservados -->
                <div class="glass-card p-6 pulse-on-hover">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-gradient-to-br from-amber-400 to-amber-600 text-white">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">32</div>
                            <div class="text-sm font-medium text-gray-500">Espacios Usuarios</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Estado de Parqueadero -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Estado de Espacios -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold mb-6 gradient-text">Estado de Espacios</h2>
                    <div class="space-y-4">
                        <!-- Espacios Totales -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-th text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Espacios Totales</p>
                                    <p class="font-bold text-gray-800">75</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-500">Capacidad Total</p>
                            </div>
                        </div>

                        <!-- Espacios Ocupados -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-car text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Espacios Ocupados</p>
                                    <p class="font-bold text-gray-800">47</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-red-500">62.6%</p>
                            </div>
                        </div>

                        <!-- Espacios Disponibles -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Espacios Disponibles</p>
                                    <p class="font-bold text-gray-800">28</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-500">37.4%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Distribución de Espacios -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold mb-6 gradient-text">Distribución de Espacios</h2>
                    <div class="space-y-4">
                        <!-- Espacios para Usuarios -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Usuarios Registrados</p>
                                    <p class="font-bold text-gray-800">32/40</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-blue-500">80%</p>
                            </div>
                        </div>

                        <!-- Espacios para Visitantes -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-user-clock text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Visitantes</p>
                                    <p class="font-bold text-gray-800">15/35</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-purple-500">42.8%</p>
                            </div>
                        </div>

                        <!-- Espacios Reservados -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-bookmark text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Reservados</p>
                                    <p class="font-bold text-gray-800">12</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-amber-500">16%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas mejoradas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold mb-6 gradient-text">Control Rápido</h2>
                    <div class="space-y-4">
                        <button class="action-button w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <i class="fas fa-car-side"></i>
                            Registrar Entrada
                        </button>
                        <button class="action-button w-full bg-gradient-to-r from-red-600 to-pink-600 text-white">
                            <i class="fas fa-sign-out-alt"></i>
                            Registrar Salida
                        </button>
                    </div>
                </div>

                <!-- Últimos Registros mejorados -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold mb-6 gradient-text">Últimos Registros</h2>
                    <div class="space-y-4">
                        <div class="record-card">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-car-side text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">ABC-123</p>
                                        <p class="text-sm text-gray-500">Entrada - Hace 5 min</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Repite para más registros -->
                    </div>
                </div>
            </div>

            <!-- Tabla mejorada -->
            <div class="glass-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold gradient-text">Vehículos en Parqueadero</h2>
                    <div class="flex gap-2">
                        <button class="btn btn-ghost btn-sm">
                            <i class="fas fa-filter mr-2"></i>
                            Filtrar
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            <i class="fas fa-download mr-2"></i>
                            Exportar
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <!-- Contenido de la tabla actual -->
                </div>
            </div>
        </main>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html></html>

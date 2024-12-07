<?php
session_start();
if(isset($_SESSION['nombre']));
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(148, 163, 184, 0.1);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #4B5563;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #4F46E5;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: #4F46E5;
            color: white;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .activity-item {
            padding: 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.8);
            border-color: rgba(99, 102, 241, 0.2);
            transform: translateX(4px);
        }

        .profile-section {
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1F2937;
            line-height: 1;
        }

        .stat-label {
            color: #6B7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Estilos para el submenú */
        #reservasSubmenu .nav-link {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }

        #reservasSubmenu .nav-link:hover {
            background: rgba(99, 102, 241, 0.05);
        }

        /* Transición suave para la flecha */
        #reservasArrow {
            transition: transform 0.3s ease;
        }

        /* Animación para el submenú */
        #reservasSubmenu {
            transition: all 0.3s ease;
        }

        #reservasSubmenu:not(.hidden) {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        footer {
        position: relative;
        z-index: 1;
        }

        .sidebar {
            position: relative;
            z-index: 0;
        }

        footer {
            position: relative;
            z-index: 1;
            margin-top: 2rem;
        }
    </style>
</head>
<body class="dashboard-container">
    <?php include 'components/header.php'; ?>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 fixed h-full pt-16">
            <div class="p-6">
                <!-- Perfil -->
                <div class="profile-section">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Brayan Sebastian</h3>
                            <p class="text-sm text-indigo-600">Administrador</p>
                        </div>
                    </div>
                </div>

                <!-- Navegación -->
                <nav class="space-y-2">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="tablausu.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-car"></i>
                        <span>Parqueaderos</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-shield-alt"></i>
                        <span>Vigilantes</span>
                    </a>
                    <!-- Menú desplegable de Reservas -->
                    <div class="space-y-2">
                        <button onclick="toggleReservasMenu()" class="nav-link w-full flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Reservas</span>
                            </div>
                            <i class="fas fa-chevron-down transition-transform" id="reservasArrow"></i>
                        </button>
                        
                        <!-- Subopciones de Reservas -->
                        <div class="hidden pl-8 space-y-2" id="reservasSubmenu">
                            <a href="nueva_reserva.php" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <span>Nueva Reserva</span>
                            </a>
                            <a href="ver_reservas.php" class="nav-link">
                                <i class="fas fa-list"></i>
                                <span>Ver Reservas</span>
                            </a>
                            <a href="historial_reservas.php" class="nav-link">
                                <i class="fas fa-history"></i>
                                <span>Historial</span>
                            </a>
                            <a href="reportes_reservas.php" class="nav-link">
                                <i class="fas fa-file-alt"></i>
                                <span>Reportes</span>
                            </a>
                        </div>
                    </div>
                    <a href="#" class="nav-link">
                        <i class="fas fa-car-side"></i>
                        <span>Vehículos</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 ml-64 p-8 pt-20">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card p-6 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-indigo-100">
                            <i class="fas fa-parking text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="stat-value">190</div>
                            <div class="stat-label">Espacios Totales</div>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-green-100">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="stat-value">106</div>
                            <div class="stat-label">Espacios Disponibles</div>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-amber-100">
                            <i class="fas fa-users text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="stat-value">128</div>
                            <div class="stat-label">Propietarios</div>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-6 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-purple-100">
                            <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="stat-value">12</div>
                            <div class="stat-label">Reservas Activas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Gráfico de Estadísticas -->
                <div class="lg:col-span-2 chart-container p-6 animate-fade-in" style="animation-delay: 0.5s">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Estadísticas de Ocupación</h2>
                    <div class="h-[400px]">
                        <canvas id="ocupacionChart"></canvas>
                    </div>
                </div>

                <!-- Actividad Reciente -->
                <div class="stat-card p-6 animate-fade-in" style="animation-delay: 0.6s">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Actividad Reciente</h2>
                    <div class="space-y-4">
                        <div class="activity-item">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <i class="fas fa-car text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Nuevo vehículo registrado</p>
                                    <p class="text-sm text-gray-500">Hace 5 minutos</p>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <i class="fas fa-user-plus text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Nuevo propietario registrado</p>
                                    <p class="text-sm text-gray-500">Hace 15 minutos</p>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-amber-100 rounded-lg">
                                    <i class="fas fa-key text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Reserva completada</p>
                                    <p class="text-sm text-gray-500">Hace 30 minutos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Acciones Rápidas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Nuevo Usuario -->
                    <a href="registrarusu.php" class="stat-card p-6 hover:bg-indigo-50 group cursor-pointer animate-fade-in" style="animation-delay: 0.7s">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors">
                                <i class="fas fa-user-plus text-indigo-600 text-xl"></i>
                            </div>
                            <span class="font-medium text-gray-700">Nuevo Usuario</span>
                        </div>
                    </a>

                    <!-- Nueva Reserva -->
                    <a href="nueva_reserva.php" class="stat-card p-6 hover:bg-green-50 group cursor-pointer animate-fade-in" style="animation-delay: 0.8s">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors">
                                <i class="fas fa-calendar-plus text-green-600 text-xl"></i>
                            </div>
                            <span class="font-medium text-gray-700">Nueva Reserva</span>
                        </div>
                    </a>

                    <!-- Registrar Vehículo -->
                    <a href="registrar_vehiculo.php" class="stat-card p-6 hover:bg-purple-50 group cursor-pointer animate-fade-in" style="animation-delay: 0.9s">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-purple-100 rounded-xl group-hover:bg-purple-200 transition-colors">
                                <i class="fas fa-car text-purple-600 text-xl"></i>
                            </div>
                            <span class="font-medium text-gray-700">Registrar Vehículo</span>
                        </div>
                    </a>

                    <!-- Generar Reporte -->
                    <a href="generar_reporte.php" class="stat-card p-6 hover:bg-amber-50 group cursor-pointer animate-fade-in" style="animation-delay: 1s">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-amber-100 rounded-xl group-hover:bg-amber-200 transition-colors">
                                <i class="fas fa-file-alt text-amber-600 text-xl"></i>
                            </div>
                            <span class="font-medium text-gray-700">Generar Reporte</span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <?php include 'components/footer.php'; ?>
    <script>
        // Configuración del gráfico de ocupación
        const ctx = document.getElementById('ocupacionChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Espacios Totales', 'Espacios Disponibles', 'Reservas Activas'],
                datasets: [{
                    data: [190, 106, 12],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',  // Indigo
                        'rgba(16, 185, 129, 0.8)',  // Verde
                        'rgba(245, 158, 11, 0.8)'   // Ámbar
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        function toggleReservasMenu() {
            const submenu = document.getElementById('reservasSubmenu');
            const arrow = document.getElementById('reservasArrow');
            
            submenu.classList.toggle('hidden');
            arrow.style.transform = submenu.classList.contains('hidden') ? 
                'rotate(0deg)' : 'rotate(180deg)';
        }
    </script>
</body>
</html>


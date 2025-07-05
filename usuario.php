<?php
session_start();
if(!isset($_SESSION['nombre']) || $_SESSION['nombre_rol'] !== 'propietario') {
    header('Location: login.php');
    exit();
}

require_once "models/conexion.php";

// Obtener los vehículos del usuario
$stmt = $conexion->prepare("SELECT v.*, e.nombre as estado_nombre, p.numero as espacio_numero, p.nivel as espacio_nivel 
                          FROM vehiculos v 
                          LEFT JOIN estados e ON v.id_estado = e.id_estado 
                          LEFT JOIN espacios p ON v.id_espacio = p.id_espacio 
                          WHERE v.id_usuario = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$vehiculos = $stmt->get_result();

// Obtener los espacios disponibles
$stmt = $conexion->prepare("SELECT p.*, e.nombre as estado_nombre, 
                          (SELECT COUNT(*) FROM vehiculos v WHERE v.id_espacio = p.id_espacio) as ocupado
                          FROM espacios p 
                          JOIN estados e ON p.id_estado = e.id_estado 
                          ORDER BY p.nivel, p.numero");
$stmt->execute();
$espacios = $stmt->get_result();

// Agrupar espacios por nivel
$espacios_por_nivel = [];
while($espacio = $espacios->fetch_assoc()) {
    $nivel = $espacio['nivel'];
    if(!isset($espacios_por_nivel[$nivel])) {
        $espacios_por_nivel[$nivel] = [];
    }
    $espacios_por_nivel[$nivel][] = $espacio;
}

// Obtener las visitas programadas
$stmt = $conexion->prepare("SELECT * FROM visitas WHERE id_usuario = ? ORDER BY fecha_visita DESC, hora_inicio DESC");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$visitas = $stmt->get_result();

// Procesar el formulario de visita si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'agendar_visita') {
    $nombre_visitante = $_POST['nombre_visitante'];
    $documento_visitante = $_POST['documento_visitante'];
    $placa_vehiculo = $_POST['placa_vehiculo'];
    $fecha_visita = $_POST['fecha_visita'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $motivo = $_POST['motivo'];
    $id_usuario = $_SESSION['id'];

    $stmt = $conexion->prepare("INSERT INTO visitas (nombre_visitante, documento_visitante, placa_vehiculo, 
                               fecha_visita, hora_inicio, hora_fin, motivo, id_usuario, estado) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pendiente')");
    $stmt->bind_param("sssssssi", $nombre_visitante, $documento_visitante, $placa_vehiculo, 
                      $fecha_visita, $hora_inicio, $hora_fin, $motivo, $id_usuario);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'success';
        header('Location: usuario.php#visitas');
        exit();
    } else {
        $_SESSION['mensaje'] = 'error';
        header('Location: usuario.php#visitas');
        exit();
    }
}

// Procesar el formulario de daño si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reportar_dano') {
    $tipo_dano = $_POST['tipo_dano'];
    $descripcion = $_POST['descripcion'];
    $id_vehiculo = $_POST['id_vehiculo'];
    $id_usuario = $_SESSION['id'];

    $stmt = $conexion->prepare("INSERT INTO danos (tipo_dano, descripcion, id_vehiculo, id_usuario, estado) 
                               VALUES (?, ?, ?, ?, 'Pendiente')");
    $stmt->bind_param("ssii", $tipo_dano, $descripcion, $id_vehiculo, $id_usuario);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'success';
        header('Location: usuario.php#danos');
        exit();
    } else {
        $_SESSION['mensaje'] = 'error';
        header('Location: usuario.php#danos');
        exit();
    }
}

// Obtener los daños reportados
$stmt = $conexion->prepare("SELECT d.*, v.placa 
                          FROM danos d 
                          JOIN vehiculos v ON d.id_vehiculo = v.id_vehiculo 
                          WHERE d.id_usuario = ? 
                          ORDER BY d.fecha_reporte DESC");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$danos = $stmt->get_result();

// Obtener las notificaciones
$stmt = $conexion->prepare("SELECT * FROM notificaciones 
                          WHERE id_usuario = ? 
                          ORDER BY fecha DESC 
                          LIMIT 10");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$notificaciones = $stmt->get_result();
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

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-button {
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            opacity: 1;
            border-bottom: 2px solid #4f46e5;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen gradient-background">
    <!-- Navbar -->
    <nav class="navbar bg-base-100 shadow-lg fixed top-0 z-50">
        <div class="flex-1">
            <a href="usuario.php" class="btn btn-ghost normal-case text-xl">
                <i class="fas fa-parking text-indigo-600 mr-2"></i>
                Parkovisco
            </a>
        </div>
        <div class="flex-none gap-2">
            <!-- Notificaciones -->
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="badge badge-sm indicator-item"><?php echo $notificaciones->num_rows; ?></span>
                    </div>
                </label>
                <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                    <div class="card-body">
                        <span class="font-bold text-lg">Notificaciones</span>
                        <div class="text-sm">
                            <?php if($notificaciones && $notificaciones->num_rows > 0): ?>
                                <?php while($notif = $notificaciones->fetch_assoc()): ?>
                                    <div class="p-2 hover:bg-gray-100 rounded-lg cursor-pointer">
                                        <p class="font-semibold"><?php echo $notif['titulo']; ?></p>
                                        <p class="text-gray-600"><?php echo $notif['mensaje']; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo date('d/m/Y H:i', strtotime($notif['fecha'])); ?></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="p-2">
                                    <p class="text-gray-600">No hay notificaciones</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-actions">
                            <button class="btn btn-primary btn-block btn-sm" onclick="showTab('notificaciones')">Ver todas</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perfil -->
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full bg-indigo-600 text-white flex items-center justify-center">
                        <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li class="p-2">
                        <div class="font-semibold"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></div>
                        <div class="text-sm text-gray-600"><?php echo $_SESSION['email']; ?></div>
                    </li>
                    <div class="divider my-0"></div>
                    <li><a href="perfil.php"><i class="fas fa-user mr-2"></i> Mi Perfil</a></li>
                    <li><a href="logout.php" class="text-red-600"><i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mx-auto px-4 pt-20 pb-8">
        <!-- Bienvenida -->
        <div class="glass-effect rounded-xl p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
            <p class="text-gray-600">¿Qué deseas hacer hoy?</p>
        </div>

        <!-- Tabs de Navegación -->
        <div class="tabs tabs-boxed bg-base-100 mb-8">
            <a class="tab-button active" onclick="showTab('vehiculos')">
                <i class="fas fa-car mr-2"></i>Mis Vehículos
            </a>
            <a class="tab-button" onclick="showTab('espacios')">
                <i class="fas fa-parking mr-2"></i>Espacios Disponibles
            </a>
            <a class="tab-button" onclick="showTab('visitas')">
                <i class="fas fa-calendar-alt mr-2"></i>Agendar Visita
            </a>
            <a class="tab-button" onclick="showTab('danos')">
                <i class="fas fa-exclamation-triangle mr-2"></i>Reportar Daño
            </a>
            <a class="tab-button" onclick="showTab('notificaciones')">
                <i class="fas fa-bell mr-2"></i>Notificaciones
            </a>
        </div>

        <!-- Mensajes de éxito/error -->
        <?php if(isset($_SESSION['mensaje'])): ?>
            <?php if($_SESSION['mensaje'] == 'success'): ?>
                <div class="alert alert-success mb-8">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Operación realizada exitosamente</span>
                </div>
            <?php else: ?>
                <div class="alert alert-error mb-8">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>Error al realizar la operación</span>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <!-- Contenido de los Tabs -->
        
        <!-- Tab: Vehículos -->
        <div id="vehiculos" class="tab-content active">
            <div class="glass-effect rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis Vehículos</h2>
                <?php if($vehiculos && $vehiculos->num_rows > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while($vehiculo = $vehiculos->fetch_assoc()): ?>
                            <div class="card bg-base-100 shadow-xl card-hover">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <i class="fas fa-car text-2xl text-indigo-600 mr-2"></i>
                                        <?php echo $vehiculo['placa']; ?>
                                    </h3>
                                    <div class="space-y-2">
                                        <p class="text-gray-600">
                                            <i class="fas fa-tag mr-2"></i>
                                            <?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                                        </p>
                                        <p class="text-gray-600">
                                            <i class="fas fa-palette mr-2"></i>
                                            <?php echo $vehiculo['color']; ?>
                                        </p>
                                        <p class="text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <?php 
                                            if($vehiculo['espacio_numero']) {
                                                echo "Nivel " . $vehiculo['espacio_nivel'] . " - Espacio " . $vehiculo['espacio_numero'];
                                            } else {
                                                echo "No asignado";
                                            }
                                            ?>
                                        </p>
                                        <div class="mt-4">
                                            <span class="status-badge 
                                                <?php 
                                                echo $vehiculo['estado_nombre'] == 'Activo' ? 'bg-green-100 text-green-800' : 
                                                    ($vehiculo['estado_nombre'] == 'En mantenimiento' ? 'bg-yellow-100 text-yellow-800' : 
                                                    'bg-red-100 text-red-800');
                                                ?>">
                                                <i class="fas fa-circle mr-2"></i>
                                                <?php echo $vehiculo['estado_nombre']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-car text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No tienes vehículos registrados</p>
                        <button class="btn btn-primary mt-4">
                            <i class="fas fa-plus mr-2"></i>
                            Registrar Vehículo
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab: Espacios Disponibles -->
        <div id="espacios" class="tab-content">
            <div class="glass-effect rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Espacios Disponibles</h2>
                
                <!-- Leyenda -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-gray-700">Disponible</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-gray-700">Ocupado</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-gray-700">Reservado</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gray-500 rounded-full mr-2"></div>
                        <span class="text-gray-700">En mantenimiento</span>
                    </div>
                </div>

                <!-- Espacios por Nivel -->
                <?php foreach($espacios_por_nivel as $nivel => $espacios_nivel): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Nivel <?php echo $nivel; ?></h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                            <?php foreach($espacios_nivel as $espacio): ?>
                                <div class="card bg-base-100 shadow-xl card-hover">
                                    <div class="card-body p-4">
                                        <h3 class="card-title text-lg">
                                            <i class="fas fa-parking text-indigo-600 mr-2"></i>
                                            Espacio <?php echo $espacio['numero']; ?>
                                        </h3>
                                        <div class="mt-2">
                                            <span class="badge 
                                                <?php 
                                                if($espacio['ocupado'] > 0) {
                                                    echo 'badge-error';
                                                } elseif($espacio['estado_nombre'] == 'Reservado') {
                                                    echo 'badge-warning';
                                                } elseif($espacio['estado_nombre'] == 'En mantenimiento') {
                                                    echo 'badge-ghost';
                                                } else {
                                                    echo 'badge-success';
                                                }
                                                ?>">
                                                <?php 
                                                if($espacio['ocupado'] > 0) {
                                                    echo 'Ocupado';
                                                } else {
                                                    echo $espacio['estado_nombre'];
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <?php if($espacio['ocupado'] == 0 && $espacio['estado_nombre'] == 'Disponible'): ?>
                                            <div class="card-actions justify-end mt-4">
                                                <button class="btn btn-primary btn-sm" onclick="showTab('visitas')">
                                                    <i class="fas fa-calendar-plus mr-2"></i>
                                                    Reservar
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab: Agendar Visita -->
        <div id="visitas" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Formulario de Agendamiento -->
                <div class="glass-effect rounded-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nueva Visita</h2>
                    <form action="usuario.php#visitas" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="agendar_visita">
                        
                        <!-- Nombre del Visitante -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nombre del Visitante</span>
                            </label>
                            <input type="text" name="nombre_visitante" class="input input-bordered" required>
                        </div>

                        <!-- Documento del Visitante -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Documento del Visitante</span>
                            </label>
                            <input type="text" name="documento_visitante" class="input input-bordered" required>
                        </div>

                        <!-- Placa del Vehículo -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Placa del Vehículo</span>
                            </label>
                            <input type="text" name="placa_vehiculo" class="input input-bordered" required>
                        </div>

                        <!-- Fecha de Visita -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Fecha de Visita</span>
                            </label>
                            <input type="date" name="fecha_visita" class="input input-bordered" required>
                        </div>

                        <!-- Hora de Inicio -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Hora de Inicio</span>
                            </label>
                            <input type="time" name="hora_inicio" class="input input-bordered" required>
                        </div>

                        <!-- Hora de Fin -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Hora de Fin</span>
                            </label>
                            <input type="time" name="hora_fin" class="input input-bordered" required>
                        </div>

                        <!-- Motivo -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Motivo de la Visita</span>
                            </label>
                            <textarea name="motivo" class="textarea textarea-bordered" rows="3" required></textarea>
                        </div>

                        <!-- Botón Submit -->
                        <button type="submit" class="btn btn-primary w-full">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Programar Visita
                        </button>
                    </form>
                </div>

                <!-- Lista de Visitas Programadas -->
                <div class="glass-effect rounded-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Visitas Programadas</h2>
                    <?php if($visitas && $visitas->num_rows > 0): ?>
                        <div class="space-y-4">
                            <?php while($visita = $visitas->fetch_assoc()): ?>
                                <div class="card bg-base-100 shadow-xl">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            <i class="fas fa-user text-indigo-600 mr-2"></i>
                                            <?php echo $visita['nombre_visitante']; ?>
                                        </h3>
                                        <div class="space-y-2">
                                            <p class="text-gray-600">
                                                <i class="fas fa-id-card mr-2"></i>
                                                <?php echo $visita['documento_visitante']; ?>
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-car mr-2"></i>
                                                <?php echo $visita['placa_vehiculo']; ?>
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-calendar mr-2"></i>
                                                <?php echo date('d/m/Y', strtotime($visita['fecha_visita'])); ?>
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-clock mr-2"></i>
                                                <?php echo $visita['hora_inicio'] . ' - ' . $visita['hora_fin']; ?>
                                            </p>
                                            <div class="mt-2">
                                                <span class="status-badge 
                                                    <?php 
                                                    echo $visita['estado'] == 'Aprobado' ? 'bg-green-100 text-green-800' : 
                                                        ($visita['estado'] == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800');
                                                    ?>">
                                                    <i class="fas fa-circle mr-2"></i>
                                                    <?php echo $visita['estado']; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <?php if($visita['estado'] == 'Pendiente'): ?>
                                            <div class="card-actions justify-end mt-4">
                                                <button class="btn btn-error btn-sm" 
                                                        onclick="if(confirm('¿Estás seguro de cancelar esta visita?')) window.location.href='cancelar_visita.php?id=<?php echo $visita['id_visita']; ?>'">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">No tienes visitas programadas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab: Reportar Daño -->
        <div id="danos" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Formulario de Daño -->
                <div class="glass-effect rounded-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Reportar Daño</h2>
                    <form action="usuario.php#danos" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="reportar_dano">
                        
                        <!-- Tipo de Daño -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Tipo de Daño</span>
                            </label>
                            <select name="tipo_dano" class="select select-bordered" required>
                                <option value="">Selecciona un tipo</option>
                                <option value="Rayón">Rayón</option>
                                <option value="Abolladura">Abolladura</option>
                                <option value="Choque">Choque</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <!-- Vehículo Afectado -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Vehículo Afectado</span>
                            </label>
                            <select name="id_vehiculo" class="select select-bordered" required>
                                <option value="">Selecciona un vehículo</option>
                                <?php 
                                $vehiculos->data_seek(0);
                                while($vehiculo = $vehiculos->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $vehiculo['id_vehiculo']; ?>">
                                        <?php echo $vehiculo['placa'] . ' - ' . $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Descripción del Daño</span>
                            </label>
                            <textarea name="descripcion" class="textarea textarea-bordered" rows="4" required></textarea>
                        </div>

                        <!-- Botón Submit -->
                        <button type="submit" class="btn btn-primary w-full">
                            <i class="fas fa-file-alt mr-2"></i>
                            Enviar Reporte
                        </button>
                    </form>
                </div>

                <!-- Historial de Daños -->
                <div class="glass-effect rounded-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Historial de Daños</h2>
                    <?php if($danos && $danos->num_rows > 0): ?>
                        <div class="space-y-4">
                            <?php while($dano = $danos->fetch_assoc()): ?>
                                <div class="card bg-base-100 shadow-xl">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                            <?php echo $dano['tipo_dano']; ?>
                                        </h3>
                                        <div class="space-y-2">
                                            <p class="text-gray-600">
                                                <i class="fas fa-car mr-2"></i>
                                                <?php echo $dano['placa']; ?>
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-calendar mr-2"></i>
                                                <?php echo date('d/m/Y', strtotime($dano['fecha_reporte'])); ?>
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                <?php echo $dano['descripcion']; ?>
                                            </p>
                                            <div class="mt-2">
                                                <span class="status-badge 
                                                    <?php 
                                                    echo $dano['estado'] == 'Resuelto' ? 'bg-green-100 text-green-800' : 
                                                        ($dano['estado'] == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800');
                                                    ?>">
                                                    <i class="fas fa-circle mr-2"></i>
                                                    <?php echo $dano['estado']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-circle text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">No tienes reportes de daños</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab: Notificaciones -->
        <div id="notificaciones" class="tab-content">
            <div class="glass-effect rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Notificaciones</h2>
                <?php if($notificaciones && $notificaciones->num_rows > 0): ?>
                    <div class="space-y-4">
                        <?php while($notif = $notificaciones->fetch_assoc()): ?>
                            <div class="card bg-base-100 shadow-xl">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <i class="fas fa-bell text-indigo-600 mr-2"></i>
                                        <?php echo $notif['titulo']; ?>
                                    </h3>
                                    <div class="space-y-2">
                                        <p class="text-gray-600">
                                            <?php echo $notif['mensaje']; ?>
                                        </p>
                                        <p class="text-gray-500 text-sm">
                                            <i class="fas fa-clock mr-2"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($notif['fecha'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No tienes notificaciones</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script>
        // Función para mostrar/ocultar tabs
        function showTab(tabId) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Mostrar el tab seleccionado
            document.getElementById(tabId).classList.add('active');
            
            // Actualizar botones de tab
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            // Activar el botón correspondiente
            document.querySelector(`.tab-button[onclick="showTab('${tabId}')"]`).classList.add('active');
            
            // Scroll al inicio del contenido
            window.scrollTo({
                top: document.querySelector('.container').offsetTop - 100,
                behavior: 'smooth'
            });
        }

        // Verificar si hay un hash en la URL para mostrar el tab correspondiente
        window.addEventListener('load', function() {
            const hash = window.location.hash.substring(1);
            if (hash) {
                showTab(hash);
            }
        });
    </script>
</body>
</html> 
<?php
include "models/conexion.php";
include "controller/usuario.php";
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario | Parkovisco</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 
                0 8px 32px 0 rgba(31, 38, 135, 0.37),
                inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.4);
        }
        
        .floating-input {
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .floating-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .gradient-background {
            background: linear-gradient(-45deg, 
                rgba(147, 51, 234, 0.7),  /* Púrpura */
                rgba(79, 70, 229, 0.7),   /* Índigo */
                rgba(59, 130, 246, 0.7),  /* Azul */
                rgba(236, 72, 153, 0.7)   /* Rosa */
            );
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .input-group {
            position: relative;
            transition: all 0.3s ease;
        }

        .input-group:hover .input-icon {
            transform: translateY(-50%) scale(1.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-50%) scale(0.8); }
            to { opacity: 1; transform: translateY(-50%) scale(1); }
        }

        .input-with-icon {
            padding-left: 2.5rem !important;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-with-icon:focus {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.1),
                inset 0 0 0 2px rgba(79, 70, 229, 0.4);
        }

        .input-with-icon:focus + .input-icon {
            color: #4f46e5;
            transform: translateY(-50%) scale(1.1);
        }

        .form-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .password-criteria li {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ef4444;
            opacity: 0.7;
        }

        .password-criteria li.valid {
            color: #22c55e;
            opacity: 1;
        }

        .btn-custom {
            position: relative;
            overflow: hidden;
        }

        .btn-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-custom:hover::after {
            width: 300px;
            height: 300px;
        }

        .animation-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        @media (max-width: 1024px) {
            .animation-container {
                display: none;
            }
        }

        /* Animación suave para la imagen */
        .animation-wrapper {
            position: relative;
            animation: float 6s ease-in-out infinite;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        #lottieAnimation {
            width: 100% !important;
            height: auto !important;
            min-height: 350px;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="min-h-screen gradient-background flex items-center justify-center py-16 px-4">
        <div class="container mx-auto px-4 my-20 flex gap-12 items-center">
            <!-- Contenedor de animación -->
            <div class="hidden lg:flex w-1/2 animation-container" data-aos="fade-right">
                <div class="animation-wrapper">
                    <div id="lottieAnimation"></div>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="w-full lg:w-1/2 relative z-10" data-aos="fade-left">
                <div class="max-w-5xl mx-auto glass-effect rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="p-8 text-white bg-gradient-to-r from-indigo-600 to-purple-600">
                        <div class="flex items-center space-x-4">
                            <div class="p-4 bg-white/20 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-user-plus text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold mb-1">Registrar Usuario</h1>
                                <p class="text-white/80">Complete el formulario para crear una nueva cuenta</p>
                            </div>
                        </div>
                    </div>

                    <form action="" method="POST" class="p-8">
                        <?php   
                            include "models/conexion.php";
                            include "controller/usuario.php";
                        ?>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Columna Izquierda -->
                            <div class="space-y-6">
                                <!-- Cédula -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Cédula:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="id" id="id" 
                                               class="input input-bordered w-full floating-input input-with-icon" 
                                               placeholder="Ingrese su cédula" required>
                                        <i class="fas fa-id-card input-icon"></i>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Nombre:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="nombre" id="nombre" 
                                               class="input input-bordered w-full floating-input input-with-icon" 
                                               placeholder="Ingrese su nombre" required>
                                        <i class="fas fa-user input-icon"></i>
                                    </div>
                                </div>

                                <!-- Apellido -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Apellido:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="apellido" id="apellido" 
                                               class="input input-bordered w-full floating-input input-with-icon" 
                                               placeholder="Ingrese su apellido" required>
                                        <i class="fas fa-user input-icon"></i>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Email:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="email" id="email" 
                                               class="input input-bordered w-full floating-input input-with-icon" 
                                               placeholder="Ingrese su correo" required>
                                        <i class="fas fa-envelope input-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="space-y-6">
                                <!-- Celular -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Celular:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="celular" id="celular" 
                                               class="input input-bordered w-full floating-input input-with-icon" 
                                               placeholder="Ingrese su celular" required>
                                        <i class="fas fa-mobile-alt input-icon"></i>
                                    </div>
                                </div>

                                <!-- Contraseña -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Contraseña:</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="con" id="con" 
                                               class="input input-bordered w-full floating-input input-with-icon pr-10" 
                                               placeholder="Ingrese su contraseña" required>
                                        <i class="fas fa-lock input-icon"></i>
                                        <button type="button" id="togglePassword" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Rol -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Rol:</span>
                                    </label>
                                    <div class="relative">
                                        <select name="rol" class="select select-bordered w-full floating-input input-with-icon" required>
                                            <option value="">Seleccione un rol</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Vigilante</option>
                                            <option value="3">Propietario</option>
                                        </select>
                                        <i class="fas fa-user-tag input-icon"></i>
                                    </div>
                                </div>

                                <!-- Requisitos de contraseña -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-gray-700 mb-2">La contraseña debe contener:</p>
                                    <ul class="password-criteria space-y-1 text-sm">
                                        <li><i class="fas fa-circle"></i>Mínimo 8 caracteres</li>
                                        <li><i class="fas fa-circle"></i>Al menos una letra mayúscula</li>
                                        <li><i class="fas fa-circle"></i>Al menos una letra minúscula</li>
                                        <li><i class="fas fa-circle"></i>Al menos un número</li>
                                        <li><i class="fas fa-circle"></i>Al menos un carácter especial (!@#$%^&*)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-3">
                                <input type="checkbox" 
                                       class="checkbox checkbox-primary mr-3" 
                                       id="terms" 
                                       name="terms" 
                                       required>
                                <label for="terms" class="text-sm text-gray-700">
                                    Acepto los <button type="button" 
                                            class="text-indigo-600 hover:text-indigo-800 font-medium underline"
                                            onclick="document.getElementById('termsModal').showModal()">
                                        términos y condiciones
                                    </button> de uso del servicio
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">
                                Al registrarte, aceptas nuestras políticas de privacidad y el uso de tus datos personales.
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-6 pt-8 mt-8 border-t border-gray-200">
                            <button type="submit" name="registrar" value="ok" 
                                    class="btn btn-primary btn-custom flex-1 hover:scale-105 transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 border-0">
                                <i class="fas fa-user-plus mr-2"></i>
                                Registrar
                            </button>
                            <a href="tablausu.php" 
                               class="btn btn-ghost btn-custom flex-1 hover:scale-105 transition-all duration-300 border-2 border-gray-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Mejorar la validación de contraseña con animaciones
        const password = document.querySelector('#con');
        const strengthBar = document.createElement('div');
        strengthBar.className = 'h-1 mt-2 rounded-full bg-gray-200 overflow-hidden';
        strengthBar.innerHTML = '<div class="h-full transition-all duration-300" id="strengthIndicator"></div>';
        password.parentElement.appendChild(strengthBar);

        password.addEventListener('input', function(e) {
            const value = e.target.value;
            const strength = calculatePasswordStrength(value);
            updateStrengthIndicator(strength);
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            if(password.length >= 8) strength += 20;
            if(/[A-Z]/.test(password)) strength += 20;
            if(/[a-z]/.test(password)) strength += 20;
            if(/\d/.test(password)) strength += 20;
            if(/[!@#$%^&*]/.test(password)) strength += 20;
            return strength;
        }

        function updateStrengthIndicator(strength) {
            const indicator = document.querySelector('#strengthIndicator');
            let color = 'bg-red-500';
            if(strength > 60) color = 'bg-yellow-500';
            if(strength >= 100) color = 'bg-green-500';
            
            indicator.className = `h-full transition-all duration-300 ${color}`;
            indicator.style.width = `${strength}%`;
        }

        // Añadir efectos de ripple a los botones
        document.querySelectorAll('.btn-custom').forEach(button => {
            button.addEventListener('mouseenter', function(e) {
                const ripple = document.createElement('div');
                ripple.className = 'ripple-effect';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });

        // Configuración de la animación Lottie
        const animation = lottie.loadAnimation({
            container: document.getElementById('lottieAnimation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets10.lottiefiles.com/packages/lf20_z4cshyhf.json' // Animación más moderna
        });

        // Agregar interactividad a la animación
        document.getElementById('lottieAnimation').addEventListener('mouseenter', () => {
            animation.setSpeed(1.5); // Acelerar la animación al pasar el mouse
        });

        document.getElementById('lottieAnimation').addEventListener('mouseleave', () => {
            animation.setSpeed(1); // Restaurar velocidad normal
        });

        // Validación del formulario para términos y condiciones
        document.querySelector('form').addEventListener('submit', function(e) {
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Debes aceptar los términos y condiciones para continuar.');
            }
        });
    </script>

    <!-- Modal de Términos y Condiciones -->
    <dialog id="termsModal" class="modal">
        <div class="modal-box w-11/12 max-w-2xl">
            <h3 class="font-bold text-lg mb-4">Términos y Condiciones</h3>
            <div class="prose max-w-none">
                <h4>1. Aceptación de los términos</h4>
                <p>Al acceder y utilizar este sistema, usted acepta estos términos y condiciones en su totalidad.</p>
                
                <h4>2. Uso del servicio</h4>
                <p>El usuario se compromete a utilizar el servicio de manera responsable y de acuerdo con las leyes aplicables.</p>
                
                <h4>3. Privacidad y datos personales</h4>
                <p>Nos comprometemos a proteger su información personal de acuerdo con nuestra política de privacidad.</p>
                
                <h4>4. Responsabilidades del usuario</h4>
                <p>El usuario es responsable de mantener la confidencialidad de su cuenta y contraseña.</p>
                
                <h4>5. Modificaciones del servicio</h4>
                <p>Nos reservamos el derecho de modificar o discontinuar el servicio en cualquier momento.</p>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary">Aceptar</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>cerrar</button>
        </form>
    </dialog>
</body>
</html>
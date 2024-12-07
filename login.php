<?php
session_start();
// Si ya hay una sesión activa, redirigir según el rol
if(isset($_SESSION['nombre_rol'])) {
    switch($_SESSION['nombre_rol']) {
        case 'administrador':
            header('Location: Administrador1.php');
            break;
        case 'vigilante':
            header('Location: vigilante.php');
            break;
        case 'usuario':
            header('Location: usuario.php');
            break;
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Parkovisco</title>
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

        .login-animation {
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
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

        .btn-custom {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Estilos para botones sociales */
        .social-login-btn {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background-color: white;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
        }

        .social-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .social-login-btn img {
            width: 24px;
            height: 24px;
        }

        /* Animación para los botones sociales */
        .social-buttons {
            animation: fadeInUp 0.6s ease-out forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animation-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

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

        @media (max-width: 1024px) {
            .animation-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
    <div class="min-h-screen gradient-background flex items-center justify-center p-4 pt-16">
        <div class="container mx-auto px-4 my-20 flex gap-12 items-center">
            <!-- Contenedor de animación -->
            <div class="hidden lg:flex w-1/2 animation-container" data-aos="fade-right">
                <div class="animation-wrapper">
                    <div id="lottieAnimation"></div>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="w-full lg:w-1/2 relative z-10" data-aos="fade-left">
                <div class="glass-effect rounded-2xl p-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="bg-white/30 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-parking text-4xl text-indigo-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Bienvenido a Parkovisco</h1>
                        <p class="text-gray-600">Ingresa tus credenciales para continuar</p>
                    </div>

                    <!-- Formulario -->
                    <form action="controller/login_controller.php" method="POST" class="space-y-6">
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                                <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Cédula -->
                        <div class="input-group">
                            <input type="text" name="cedula" 
                                   class="input input-bordered w-full input-with-icon" 
                                   placeholder="Ingrese su cédula" required>
                            <i class="fas fa-id-card input-icon"></i>
                        </div>

                        <!-- Contraseña -->
                        <div class="input-group">
                            <input type="password" name="contrasena" id="password"
                                   class="input input-bordered w-full input-with-icon" 
                                   placeholder="Ingrese su contraseña" required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                    onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>

                        <!-- Botón de ingreso -->
                        <button type="submit" name="login" 
                                class="btn btn-primary w-full btn-custom bg-gradient-to-r from-indigo-600 to-purple-600 border-0">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Ingresar
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>o continuar con</span>
                        </div>

                        <!-- Botones de inicio de sesión social -->
                        <div class="social-buttons space-y-3">
                            <!-- Google -->
                            <button type="button" class="social-login-btn hover:bg-gray-50">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" 
                                     alt="Google"
                                     class="w-5 h-5">
                                <span>Continuar con Google</span>
                            </button>

                            <!-- Apple -->
                            <button type="button" class="social-login-btn hover:bg-gray-50">
                                <i class="fab fa-apple text-xl"></i>
                                <span>Continuar con Apple</span>
                            </button>
                        </div>

                        <div class="divider">
                            <span>o</span>
                        </div>

                        <!-- Restablecer contraseña -->
                        <button type="button" 
                                onclick="document.getElementById('resetModal').showModal()"
                                class="btn btn-ghost w-full btn-custom border-2 border-gray-200">
                            <i class="fas fa-key mr-2"></i>
                            Olvidé mi contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Restablecer Contraseña -->
    <dialog id="resetModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Restablecer Contraseña</h3>
            <form action="controller/reset_password.php" method="POST">
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Cédula</span>
                        </label>
                        <input type="text" name="cedula" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Correo electrónico</span>
                        </label>
                        <input type="email" name="email" class="input input-bordered" required>
                    </div>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Enviar enlace</button>
                    <button type="button" class="btn btn-ghost" onclick="document.getElementById('resetModal').close()">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>cerrar</button>
        </form>
    </dialog>

    <?php include 'components/footer.php'; ?>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Animaciones para los inputs
        document.querySelectorAll('.input-with-icon').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Animación para botones sociales
        document.querySelectorAll('.social-login-btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });

            // Efecto de click
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-2px)';
                }, 100);
            });
        });

        // Inicializar AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Configuración de la animación Lottie
        const animation = lottie.loadAnimation({
            container: document.getElementById('lottieAnimation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: ' https://assets3.lottiefiles.com/packages/lf20_UJNc2t.json' // Animación de login
        });
    </script>
</body>
</html> 
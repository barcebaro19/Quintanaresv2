<?php
// Aquí podrías incluir la lógica para manejar el envío del formulario de contacto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Aquí podrías agregar la lógica para enviar el mensaje, guardar en base de datos, etc.
    // Por simplicidad, solo se muestra un mensaje de éxito.
    $mensaje_exito = "Gracias, $nombre. Tu mensaje ha sido enviado.";
}

// Simulación de carga de noticias
$noticias = [
    [
        'titulo' => 'Noticias Recientes 1',
        'contenido' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!'
    ],
    [
        'titulo' => 'Noticias Recientes 2',
        'contenido' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!'
    ],
    [
        'titulo' => 'Noticias Recientes 3',
        'contenido' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!'
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quintanares</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Montserrat', 'sans-serif'],
            },
            colors: {
              primary: '#2563eb',
              secondary: '#fbbf24',
              accent: '#10b981',
            },
          },
        },
      }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6">
            <div class="flex items-center gap-2">
                <img src="img/logofinal.png" alt="Quintanares Logo" class="h-10 w-10 object-contain">
                <span class="font-bold text-xl text-primary">Quintanares</span>
            </div>
            <ul class="hidden md:flex gap-6 font-semibold">
                <li><a href="#" class="hover:text-primary transition">Inicio</a></li>
                <li><a href="#noticias" class="hover:text-primary transition">Noticias</a></li>
                <li class="relative group">
                    <a href="#servicios" class="hover:text-primary transition flex items-center gap-1">Servicios <i class="fa fa-chevron-down text-xs"></i></a>
                    <ul class="absolute left-0 mt-2 w-40 bg-white shadow-lg rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity duration-200">
                        <li><a href="#servicio1" class="block px-4 py-2 hover:bg-gray-100">Servicio 1</a></li>
                        <li><a href="#servicio2" class="block px-4 py-2 hover:bg-gray-100">Servicio 2</a></li>
                        <li><a href="#servicio3" class="block px-4 py-2 hover:bg-gray-100">Servicio 3</a></li>
                    </ul>
                </li>
                <li><a href="#caracteristicas" class="hover:text-primary transition">Características</a></li>
                <li><a href="#eventos" class="hover:text-primary transition">Eventos</a></li>
                <li><a href="#galeria" class="hover:text-primary transition">Galería</a></li>
                <li><a href="#blog" class="hover:text-primary transition">Blog</a></li>
                <li><a href="#contacto" class="hover:text-primary transition">Contacto</a></li>
                <li><a href="login.php" class="ml-2 px-4 py-2 bg-primary text-white rounded-lg shadow hover:bg-blue-700 transition">Iniciar Sesión</a></li>
            </ul>
            <button class="md:hidden text-2xl" id="mobile-menu-btn"><i class="fa fa-bars"></i></button>
        </nav>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <ul class="flex flex-col gap-4 px-6 pb-4">
                <li><a href="#" class="hover:text-primary transition">Inicio</a></li>
                <li><a href="#noticias" class="hover:text-primary transition">Noticias</a></li>
                <li><a href="#servicios" class="hover:text-primary transition">Servicios</a></li>
                <li><a href="#caracteristicas" class="hover:text-primary transition">Características</a></li>
                <li><a href="#eventos" class="hover:text-primary transition">Eventos</a></li>
                <li><a href="#galeria" class="hover:text-primary transition">Galería</a></li>
                <li><a href="#blog" class="hover:text-primary transition">Blog</a></li>
                <li><a href="#contacto" class="hover:text-primary transition">Contacto</a></li>
                <li><a href="login.php" class="px-4 py-2 bg-primary text-white rounded-lg shadow hover:bg-blue-700 transition">Iniciar Sesión</a></li>
            </ul>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative h-[60vh] flex items-center justify-center bg-gradient-to-br from-primary to-accent overflow-hidden">
        <img src="img/cuarto.jpg" alt="Hero" class="absolute inset-0 w-full h-full object-cover opacity-30">
        <div class="relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Quintanares</h1>
            <p class="text-lg md:text-2xl mb-6 drop-shadow">Tu hogar ideal en la ciudad.</p>
            <div class="flex justify-center">
                <input type="text" placeholder="Busca tu tema de interés" class="rounded-l-lg px-4 py-2 w-56 md:w-80 focus:outline-none text-gray-800">
                <button class="rounded-r-lg px-4 py-2 bg-secondary text-white font-semibold hover:bg-yellow-500 transition">Buscar</button>
            </div>
        </div>
        <div class="absolute inset-0 bg-black opacity-30"></div>
    </section>

    <!-- Noticias -->
    <section id="noticias" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10 text-primary">Noticias</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($noticias as $noticia): ?>
                <div class="bg-gray-100 rounded-xl shadow-lg p-6 flex flex-col hover:scale-105 hover:shadow-2xl transition-transform">
                    <h3 class="text-xl font-semibold mb-2 text-primary"><?= $noticia['titulo'] ?></h3>
                    <p class="mb-4 text-gray-700"><?= $noticia['contenido'] ?></p>
                    <a href="#" class="mt-auto inline-block px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition">Leer más</a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-center mt-8">
                <button class="px-6 py-2 bg-accent text-white rounded-lg font-semibold shadow hover:bg-emerald-600 transition">Cargar más noticias</button>
            </div>
        </div>
    </section>

    <!-- Características -->
    <section id="caracteristicas" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10 text-primary">Nuestras Características</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <i class="fas fa-home text-4xl text-primary mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">200 Apartamentos</h3>
                    <p class="text-gray-600 text-center">Espacios modernos y confortables para vivir.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <i class="fas fa-parking text-4xl text-primary mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">150 Parqueaderos Privados</h3>
                    <p class="text-gray-600 text-center">Seguridad y comodidad para tu vehículo.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <i class="fas fa-store text-4xl text-primary mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">15 Negocios Comerciales</h3>
                    <p class="text-gray-600 text-center">Variedad de servicios a tu alcance.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <i class="fas fa-car text-4xl text-primary mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">56 Parqueaderos para Visitantes</h3>
                    <p class="text-gray-600 text-center">Espacio suficiente para tus invitados.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10 text-primary">Nuestros Servicios</h2>
            <div class="flex flex-col md:flex-row gap-8 justify-center">
                <div class="bg-gray-100 rounded-xl shadow-lg p-6 flex-1 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform">
                    <i class="fas fa-users text-4xl text-accent mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Salón comunal</h3>
                    <p class="text-gray-600 text-center mb-4">Horarios, normas de uso, capacidad, disponibilidad y proceso de reserva.</p>
                    <button class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-emerald-600 transition">Detalles</button>
                </div>
                <div class="bg-gray-100 rounded-xl shadow-lg p-6 flex-1 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform">
                    <i class="fas fa-parking text-4xl text-accent mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Parqueadero</h3>
                    <p class="text-gray-600 text-center mb-4">Información detallada del parqueadero: horarios, tarifas, normas, pagos y servicios.</p>
                    <button class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-emerald-600 transition">Detalles</button>
                </div>
                <div class="bg-gray-100 rounded-xl shadow-lg p-6 flex-1 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform">
                    <i class="fas fa-dumbbell text-4xl text-accent mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Zona de juegos</h3>
                    <p class="text-gray-600 text-center mb-4">Zona de juegos (actividades), horarios, no permitidos, normas de uso.</p>
                    <button class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-emerald-600 transition">Detalles</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10 text-primary">Contacto</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold mb-2 text-primary">Información de Contacto</h3>
                        <p class="mb-2"><i class="fas fa-phone mr-2 text-primary"></i> Teléfono: (57) 300 000 0000</p>
                        <p class="mb-2"><i class="fas fa-envelope mr-2 text-primary"></i> Email: info@quintares.com</p>
                        <p><i class="fas fa-map-marker-alt mr-2 text-primary"></i> Dirección: Calle 123 # 456, Bogotá, Colombia</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold mb-2 text-primary">Horario de Atención</h3>
                        <p class="mb-2"><i class="far fa-clock mr-2 text-primary"></i> Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                        <p><i class="far fa-clock mr-2 text-primary"></i> Sábados: 10:00 AM - 2:00 PM</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-lg font-semibold mb-4 text-primary">Envíanos un mensaje</h3>
                    <?php if (isset($mensaje_exito)): ?>
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                            <?= $mensaje_exito ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" class="space-y-4">
                        <input type="text" name="nombre" placeholder="Nombre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                        <input type="number" name="telefono" placeholder="Número de teléfono" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                        <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                        <textarea name="mensaje" placeholder="Mensaje" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"></textarea>
                        <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-blue-700 transition">Enviar</button>
                    </form>
                </div>
            </div>
            <div class="mt-12">
                <h3 class="text-lg font-semibold mb-4 text-primary">Ubicación</h3>
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8101563797185!2d-74.07609548523793!3d4.639976443504325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a2f3f8a8c6f%3A0x8f0b4f4f4f4f4f4f!2sBogot%C3%A1%2C%20Colombia!5e0!3m2!1ses!2sco!4v1620000000000!5m2!1ses!2sco" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10 text-primary">Preguntas Frecuentes</h2>
            <div class="max-w-2xl mx-auto space-y-4">
                <div class="border rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 text-left font-semibold text-primary focus:outline-none faq-toggle">
                        ¿Cuáles son los requisitos para alquilar un apartamento?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white text-gray-700">
                        Los requisitos típicos incluyen: comprobante de ingresos, referencias laborales, historial crediticio favorable y un depósito de seguridad. Cada solicitud se evalúa individualmente.
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 text-left font-semibold text-primary focus:outline-none faq-toggle">
                        ¿Se permiten mascotas en los apartamentos?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white text-gray-700">
                        Sí, se permiten mascotas en Quintanares. Hay ciertas restricciones de tamaño y raza, y se requiere un depósito adicional por mascota. Por favor, consulta nuestra política de mascotas para más detalles.
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 text-left font-semibold text-primary focus:outline-none faq-toggle">
                        ¿Cuáles son los horarios del gimnasio y la piscina?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white text-gray-700">
                        El gimnasio está abierto las 24 horas para los residentes. La piscina está disponible de 6:00 AM a 10:00 PM todos los días, con un salvavidas presente durante las horas pico.
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden">
                    <button class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 text-left font-semibold text-primary focus:outline-none faq-toggle">
                        ¿Cómo funciona el sistema de seguridad del edificio?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white text-gray-700">
                        Quintanares cuenta con un sistema de seguridad 24/7, que incluye cámaras de vigilancia, personal de seguridad en sitio y un sistema de acceso controlado para residentes y visitantes.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-10 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between gap-8 mb-6">
                <div>
                    <h3 class="font-bold text-2xl mb-2">Quintanares</h3>
                    <p class="mb-4">Tu hogar ideal en la ciudad.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-secondary"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="#" class="hover:text-secondary"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="hover:text-secondary"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="hover:text-secondary"><i class="fab fa-linkedin-in text-xl"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-2">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-secondary">Inicio</a></li>
                        <li><a href="#noticias" class="hover:text-secondary">Noticias</a></li>
                        <li><a href="#servicios" class="hover:text-secondary">Servicios</a></li>
                        <li><a href="#contacto" class="hover:text-secondary">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-2">Contacto</h3>
                    <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> Calle 123 # 456, Bogotá, Colombia</p>
                    <p class="mb-2"><i class="fas fa-phone mr-2"></i> (57) 300 000 0000</p>
                    <p><i class="fas fa-envelope mr-2"></i> info@quintares.com</p>
                </div>
            </div>
            <div class="text-center border-t border-white/20 pt-4">
                <p>&copy; 2024 Quintanares. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts para menú móvil y FAQ -->
    <script>
      // Menú móvil
      const menuBtn = document.getElementById('mobile-menu-btn');
      const mobileMenu = document.getElementById('mobile-menu');
      menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
      // FAQ acordeón
      document.querySelectorAll('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
          const answer = btn.parentElement.querySelector('.faq-answer');
          const icon = btn.querySelector('.faq-icon');
          if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.textContent = '-';
          } else {
            answer.classList.add('hidden');
            icon.textContent = '+';
          }
        });
      });
    </script>
</body>
</html>
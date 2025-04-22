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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="img/logofinal.png" alt="Quintanares Logo">
            </div>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="noticias.html">Noticias</a></li>
                <li>
                    <a href="servicios.html">Servicios</a>
                    <ul class="dropdown">
                        <li><a href="servicio1.html">Servicio 1</a></li>
                        <li><a href="servicio2.html">Servicio 2</a></li>
                        <li><a href="servicio3.html">Servicio 3</a></li>
                    </ul>
                </li>
                <li><a href="error400.html">Características</a></li>
                <li><a href="eventos.html">Eventos</a></li>
                <li><a href="error500.html">Galería</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="login.php" class="nav-button">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero">
        <h1>Quintanares</h1>
        <p>Tu hogar ideal en la ciudad.</p>
        <div class="search-bar">
            <input type="text" placeholder="Busca tu tema de interés">
            <button>Buscar</button> 
        </div>
    </div>

    <section class="news">
        <div class="container">
            <h2>Noticias</h2>
            <div class="news-items">
                <div class="news-item">
                    <h3>Noticias Recientes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet! Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!</p>
                    <a href="#" class="btn">Leer más</a>
                </div>
                <div class="news-item">
                    <h3>Noticias Recientes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet! Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!</p>
                    <a href="#" class="btn">Leer más</a>
                </div>
                <div class="news-item">
                    <h3>Noticias Recientes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet! Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, amet!</p>
                    <a href="#" class="btn">Leer más</a>
                </div>
            </div>
            <button class="btn">Cargar más noticias</button>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Nuestras Características</h2>
            <div class="features-grid">
                <div class="features-item">
                    <i class="fas fa-home"></i>
                    <h3>200 Apartamentos</h3>
                    <p>Espacios modernos y confortables para vivir.</p>
                </div>
                <div class="features-item">
                    <i class="fas fa-parking"></i>
                    <h3>150 Parqueaderos Privados</h3>
                    <p>Seguridad y comodidad para tu vehículo.</p>
                </div>
                <div class="features-item">
                    <i class="fas fa-store"></i>
                    <h3>15 Negocios Comerciales</h3>
                    <p>Variedad de servicios a tu alcance.</p>
                </div>
                <div class="features-item">
                    <i class="fas fa-car"></i>
                    <h3>56 Parqueaderos para Visitantes</h3>
                    <p>Espacio suficiente para tus invitados.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <h2>NUESTROS SERVICIOS</h2>
            <div class="services-carousel">
                <button class="carousel-button prev">&lt;</button>
                <div class="services-wrapper">
                    <div class="services-items">
                        <div class="services-item">
                            <i class="fas fa-users"></i>
                            <h3>Salón comunal</h3>
                            <p>Horarios, normas de uso, capacidad, disponibilidad y proceso de reserva.</p>
                            <button class="details-button">Detalles</button>
                        </div>
                        <div class="services-item">
                            <i class="fas fa-parking"></i>
                            <h3>Parqueadero</h3>
                            <p>Información detallada del parqueadero: horarios, tarifas, normas, pagos y servicios.</p>
                            <button class="details-button">Detalles</button>
                        </div>
                        <div class="services-item">
                            <i class="fas fa-dumbbell"></i>
                            <h3>Zona de juegos</h3>
                            <p>Zona de juegos (actividades), horarios, no permitidos, normas de uso.</p>
                            <button class="details-button">Detalles</button>
                        </div>
                        <!-- Agrega más servicios aquí si es necesario -->
                    </div>
                </div>
                <button class="carousel-button next">&gt;</button>
            </div>
        </div>
    </section>

    <section class="contact">
        <div class="container">
            <h2>Contacto</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-card">
                        <h3>Información de Contacto</h3>
                        <p><i class="fas fa-phone"></i> Teléfono: (57) 300 000 0000</p>
                        <p><i class="fas fa-envelope"></i> Email: info@quintares.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> Dirección: Calle 123 # 456, Bogotá, Colombia</p>
                    </div>
                    <div class="contact-card">
                        <h3>Horario de Atención</h3>
                        <p><i class="far fa-clock"></i> Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                        <p><i class="far fa-clock"></i> Sábados: 10:00 AM - 2:00 PM</p>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Envíanos un mensaje</h3>
                    <form>
                        <input type="text" placeholder="Nombre" required>
                        <input type="number" placeholder="Numero de telefono" required>
                        <input type="email" placeholder="Email" required>
                        <textarea placeholder="Mensaje" required></textarea>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
            <div class="contact-map">
                <h3>Ubicación</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8101563797185!2d-74.07609548523793!3d4.639976443504325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a2f3f8a8c6f%3A0x8f0b4f4f4f4f4f4f!2sBogot%C3%A1%2C%20Colombia!5e0!3m2!1ses!2sco!4v1620000000000!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question">
                        ¿Cuáles son los requisitos para alquilar un apartamento?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p>Los requisitos típicos incluyen: comprobante de ingresos, referencias laborales, historial crediticio favorable y un depósito de seguridad. Cada solicitud se evalúa individualmente.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        ¿Se permiten mascotas en los apartamentos?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p>Sí, se permiten mascotas en Quintanares. Hay ciertas restricciones de tamaño y raza, y se requiere un depósito adicional por mascota. Por favor, consulta nuestra política de mascotas para más detalles.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        ¿Cuáles son los horarios del gimnasio y la piscina?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p>El gimnasio está abierto las 24 horas para los residentes. La piscina está disponible de 6:00 AM a 10:00 PM todos los días, con un salvavidas presente durante las horas pico.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        ¿Cómo funciona el sistema de seguridad del edificio?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p>Quintanares cuenta con un sistema de seguridad 24/7, que incluye cámaras de vigilancia, personal de seguridad en sitio y un sistema de acceso controlado para residentes y visitantes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Quintanares</h3>
                    <p>Tu hogar ideal en la ciudad.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i classfab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Noticias</a></li>
                        <li><a href="#">Servicios</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Calle 123 # 456, Bogotá, Colombia</p>
                    <p><i class="fas fa-phone"></i> (57) 300 000 0000</p>
                    <p><i class="fas fa-envelope"></i> info@quintares.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Quintanares. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
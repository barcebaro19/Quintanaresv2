<footer class="bg-gray-900 text-gray-300 py-10 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Columna 1: Información de Parkovisco -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">
                    <i class="fas fa-parking text-indigo-500 mr-2"></i>
                    Parkovisco
                </h3>
                <p class="text-gray-400 mb-4">Tu solución de estacionamiento inteligente</p>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-indigo-500 transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-indigo-500 transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-indigo-500 transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-indigo-500 transition-colors">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Columna 2: Enlaces Rápidos -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="inicio.php" class="hover:text-indigo-500 transition-colors">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>Inicio
                        </a>
                    </li>
                    <li>
                        <a href="nosotros.php" class="hover:text-indigo-500 transition-colors">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>Nosotros
                        </a>
                    </li>
                    <li>
                        <a href="contacto.php" class="hover:text-indigo-500 transition-colors">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>Contacto
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Columna 3: Contacto -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Contacto</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1.5 mr-3 text-indigo-500"></i>
                        <div>
                            <p class="font-medium">Email:</p>
                            <a href="mailto:info@parkovisco.com" class="text-gray-400 hover:text-indigo-500 transition-colors">
                                info@parkovisco.com
                            </a>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone-alt mt-1.5 mr-3 text-indigo-500"></i>
                        <div>
                            <p class="font-medium">Teléfono:</p>
                            <a href="tel:(123)456-7890" class="text-gray-400 hover:text-indigo-500 transition-colors">
                                (123) 456-7890
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-400">
                    © <?php echo date('Y'); ?> Parkovisco. Todos los derechos reservados.
                </p>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-sm text-gray-400 hover:text-indigo-500 transition-colors mr-4">
                        Política de Privacidad
                    </a>
                    <a href="#" class="text-sm text-gray-400 hover:text-indigo-500 transition-colors">
                        Términos de Servicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
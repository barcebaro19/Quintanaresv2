<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_ws'])) {
    $email = $_POST['email_ws'];
    // Usar una API pública para validar email (ejemplo: https://api.eva.pingutil.com/email?email=)
    $url = 'https://api.eva.pingutil.com/email?email=' . urlencode($email);
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    $valido = $data['data']['deliverable'] ? 'Válido' : 'No válido';
    echo "<h2>Resultado de validación para: $email</h2>";
    echo "<p><b>Estado:</b> $valido</p>";
    echo '<a href="tablausu.php">Volver</a>';
} else {
    header('Location: tablausu.php');
    exit();
} 
<?php
require_once __DIR__ . '/vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdf;

if (!isset($_GET['id'])) {
    die('ID no proporcionado');
}

$id = $_GET['id'];


$usuario = [
    'nombre' => 'Juan',
    'apellido' => 'Pérez',
    'email' => 'juan.perez@example.com',
    'celular' => '123456789',
    'rol' => 'Administrador',
    'fecha_registro' => '2024-03-15'
];

// Crear PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


$pdf->SetMargins(15, 15, 15);


$pdf->AddPage();


$html = <<<EOD
<style>
    .header {
        background-color: #f8f9fa;
        padding: 20px;
        border-bottom: 3px solid #0056b3;
    }
    .logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .company-name {
        color: #0056b3;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        font-family: 'Helvetica', sans-serif;
    }
    .document-title {
        background-color: #0056b3;
        color: white;
        padding: 10px;
        margin: 20px 0;
        font-size: 18px;
        text-align: center;
        border-radius: 5px;
    }
    .info-section {
        margin: 20px 0;
        border: 1px solid #dee2e6;
        padding: 15px;
        border-radius: 5px;
    }
    .info-row {
        margin-bottom: 10px;
        padding: 8px;
        border-bottom: 1px solid #eee;
    }
    .label {
        color: #0056b3;
        font-weight: bold;
        width: 150px;
        display: inline-block;
    }
    .value {
        color: #333;
    }
    .footer {
        margin-top: 30px;
        text-align: center;
        color: #666;
        font-size: 12px;
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
    }
</style>

<div class="header">
    <div class="logo">
        <!-- Reemplaza la ruta de la imagen con tu logo -->
        <img src="ruta/a/tu/logo.png" width="150">
    </div>
    <div class="company-name">NOMBRE DE TU EMPRESA</div>
</div>

<div class="document-title">
    INFORMACIÓN DEL USUARIO
</div>

<div class="info-section">
    <div class="info-row">
        <span class="label">Nombre Completo:</span>
        <span class="value">{$usuario['nombre']} {$usuario['apellido']}</span>
    </div>
    <div class="info-row">
        <span class="label">Correo Electrónico:</span>
        <span class="value">{$usuario['email']}</span>
    </div>
    <div class="info-row">
        <span class="label">Teléfono:</span>
        <span class="value">{$usuario['celular']}</span>
    </div>
    <div class="info-row">
        <span class="label">Rol:</span>
        <span class="value">{$usuario['rol']}</span>
    </div>
    <div class="info-row">
        <span class="label">Fecha de Registro:</span>
        <span class="value">{$usuario['fecha_registro']}</span>
    </div>
</div>

<div class="footer">
    <p>Para más información, contacte con soporte@tuempresa.com</p>
</div>
EOD;


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('reporte_usuario.pdf', 'I');
?>

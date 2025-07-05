<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'models/conexion.php';

use setasign\Fpdi\Tcpdf\Fpdf;

$conn = Conexion::getInstancia()->getConexion();

if (isset($_GET['id'])) {
    // PDF individual
    $id = $_GET['id'];
    $sql = "SELECT u.id, u.nombre, u.apellido, u.email, u.celular, r.nombre_rol 
            FROM usuarios u
            INNER JOIN usu_roles ur ON u.id = ur.usuarios_id
            INNER JOIN roles r ON ur.roles_idroles = r.idroles
            WHERE u.id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error en prepare: ' . $conn->error . '<br>SQL: ' . htmlspecialchars($sql));
    }
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 20, 20);
        $pdf->AddPage();
        $html = '<h2 style="text-align:center;">Reporte de Usuario</h2>';
        $html .= '<table cellpadding="6" style="width:100%; font-size:16px;">';
        foreach ($row as $key => $value) {
            $html .= '<tr><td style="font-weight:bold;">' . htmlspecialchars(ucfirst($key)) . ':</td><td>' . htmlspecialchars($value) . '</td></tr>';
        }
        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('reporte_usuario_' . $id . '.pdf', 'I');
    } else {
        die('Usuario no encontrado');
    }
} else {
    // PDF general
    $sql = "SELECT u.id, u.nombre, u.apellido, u.email, u.celular, r.nombre_rol 
            FROM usuarios u
            INNER JOIN usu_roles ur ON u.id = ur.usuarios_id
            INNER JOIN roles r ON ur.roles_idroles = r.idroles";
    $result = $conn->query($sql);
    if (!$result) {
        die('Error al obtener los usuarios');
    }
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();
    $html = '<h2 style="text-align:center;">Reporte de Usuarios</h2>';
    $html .= '<table border="1" cellpadding="4" style="width:100%; border-collapse:collapse;">';
    $html .= '<thead><tr style="background-color:#f2f2f2;"><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Celular</th><th>Rol</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nombre']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['apellido']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['celular']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nombre_rol']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('reporte_usuarios.pdf', 'I');
}
?>

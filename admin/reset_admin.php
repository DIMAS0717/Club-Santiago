<?php
// admin/reset_admin.php
require __DIR__ . '/../includes/db.php';

// USUARIO Y CONTRASEÑA QUE QUEREMOS FORZAR
$usernameSeed  = 'admin';
$passwordSeed  = 'admin123';
$hashSeed      = password_hash($passwordSeed, PASSWORD_DEFAULT);

// Crea / actualiza el usuario admin
$sql = "INSERT INTO admins (username, password_hash, nombre, correo)
        VALUES (?, ?, 'Administrador', 'admin@clubsantiago.com')
        ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die('Error al preparar la consulta: ' . $conn->error);
}
$stmt->bind_param('ss', $usernameSeed, $hashSeed);
$stmt->execute();
$stmt->close();

echo '✅ Admin reseteado.<br>';
echo 'Usuario: <strong>admin</strong><br>';
echo 'Contraseña: <strong>admin123</strong><br>';
echo '<a href=\"login.php\">Ir al login</a>';

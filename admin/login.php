<?php
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/auth.php';

$error = '';

// 1) Crear admin por defecto si la tabla está vacía
$res = $conn->query("SELECT COUNT(*) AS c FROM admins");
$row = $res ? $res->fetch_assoc() : null;
$existenAdmins = $row ? (int)$row['c'] > 0 : false;

if (!$existenAdmins) {
    $usernameSeed = 'admin';
    $passwordSeed = 'admin123';
    $hashSeed     = password_hash($passwordSeed, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO admins (username, password_hash, nombre, correo)
         VALUES (?, ?, 'Administrador', 'admin@clubsantiago.com')"
    );
    $stmt->bind_param('ss', $usernameSeed, $hashSeed);
    $stmt->execute();
    $stmt->close();
}

// 2) PROCESAR LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  $sql = "SELECT id, password_hash FROM admins WHERE username = ? LIMIT 1";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    $error = 'Error interno al preparar la consulta.';
  } else {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash);

    if ($stmt->fetch()) {
      if (password_verify($password, $hash)) {
        $_SESSION['admin_id'] = $id;
        header('Location: panel.php');
        exit;
      } else {
        $error = 'Usuario o contraseña incorrectos.';
      }
    } else {
      $error = 'Usuario o contraseña incorrectos.';
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login admin - Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="admin-body">
  <div class="admin-login-wrapper">
    <form class="admin-login-card" method="post">
      <h1>Administrador</h1>
      <p style="font-size:12px; color:#9ca3af; margin:0 0 6px;">
        Usuario por defecto: <strong>admin</strong> · Contraseña: <strong>admin123</strong>
      </p>
      <?php if ($error): ?>
        <p class="form-error"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <label>Usuario
        <input type="text" name="username" required>
      </label>

      <label>Contraseña
        <input type="password" name="password" required>
      </label>

      <button type="submit" class="btn-primary">Entrar</button>
      <a href="../index.php" class="btn-ghost small">Volver al sitio</a>
    </form>
  </div>
</body>
</html>

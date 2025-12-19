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
  <link rel="stylesheet" href="../assets/log.css">
</head>
<body class="admin-body">
  <img src="../assets/images/fondo_login.jpg" alt="Fondo" class="bg-image-tag">
  <a href="../index.php" class="boton-inicio">
    <img src="../assets/images/logofoter.png" alt="Ir a Inicio">
  </a>
  
  <div class="bg-overlay"></div>

  <div class="admin-login-wrapper">
    <form class="admin-login-card" method="post">
      <div class="card-header">
        <h1>Iniciar Sesión</h1>
        <p style="color: #8c0606;">Ingresa tus datos solo tienes dos intentos</p>
      </div>

      <?php if ($error): ?>
        <p class="form-error"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <div class="input-group">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
      </div>

      <div class="input-group">
        <input type="password" name="password" placeholder="Contraseña" required>
      </div>

      <button type="submit" class="btn-submit">Entrar</button>
      
      <div class="card-footer">
        <a href="../index.php" class="link-back">Volver al sitio principal</a>
      </div>
    </form>
  </div>
</body>
</html>

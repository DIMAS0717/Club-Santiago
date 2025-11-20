<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/includes/db.php';

// Mostrar a qué base está conectado
$resDb = $conn->query("SELECT DATABASE() AS dbname");
$rowDb = $resDb ? $resDb->fetch_assoc() : null;
echo "<p>Base de datos actual: <strong>" . htmlspecialchars($rowDb['dbname'] ?? 'desconocida') . "</strong></p>";

// Intentar un INSERT simple
$sql = "INSERT INTO properties (nombre, capacidad, descripcion_corta, categoria)
        VALUES (?,?,?,?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error en prepare: " . $conn->error);
}

$nombre = 'Casa debug ' . time();
$capacidad = 4;
$desc_corta = 'Insert desde debug_insert.php';
$categoria = 'renta';

$stmt->bind_param('siss', $nombre, $capacidad, $desc_corta, $categoria);

if (!$stmt->execute()) {
  die("Error en execute: " . $stmt->error);
}

echo "<p>INSERT OK. ID generado: <strong>" . $stmt->insert_id . "</strong></p>";
$stmt->close();

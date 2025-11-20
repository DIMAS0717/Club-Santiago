<?php
// includes/db.php
$DB_HOST = 'localhost';
$DB_USER = 'root';        // cámbialo
$DB_PASS = '123456789';            // cámbialo
$DB_NAME = 'club_santiago';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
  die('Error de conexión: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

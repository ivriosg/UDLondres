<?php
// Conexión MySQL Orientada a Objetos
$nombre_servidor = "";
$username = "";
$password = "";
$dbname = "";

// Creamos la conexión
$conn = new mysqli($nombre_servidor, $username, $password, $dbname);

// Verificamos que la conexión sea exitosa
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
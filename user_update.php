<?php
// Asignamos a una variable la sesión.
session_start();
$var_email = $_SESSION["email"];
// Realizamos consulta para obtener todos los datos
include_once 'conexion.php';
// Seleccionamos la información con la variable de sesión
$sql = "SELECT * FROM usuarios WHERE email = '$var_email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
  while ($row = $resultado->fetch_assoc()) {
    $nombre = $row["nombre"];
    $telefono = $row["telefono"];
    $usuario = $row["usuario"];
  }
} else {
  echo 'No existen datos en la consulta';
}
?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
  <title>Registro de Usuarios</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col col-sm-6 offset-3">
        <h1><?php echo 'Bienvenido ' . $nombre; ?></h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="name" required value="<?php echo $nombre; ?>" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" required value="<?php echo $var_email; ?>" disabled />
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input class="form-control" type="tel" name="telefono" required value="<?php echo $telefono; ?>" />
          </div>
          <div class="form-group">
            <label for="usuario">Usuario</label>
            <input class="form-control" type="text" name="usuario" required value="<?php echo $usuario; ?>" />
          </div>
          <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input class="form-control" type="password" name="contrasena" required />
          </div>
          <input class="btn btn-primary" type="submit" value="Enviar" name="submit" />
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Verificamos que el usuario actualice la nueva información.
if (isset($_POST['submit'])) {
  $nombre = $_POST['name'];
  $telefono = $_POST['telefono'];
  $usuario = $_POST['usuario'];
  $contrasena = sha1($_POST['contrasena']);

  $update = "UPDATE usuarios SET nombre = '$nombre', telefono = '$telefono', usuario = '$usuario', contrasena = '$contrasena' WHERE email = '$var_email'";
  if ($conn->query($update) === TRUE) {
    echo "Usuario actualizado.";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  $conn->close();
}
?>
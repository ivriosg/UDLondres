<?php
session_start();
include_once 'conexion.php';

if (isset($_POST['submit'])) {

  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $tel = $_POST['telefono'];
  $usr = $_POST['usuario'];
  $contrasena = sha1($_POST['contrasena']);
  $ver_contrasena = sha1($_POST['ver_contrasena']);

  $sql = "SELECT email FROM usuarios WHERE email = '$email'";
  $resultado = $conn->query($sql);

  if ($resultado->num_rows > 0) {
    echo "El email ingresado, ya esta en uso.";
  } else {

    if ($contrasena == $ver_contrasena) {
      // Ejecutar query de inserción de datos
      $sqlreg = "INSERT INTO usuarios (nombre, email, telefono, usuario, contrasena) 
    VALUES ('$nombre', '$email', '$tel', '$usr', '$contrasena')";

      // Guardar en la BD
      if ($conn->query($sqlreg) === TRUE) {
        echo "Se creo un nuevo registro.";
        // Crear email para enviar cambio de contraseña
        $cabeceras = "Content-type: text/html; charset=utf-8 \r\n";
        $cabeceras .= "From: ivan.rios@udlondres.com\n"
          . "Reply-To: ivan.rios@udlondres.com\n";
        $asunto = "Bienvenido a UDLondres";
        $email_to = "$email";
        $contenido = "
                      <h1>Hola $nombre</h1>
                      <p>Agradecemos tu registro en nuestro sistema.</p>
                      <p>Tus datos de usuario son:</p>
                      <ul>
                        <li>$nombre</li>
                        <li>$email</li>
                        <li>$tel</li>
                        <li>$usr</li>
                      </ul>
                    ";

        if (@mail($email_to, $asunto, $contenido, $cabeceras)) {
        } else {
          // Toastr error envio email TODO
          die("Error: Su información no pudo ser enviada, intente más tarde");
        }
      } else {
        echo "Error: " . $sqlreg . "<br>" . $conn->error;
      }
      header("Location: dashboard.php");
    } else {
      echo "Las contraseñas ingresadas no coinciden.";
    }
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Usuario" name="usuario" value="<?php echo $usr; ?>" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="tel" class="form-control" placeholder="Teléfono" name="telefono" value="<?php echo $tel; ?>" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-mobile"></i>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="contrasena" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Retype password" name="ver_contrasena" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <input type="submit" class="btn btn-primary btn-block" value="Registrarse" name="submit">
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="login.php" class="text-center">I already have a membership</a>
      </div>
    </div><!-- /.card -->
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
include_once 'conexion.php';
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $sql = "SELECT * FROM usuarios WHERE email = '$email'";
  $resultado = $conn->query($sql);

  if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
      $nombre = $row['nombre'];
      $emailDB = $row['email'];
      // Crear email para enviar cambio de contraseña
      $cabeceras = "Content-type: text/html; charset=utf-8 \r\n";
      $cabeceras .= "From: ivan.rios@udlondres.com\n"
      . "Reply-To: ivan.rios@udlondres.com\n";
      $asunto = "Solicitu de cambio de contraseña"; 
      $email_to = "$emailDB";
      $contenido = "
        <h1>Hola $nombre</h1>
        <p>Hemos recibido una solicitud para cambiar tu contraseña.</p>
        <p>Si tu no realizaste esta petición, ignora el email.</p>
        <p>Para poder cambiar la contraseña, da clic <a href='http://dev.marketingconweb.com/clase_php/recover.php?email=$emailDB'>aquí</a></p>
      ";

      if (@mail($email_to, $asunto, $contenido, $cabeceras )) {
      } else {
        // Toastr error envio email TODO
          die("Error: Su información no pudo ser enviada, intente más tarde");
      }
      header("Location: login.php");
    }
  } else {
    echo 'No existen datos';
  }

  $conn->close();
}

?>
<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recuperar Contraseña - UDL</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>Universidad de Londres</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" class="btn btn-primary btn-block" value="Recuperar Contraseña" name="submit">
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login.php">Login</a>
        </p>
        <p class="mb-0">
          <a href="registro.php" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
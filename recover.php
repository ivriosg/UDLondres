<?php
// Realizamos consulta para obtener todos los datos

// Este es un comentario nuevo
include_once 'conexion.php';
$email = $_GET['email'];

$form_email = $_POST['form_email'];
$contrasena = sha1($_POST['contrasena']);
$ver_contrasena = sha1($_POST['ver_contrasena']);

if (isset($_POST['submit'])) {
  if ($contrasena == $ver_contrasena) {
    $update = "UPDATE usuarios SET contrasena = '$contrasena' WHERE email = '$form_email'";
    if ($conn->query($update) === TRUE) {
      $cabeceras = "Content-type: text/html; charset=utf-8 \r\n";
      $cabeceras .= "From: ivan.rios@udlondres.com\n"
      . "Reply-To: ivan.rios@udlondres.com\n";
      $asunto = "Solicitu de cambio de contraseña"; 
      $email_to = "$form_email";
      $contenido = "
        <p>Acabamos de realizar la actualización de contraseña en el sistema</p>
        <p>Si tu no realizaste esta acción, te recomendamos cambiar la configuración dando clic <a href='http://dev.marketingconweb.com/clase_php/recuperar_contrasena.php'>aquí</a></p></p>
      ";

      if (@mail($email_to, $asunto, $contenido, $cabeceras )) {
      } else {
        // Toastr error envio email TODO
          die("Error: Su información no pudo ser enviada, intente más tarde");
      }
      header("Location: login.php");
    } else {
      echo "Error updating record: " . $conn->error;
    }
  } else {
    echo "Las contraseñas no coinciden.";
  }
}

?>
<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Recover Password</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="form_email" value="<?php echo $email; ?>">
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="contrasena" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="ver_contrasena" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" class="btn btn-primary btn-block" value="Cambiar Contraseña" name="submit">
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login.php">Login</a>
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
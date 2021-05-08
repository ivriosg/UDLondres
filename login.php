<?php
include_once 'conexion.php';
session_start();

//Eliminar la cookie del navegador
setcookie("user", "", time() - (86400 * 30), "/");

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $contrasena = sha1($_POST['contrasena']);

  $sql = "SELECT * FROM usuarios WHERE email = '$email' AND contrasena = '$contrasena'";
  $resultado = $conn->query($sql);

  if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
      $_SESSION["email"] = $row['email'];
      header("Location: dashboard.php");
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
  <title>Login - Dashboard UDL</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>Univerdad de Londres</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Iniciar Sesión</p>

        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="contrasena">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <input type="submit" class="btn btn-info" value="Login" name="submit">
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="recuperar_contrasena.php">Olvidé mi contraseña</a>
        </p>
        <p class="mb-0">
          <a href="registro.php" class="text-center">Registrate</a>
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
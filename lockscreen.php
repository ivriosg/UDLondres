<?php
include_once 'conexion.php';
session_start();

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $contrasena = sha1($_POST['contrasena']);
  $sql = "SELECT * FROM usuarios WHERE usuario = '$username' AND contrasena = '$contrasena'";
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

if(!isset($_COOKIE['user'])) {
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - Lockscreen UDL</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition lockscreen">
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <a href="/clase_php/login.php"><b>Admin</b>LTE</a>
    </div>
    <div class="lockscreen-name">
      <?php echo $_COOKIE['user']; ?>
    </div>

    <div class="lockscreen-item">
      <div class="lockscreen-image">
        <img src="dist/img/user1-128x128.jpg" alt="User Image">
      </div>

      <form class="lockscreen-credentials" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="username" value=<?php echo $_COOKIE['user']; ?>>
        <div class="input-group">
          <input type="password" class="form-control" placeholder="password" name="contrasena" require>

          <div class="input-group-append">
            <input type="submit" class="btn" value="Login" name="submit">
          </div>
        </div>
      </form>

    </div>
    <div class="help-block text-center">
      Enter your password to retrieve your session
    </div>
    <div class="text-center">
      <a href="login.php">Iniciar Sesión con un usuario diferente</a>
    </div>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>

  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
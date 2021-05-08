<?php
session_start();
include_once 'header.php';
include_once 'conexion.php';

if (isset($_POST['submit'])) {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $tel = $_POST['telefono'];
  $usr = $_POST['usuario'];
  $contrasena = sha1($_POST['contrasena']);
  $isAdmin = $_POST['admin'];

  $sql = "SELECT email FROM usuarios WHERE email = '$email'";
  $resultado = $conn->query($sql);

  if ($resultado->num_rows > 0) {
    echo "ya existe el usuario";
  } else {
    // Ejecutar query de inserción de datos
    $sqlreg = "INSERT INTO usuarios (nombre, email, telefono, usuario, contrasena, is_admin) 
    VALUES ('$nombre', '$email', '$tel', '$usr', '$contrasena', '$isAdmin')";
    
    // Guardar en la BD
    if ($conn->query($sqlreg) === TRUE) {
      echo "Se creo un nuevo registro.";
      // Toastr Exito TODO
      
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
        <img src='https://rutadelaimage.png'>
        <ul>
          <li>$nombre</li>
          <li>$email</li>
          <li>$tel</li>
          <li>$usr</li>
        </ul>
      ";

      if (@mail($email_to, $asunto, $contenido, $cabeceras )) {
      } else {
        // Toastr error envio email TODO
          die("Error: Su información no pudo ser enviada, intente más tarde");
      }
      header("Location: dashboard.php");

    } else {
      echo "Error: " . $sqlreg . "<br>" . $conn->error;
    }
  }
  $conn->close();
}

?>


<section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-12 col-md-6 offset-md-3">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Registro de Usuarios</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="card-body">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" class="form-control" name="telefono" required>
              </div>
              <div class="form-group">
                <label>Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input type="password" class="form-control" name="contrasena" required>
              </div>
              <div class="form-group">
                <label>Privilegios</label>
                <select class="form-select" name="admin">
                  <option selected>Seleccionar...</option>
                  <option name="1" value="1" >Administrador</option>
                  <option name="0" value="0" >Usuario</option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <input type="submit" class="btn btn-primary" name="submit" value="Crear Usuario">
            </div>
          </form>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</section>

<?php include_once 'footer.php'; ?>
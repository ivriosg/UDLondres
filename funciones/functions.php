<?php
// Seleccionar últimos 8 registros
function get_8records()
{
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
  $latest = "SELECT id, nombre FROM usuarios ORDER BY id DESC LIMIT 8";
  $res_latest = $conn->query($latest);

  if ($res_latest->num_rows > 0) {
    while ($row = $res_latest->fetch_assoc()) {
?>
      <li>
        <img src="dist/img/user1-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">
          <?php echo $row["nombre"]; ?>
        </a>
        <span class="users-list-date">
          <?php echo $row["id"]; ?>
        </span>
      </li>
    <?php
    }
  } else {
    echo 'No existen datos en la consulta';
  }
}

function get_total_users()
{
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
  $total_users = "SELECT count(*) as total FROM usuarios";
  $res_total = $conn->query($total_users);

  if ($res_total->num_rows > 0) {
    while ($row = $res_total->fetch_assoc()) {
      echo $row['total'];
    }
  } else {
    echo 'No existen datos en la consulta';
  }
}

function latest_7days()
{

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
  $total_users = "SELECT count(*) as total FROM usuarios WHERE DATE(f_registro) > (NOW() - INTERVAL 7 DAY)";
  $res_total = $conn->query($total_users);

  if ($res_total->num_rows > 0) {
    while ($row = $res_total->fetch_assoc()) {
      echo $row['total'];
    }
  } else {
    echo 'No existen datos en la consulta';
  }
}


function latest_orders()
{
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
  $total_users = "SELECT * FROM usuarios ORDER BY f_registro DESC LIMIT 4";
  $res_total = $conn->query($total_users);

  if ($res_total->num_rows > 0) {
    while ($row = $res_total->fetch_assoc()) {
    ?>
      <tr>
        <td><a href="control_status.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>">
            <?php echo $row['id']; ?>
          </a></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><span class="badge badge-success">
            <a href="https://api.whatsapp.com/send?phone=52<?php echo $row['telefono']; ?>&text=Me gustaría recibir información del diplomado." target="_blank">
              <?php echo $row['telefono']; ?>
            </a>
          </span>
        </td>
        <td>
          <a href="mailto:ivan.rios@udlondres.com?subject=Deseo información del diplomado&body=Hola, me llamo <?php echo $row['nombre']; ?>\n Esta sería la información que va en el cuerpo del email automatizado." target="_blank">
            <?php echo $row['email']; ?>
          </a>
        </td>
        <td>
          <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $row['usuario']; ?></div>
        </td>
      </tr>
<?php
    }
  } else {
    echo 'No existen datos en la consulta';
  }
}
?>
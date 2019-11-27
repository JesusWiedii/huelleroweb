<?php

include "../db.php";
session_start();
if (!isset($_SESSION['User'])) {
  header("location:../index.php");
}
$nombre = '';
$huella = '';
$correo = '';
$contrasena = '';
$id = '';
$user = '';
$id2 = $_GET['id'];
$id3 = $_SESSION['id'];
if (($_SESSION['admini'] == 'No') && $id2 != $id3) {
  header("location:edit.php?id=$id3");
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM usuarios u WHERE u.id=$id ";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombre = $row['nombre_usu'];
    $huella = $row['huella'];
    $user = $row['username'];
    $correo = $row['correo'];
    $estado = $row['estado'];
    $admini = $row['admini'];
    $fecha = $row['fecha'];
  }
  $query_time = "SELECT `h_entry`, `h_departure`, `h_d_lunch`, `h_e_lunch` FROM `alert` WHERE id=$id";
  $result_time = mysqli_query($conn, $query_time);
  if (mysqli_num_rows($result_time) == 1) {
    $row_time = mysqli_fetch_array($result_time);
    $h_entry = $row_time['h_entry'];
    $h_departure = $row_time['h_departure'];
    $h_d_lunch = $row_time['h_d_lunch'];
    $h_e_lunch = $row_time['h_e_lunch'];
  }
}


if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $user = $_POST['user'];
  $h_entry = $_POST['h_entry'];
  $h_departure = $_POST['h_departure'];
  $h_d_lunch = $_POST['h_d_lunch'];
  $h_e_lunch = $_POST['h_e_lunch'];

  if ($_SESSION['admini'] == 'Si') {
    $deshab = $_POST['desha'];
    $admini = $_POST['admini'];
    $huella = $_POST['huella'];
  } else {
    $admini = 'No';
    $deshab = 'Si';
    $huella = $row['huella'];
  }

  $contrasena = $_POST['contrasena'];
  $options = array("cost"=>4);
  $hashPassword = password_hash($contrasena,PASSWORD_BCRYPT,$options);
  if (!empty($nombre) && !empty($correo) && !empty($huella) && !empty($user)) {
    $buscar = "SELECT id FROM usuarios WHERE id!=$id and (huella=$huella or nombre_usu='$nombre')";
    $resultado = mysqli_query($conn, $buscar);

    if (mysqli_num_rows($resultado) == 0) {
      $query_time = "UPDATE `alert` 
                    SET `h_entry`='$h_entry',`h_departure`='$h_departure',
                    `h_d_lunch`='$h_d_lunch',`h_e_lunch`='$h_e_lunch' 
                    WHERE id=$id";
      $result_time = mysqli_query($conn, $query_time);
      if (!empty($contrasena)) {
        $query = "UPDATE usuarios set nombre_usu = '$nombre', 
huella='$huella', correo='$correo', estado='$deshab', 
contrasena='$hashPassword', admini='$admini', username='$user' WHERE id=$id";
        $result = mysqli_query($conn, $query);
      } else {
        $query = "UPDATE usuarios set nombre_usu = '$nombre', 
       huella='$huella', correo='$correo', estado='$deshab', 
        admini='$admini', username='$user' WHERE id=$id";
        $result = mysqli_query($conn, $query);
      }
      if ($result_time && $result && $_SESSION['admini'] == 'Si') {
        echo header("location:admuse.php?Success=Guardado de forma correcta");
      } elseif (!$result_time || !$result) {
        echo header("location:edit?Invalid=Fallo algo en la base de datos");
      } else {
        echo header("location:../index.php?Success=Guardado de forma correcta");
      }
    }
    //fin jaja
    else {
      echo header("location:edit.php?id=$id&Invalid=Ya hay alguien con esa huella/Nombre");
    }
  } else {
    echo header("location:edit.php?id=$id&Invalid=Un campo esta vacio");
  }
}
?>
<?php include('header.php');

?>

<div class="container p-4">
  <div class="row">
    <div class="">
      <div class="card card-body">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <div class="form-group" style="font-size: 20px;">
            <?php if (@$_GET['Invalid'] == true) { ?>
              <div class="aler-light text-danger my-3" style="Background: white;"><?php echo $_GET['Invalid'] ?></div>
            <?php } ?>
            <div style="width: fit-content;">
              <?php if ($_SESSION['admini'] == 'Si') {
                ?><a href="javascript:history.back(-1);" style="background-color: transparent; 
border-color:transparent"> <img style="width: 5rem;" src="../img/volver.svg" alt="">
                </a>
              <?php } ?>

              <a href="list?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
border-color:transparent"> <img class="icons" src="../img/lista.svg" alt="">
              </a>

            </div>
            <div style="/* margin-left: 10rem; */width: 100%;text-align: center;font-weight: bold;">
              <?php if ($_SESSION['admini'] == 'Si') {
                echo 'Bienvenido Administrador Wiedii ' . $_SESSION['name'];
              } else {
                echo 'Bienvenido Wiedder ' . $_SESSION['name'];
              } ?></div>
            <div>
              <table style="width: 100%;font-size: 20px;" class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Nombre completo:</td>
                    <td><input name="nombre" type="text" value="<?php echo $nombre; ?>" placeholder="Actualizar nombre"></td>
                  </tr>
                  <tr>
                    <td>Correo:</td>
                    <td><input name="correo" type="text" value="<?php echo $correo; ?>" placeholder="Actualizar correo"></td>
                  </tr>
                  <tr>
                    <td>Usuario:</td>
                    <td> <input name="user" type="text" value="<?php echo "$user"; ?>" placeholder="Actualizar usuario"> </td>
                  </tr>
                  <tr>
                    <td>Contraseña:</td>
                    <td><input name="contrasena" value=""></td>
                  </tr>
                  <tr>
                    <td style="color:green; background-color:#ecf0f1">Si deseas tener notificaciones automaticas diarias, rellena los siguientes espacios:</td>
                  </tr>
                  <tr>
                    <td>Hora de Entrada (hh:mm:ss) (24hrs):</td>
                    <td><input name="h_entry" value="<?php echo "$h_entry"; ?>"></td>
                  </tr>
                  <tr>
                    <td>Hora de Salida (hh:mm:ss) (24hrs):</td>
                    <td><input name="h_departure" value="<?php echo "$h_departure"; ?>"></td>
                  </tr>
                  <tr>
                    <td>Hora a la que sales a almorzar (hh:mm:ss) (24hrs):</td>
                    <td><input name="h_d_lunch" value="<?php echo "$h_d_lunch"; ?>"></td>
                  </tr>
                  <tr>
                    <td>Hora a la que entras de almorzar (hh:mm:ss) (24hrs):</td>
                    <td><input name="h_e_lunch" value="<?php echo "$h_e_lunch"; ?>"></td>
                  </tr>
                  <?php
                  if ($_SESSION['admini'] == 'Si') {
                    include "menuadmin.php";
                  }
                  ?>
                </tbody>
              </table>
            </div>


            <div style="text-align: center;">
              <button style="color: #27ae60; background-color: white; width:40%;" class="bguarda btn btn-succes btn-block" name="update">Actualizar</button></div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
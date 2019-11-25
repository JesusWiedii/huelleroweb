<?php

include "../db.php";
$nombre = '';
$huella = '';
$correo = '';
$equipo = '';
$contrasena='';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM usuarios u, equipos e WHERE u.id=$id and u.Id_equipo=e.Id_equipo";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombre = $row['nombre_usu'];
    $huella = $row['huella'];
    $contrasena=$row['contrasena'];
    $equipo = $row['nombre_equipo'];
    $correo = $row['correo'];
    $estado = $row['estado'];
    $id_team = $row['Id_equipo'];
    $admini=$row['admini'];
    $fecha=$row['fecha'];
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $nombre = $_POST['nombre'];
  $huella = $_POST['huella'];
  $equipo = $_POST['equipo'];
  $correo = $_POST['correo'];
  $deshab = $_POST['desha'];
  $admini=$_POST['admini'];
  $contrasena=$_POST['contrasena'];
    if (!empty($nombre) && !empty($correo) && !empty($huella) &&!empty($contrasena)) {
    $buscar = "SELECT * FROM usuarios WHERE id!=$id and (huella=$huella or nombre_usu='$nombre')" ;
    $resultado = mysqli_query($conn, $buscar);
   
    if (mysqli_num_rows($resultado) == 0) {
      $query = "UPDATE usuarios set nombre_usu = '$nombre', 
     huella='$huella', Id_equipo = '$equipo', correo='$correo', estado='$deshab', 
     contrasena='$contrasena', admini='$admini' WHERE id=$id";
      $result = mysqli_query($conn, $query);
      if ($result) {
        echo "<script>
            alert('Guardado de forma correcta');location.href='admuse.php'</script>";
      }
    } else {
      echo ("<script>alert('Ya hay alguien adicional con esta huella/nombre');window.history.back()</script>");
    }
  } else {
    echo ("<script>alert('Un campo esta vacio');window.history.back()</script>");
  }
}


?>
<?php include('header.php'); ?>
<div class="container p-4">
  <div class="row">
    <div class="">
      <div class="card card-body">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <div class="form-group" style="margin-top: 15vw;">
            Nombre completo:
            <input name="nombre" type="text" value="<?php echo $nombre; ?>" placeholder="Actualizar nombre">
            <br>
            Correo:
            <input name="correo" type="text" value="<?php echo $correo; ?>" placeholder="Actualizar correo">
            <br>
            Equipo:
            <select name="equipo" id="teams">
              <option selected='selected' value="<?php echo $id_team; ?>"><?php echo $equipo; ?></option>
              <?php include "equipos.php"; ?>
            </select>
            <br>
            Huella:
            <input name="huella" value="<?php echo $huella; ?>">
            <br>
            Contraseña:
            <input name="contrasena" value="<?php echo $contrasena; ?>">
            <br>
            Añadido en: <?php echo $row['fecha']; ?>
            <br>
            Administrador:
            <input type="radio" name="admini" class="chkbox" value="No"checked>No
            <input type="radio" name="admini" class="chkbox" value="Si" >Si
            <br>
            Estado:
            <input type="radio" name="desha" class="chkbox" value="No">Deshabilitado
            <input type="radio" name="desha" class="chkbox" value="Si" checked>Habilitado
            <br>
            <button class="bguarda btn" name="update">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
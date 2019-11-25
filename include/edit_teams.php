<?php
include "../db.php";
$hora_entrada = '';
$hora_salida= '';


if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM equipos WHERE Id_equipo=$id";
  $result_team = mysqli_query($conn, $query);
  if (mysqli_num_rows($result_team) == 1) {
    $row = mysqli_fetch_array($result_team);
    $hora_entrada = $row['hora_entrada'];
    $hora_salida= $row['hora_salida'];
    $equipo=$row['nombre_equipo'];
  }
  else echo "<script>
         alert('No ha encontrado nada, error en la base de datos');window.history.back()</script>"; 
}

if (isset($_POST['updatet'])) {
  $id = $_GET['id'];
  $hora_entrada = $_POST['hora_entrada'];
  $hora_salida=$_POST['hora_salida'];


  $query = "UPDATE equipos set hora_entrada = '$hora_entrada', 
  hora_salida='$hora_salida'WHERE Id_equipo=$id";
  mysqli_query($conn, $query);
  echo "<script>
            alert('Guardado de forma correcta');location.href='admuse.php'</script>";

}

?>
<?php include('header.php'); ?>
<div class="container p-4">
  <div class="row">
    <div class="">
      <div class="card card-body">
      <form action="edit_teams.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <div class="form-group" style="margin-top: 15vw;">
          Equipo: <?php echo $equipo?> 
          <br>
          Hora de entrada:
          <input name="hora_entrada" type="text"  value="<?php echo $hora_entrada; ?>" 
          placeholder="07:00:00">
          <br>
          Hora de salida:
          <input name="hora_salida" value="<?php echo $hora_salida; ?>"placeholder="07:00:00" >
          
        <br>
        
        <button class="bguarda btn" name="updatet">
          Actualizar horarios</button>

        </div>
      </form>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
   

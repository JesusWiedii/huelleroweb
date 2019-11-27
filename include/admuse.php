<?php include "header.php";
session_start();
if (!isset($_SESSION['User'])) {
  header("location:../index.php");
}
if (!isset($_SESSION['User']) && $_SESSION['admini'] == 'No') {
  header("location:../index.php");
} else { }
?>


<form action="add" method="post">

  <div style="place-content: center;text-align: right;display: flex;width: 100%; /* margin-top:30px; */"><button type="submit" class="btn btn-success wbutton" name='guardar_persona' value="Guardar" style="width: 50%;margin-right: 0rem;margin-top: 1rem; background-color: #27ae60;">Agregar persona</button></div>

  <div style="/* margin-left: 10rem; */width: 100%;text-align: center;font-size:2rem;font-weight: bold;"><?php
                                    if (isset($_SESSION['User']) && $_SESSION['admini'] == 'Si') {
                                      echo 'Bienvenido Administrador Wiedii ' . $_SESSION['name'];
                                    }
                                    if (@$_GET['Success'] == true) { ?>
      <div class="aler-light text-success my-3" style="Background: white;"><?php echo $_GET['Success'] ?></div>
    <?php } ?></div>
  <div style="text-align: -webkit-center;">
    <table class="table table-bordered" style="font-size: 2rem; margin-top:2vw;max-width: 80%; " id="tablausu">
      <thead>
        <tr>
          <th>Wiediier</th>
          <th>Correo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $query = "SELECT * FROM usuarios u  
              where 1 ORDER BY admini DESC, estado DESC, nombre_usu ASC";
        $result_tasks = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr style="text-align-last: center;">
            <td><?php echo $row['nombre_usu']; ?></td>
            <td><?php echo $row['correo']; ?></td>
            <td>Admin: <?php echo $row['admini']; ?>
            Habilitado: <?php echo $row['estado']; ?></td>
            <td>
              <a href="list?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
              border-color:transparent"> <img class="icons" src="../img/lista.svg" alt="">
              </a>

              <a href="edit.php?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
              border-color:transparent"> <img class="icons" src="../img/editar.svg" alt="">
              </a>
              <!-- <a href="delete_task.php?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
              border-color:transparent"> <img class="icons" src="../img/Trash.svg" alt="">
                </a> -->


            </td>
            
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>


  </div>

</form>



</div>
</div>
</div>

<?php include "footer.php"; ?>
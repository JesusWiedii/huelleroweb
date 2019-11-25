<?php include "header.php"; ?>



  <form action="save_task.php" method="post">
  <div>
      <br>
      <!-- <p>Nombre completo: <input type="text" name="nombrenuevo" id="nombrenuevo"><br> Correo:
        <input type="text" name="correonuevo" id="correonuevo"> <br> Equipo:
        <select class="custom-select" name="teams" id="teams">
          
        </select> <br> Huella: <input type="text" name="huellanuevo" id="huellanuevo">
        <br>Contraseña: <input type="text" name="contrasena" id="contrasena"> <br>
        Administrador:
        <input type="radio" class="chkbox" name="administrador" value="No" checked>No
        <input type="radio" class="chkbox" name="administrador" value="Si">Si
        <br>
        <input type="submit" class="bguarda btn" name='guardar_persona' value="Guardar">
      </p> -->
      <div style="text-align: right;"><button type="submit" class="btn btn-success wbutton" name='guardar_persona' value="Guardar">Agregar persona</button></div>
      <div style="text-align: -webkit-center;">
      <table class="table table-bordered" style="font-size: 2vw; margin-top:2vw;max-width: 80%; " id="tablausu">
        <thead>
          <tr>
            <th>Nombre usuario</th>
            <th>Correo</th>
            <th>Administrador</th>
            <th>Accion</th>
            <th>Habilitado</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $query = "SELECT * FROM usuarios u, equipos e 
              where u.Id_equipo=e.Id_equipo ORDER BY admini DESC, estado DESC, nombre_usu ASC";
          $result_tasks = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr style="text-align-last: center;">
              <td><?php echo $row['nombre_usu']; ?></td>
              <td><?php echo $row['correo']; ?></td>
              <td><?php echo $row['admini']; ?></td>
              <td>


                <a href="edit.php?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
              border-color:transparent"> <img class="icons" src="../img/editar.svg" alt="">
                </a>
                <a href="delete_task.php?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
              border-color:transparent"> <img class="icons" src="../img/Trash.svg" alt="">
                </a>

              </td>
              <td><?php echo $row['estado']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>


    </div>
    
  </form>

  <div id="tab-body-2" class="tab-body">

    <table class="table table-bordered" style="font-size: 2vw; text-align:center;" id="tablateam">
      <thead>
        <tr>
          <th>Id</th>
          <th>Equipo</th>
          <th>Hora de entrada</th>
          <th>Hora de salida</th>
          <th>Accion</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query_team = "SELECT * FROM equipos e ORDER BY Id_equipo ASC";
        $result_tasks_team = mysqli_query($conn, $query_team);
        while ($row = mysqli_fetch_assoc($result_tasks_team)) { ?>
          <tr style="text-align-last: center;">
            <td><?php echo $row['Id_equipo']; ?></td>
            <td><?php echo $row['nombre_equipo']; ?></td>
            <td><?php echo $row['hora_entrada']; ?></td>
            <td><?php echo $row['hora_salida']; ?></td>
            <td>
              <a href="edit_teams.php?id=<?php echo $row['Id_equipo'] ?>" class="btn btn-secondary">
                <i class="fas fa-marker"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>


  </div>



</div>
</div>
</div>

<?php include "footer.php"; ?>
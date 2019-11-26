<?php
include "../db.php";
session_start();
if (!isset($_SESSION['User'])) {
    header("location:../index.php");
}
include('header.php');
$id = $_GET['id'];
$id2 = $_SESSION['id'];
if ($_SESSION['admini'] == 'No' && $id2 != $id) {
    header("location:list?id=$id2");
}
$query = "SELECT nombre_usu, correo FROM usuarios 
where id=$id ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$nameuser = $row['nombre_usu'];

?>
<div class="container p-4">
    <div style="width: fit-content;">
        <a href="javascript:history.back(-1);" style="background-color: transparent; 
              border-color:transparent"> <img style="width: 5rem;" src="../img/volver.svg" alt="">
        </a>
    </div>
    <?php

    if ($_SESSION['admini'] == 'Si') {
        echo 'Bienvenido Administrador Wiedii ' . $_SESSION['name'];
        ?><br><?php
                        echo 'Listado de asistencia del Wiedder ' . $nameuser;
                    } else {
                        echo 'Listado de assitencia del Wiedder ' . $_SESSION['name'];
                    } ?>
    <div style="text-align: -webkit-center;">
        <table class="table table-bordered" style="font-size: 2rem; margin-top:2vw;max-width: 80%; " id="tablausu">
            <thead>
                <tr>
                    <td>Fecha</td>
                    <td>Hora de entrada</td>
                    <td>Hora de salida</td>
                    <td>Total horas</td>
                </tr>
            </thead>

            <tbody>
                <?php

                $query = "SELECT `Fecha`, `entry_time`, `departure_time`, TIMEDIFF(departure_time, entry_time)
                    FROM `registro` 
                    WHERE id=$id 
                    ORDER BY Fecha DESC, entry_time DESC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr style="text-align-last: center;">
                        <td><?php echo $row['Fecha']; ?></td>
                        <td><?php echo $row['entry_time']; ?></td>
                        <td><?php echo $row['departure_time']; ?></td>
                        <td><?php echo $row['TIMEDIFF(departure_time, entry_time)']; ?></td>
                    <?php } ?>

            </tbody>
        </table>
    </div>
</div>
<?php include('footer.php'); ?>
<?php
session_start();
include "header.php";
if (!isset($_SESSION['User'])) {
	header("location:../index.php");
}
if (!isset($_SESSION['User']) && $_SESSION['admini'] == 'No') {
	header("location:../index.php");
} else { }
?>


<div>
	<h1 style="display: inline-table;margin-top: 2rem;width: 100%;text-align: center;font-size: 2rem;font-weight: bold;">
		Formulario para agregar personas al huellero Wiedii</h1>
	<div style="text-align: left;">
		<button style="color: red; background-color: transparent; width:8%;" class="bguarda btn btn-succes btn-block" name=""><a href="admuse" style="background-color: transparent; 
border-color:transparent"> <img style="width: 5rem; position: fixed;text-align: left;" src="../img/volver.svg" alt="">
			</a></button></div>
	<div>
		<?php if (@$_GET['Invalid'] == true) { ?>
			<div class="aler-light text-danger my-3" style="Background: white; text-align:center"><?php echo $_GET['Invalid'] ?></div>
		<?php } ?></div>
	<form action="save_task" method="post">
		<div class="container p-4" style="text-align: -webkit-center;">
			<table class="table table-bordered" style="font-size: 2rem; margin-top:2rem;max-width: 80%; " id="tablausu">
				<tr>
					<td>Nombre completo:</td>
					<td><input type="text" name="nombrenuevo" id="nombrenuevo"></td>
				</tr>
				<tr>
					<td>Correo:</td>
					<td><input type="text" name="correonuevo" id="correonuevo"> </td>
				</tr>
				<tr>
					<td>Usuario:</td>
					<td><input type="text" name="user" id="user"> </td>
				</tr>
				<tr>
					<td>Huella:</td>
					<td><input type="text" name="huellanuevo" id="huellanuevo"></td>
				</tr>
				<tr>
					<td>Contraseña:</td>
					<td><input type="text" name="contrasena" id="contrasena"></td>
				</tr>
				<tr>
					<td>Administrador:</td>
					<td><input type="radio" class="chkbox" name="administrador" value="No" checked>No
						<input type="radio" class="chkbox" name="administrador" value="Si">Si</td>
				</tr>
			</table>

			<div style="text-align: center;">

				<button type="submit" style="color: white ; background-color:#27ae60 ; width:40%;" class="btn btn-success wbutton" name="guardar_persona">Guardar</button></div>

		</div>

</div>


</div>
</form>
<!-- <div style="text-align: center;">
<button style="color: red; background-color: transparent; width:8%;" class="bguarda btn btn-succes btn-block" name=""><a href="admuse" style="background-color: transparent; 
border-color:transparent"> <img style="width: 5rem;" src="../img/volver.svg" alt="">
</a></button></div> -->
</div>

<?php include('footer.php'); ?>
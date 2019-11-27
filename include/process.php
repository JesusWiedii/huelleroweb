<?php
session_start();
require_once "../db.php";

if (isset($_POST['entrar'])) {

	if (empty($_POST['username']) || empty($_POST['password'])) {
		header("location:../index.php?Empty= Llena los espacios");
	} 
	else {
		$cont=$_POST['password'];
		$query = "SELECT * From usuarios where username='" . $_POST['username'] . "' ";
		$result = mysqli_query($conn, $query);
		$row=mysqli_fetch_assoc($result);

	 if (mysqli_num_rows($result)==1 && password_verify($cont,$row['contrasena'])) {
		 
			$_SESSION['User'] = $_POST['username'];
			$query = "SELECT * FROM usuarios WHERE username='" . $_POST['username'] . "'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result);
			$nombre = $row['nombre_usu'];
			$admini = $row['admini'];
			$estate = $row['estado'];
			$id = $row['id'];
			if ($estate == 'Si') {
				if ($admini == 'Si') {
					$_SESSION['name'] = $nombre;
					$_SESSION['admini'] = 'Si';
					$_SESSION['id'] = $id;
					header("location:admuse.php");
				} 
				else {
					$_SESSION['name'] = $nombre;
					$_SESSION['admini'] = 'No';
					$_SESSION['id'] = $id;
					header("location:edit.php");
				}
			} 
			else {
				header("location:../index.php?Invalid= Por favor, ingresa un usuario y contraseña valido");
			}
		 } 
		 else {
			header("location:../index.php?Invalid= Por favor, ingresa un usuario y contraseña valido");
		}
	}
} else {
	echo "not working";
}
?>
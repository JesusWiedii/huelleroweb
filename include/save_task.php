<?php include "../db.php";
session_start();
if (!isset($_SESSION['User'])) {
  header("location:../index.php");
}
if (!isset($_SESSION['User']) && $_SESSION['admini'] == 'No') {
  header("location:../index.php");
} else { }


$nombre = $_POST['nombrenuevo'];
$correo = $_POST['correonuevo'];
$huella = $_POST['huellanuevo'];
$contrasena = $_POST['contrasena'];
$options = array("cost"=>4);
$hashPassword = password_hash($contrasena,PASSWORD_BCRYPT,$options);
$admini = $_POST['administrador'];
$user=$_POST['user'];

if (!empty($nombre) && !empty($correo) && !empty($huella) && !empty($user)) {

    if (isset($_POST['guardar_persona'])) {
        $buscar = "SELECT * FROM usuarios WHERE huella=$huella or nombre_usu='$nombre'";
        $resultado = mysqli_query($conn, $buscar);
        // echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) == 0) {
            $query = "INSERT INTO usuarios (nombre_usu, huella, contrasena,  correo, estado,  admini, username) 
            VALUES ('$nombre','$huella', '$hashPassword','$correo','Si','$admini','$user')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo header("location:admuse?Success=Guardado de forma correcta");
            } else 
            echo header("location:add?Invalid=No ha guardado, error en la base de datos");
        } else 
        echo header("location:add?Invalid=El usuario ya existe");
    }
} else
echo header("location:add?Invalid=Un campo esta vacio");
?>

<?php include "../db.php";
$nombre = $_POST['nombrenuevo'];
$correo = $_POST['correonuevo'];
$equipo = $_POST['teams'];
$huella = $_POST['huellanuevo'];
$contrasena = $_POST['contrasena'];
$admini = $_POST['administrador'];

if (!empty($nombre) && !empty($correo) && !empty($huella)) {

    if (isset($_POST['guardar_persona'])) {
        $buscar = "SELECT * FROM usuarios WHERE huella=$huella or nombre_usu='$nombre'";
        $resultado = mysqli_query($conn, $buscar);
        // echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) == 0) {
            $query = "INSERT INTO usuarios (nombre_usu, huella, contrasena, Id_equipo, correo, estado,  admini) 
            VALUES ('$nombre','$huella', '$contrasena',$equipo,'$correo','Si','$admini')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo ("<script>
           alert('Guardado de forma correcta');location.href='admuse.php'</script>");
            } else echo ("<script>
                alert('No ha guardado, error en la base de datos');window.history.back()</script>");
        } else echo ("<script>
     alert('El usuario ya existe');window.history.back()</script>");
    }
} else
    echo ("<script>alert('Un campo esta vacio');window.history.back()</script>");
?>
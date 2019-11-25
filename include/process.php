<?php
session_start();
require_once "../db.php";

if (isset($_POST['entrar'])) {
    
    if (empty($_POST['username']) || empty($_POST['password'])) { 
        header("location:../index.php?Empty= Llena los espacios");
    }
    else{
        $query="SELECT * From usuarios where username='".$_POST['username']."' 
        and contrasena='".$_POST['password']."' ";
        $result=mysqli_query($conn,$query);
        
        if(mysqli_fetch_assoc($result)){
            $_SESSION['User']=$_POST['username'];
            $query = "SELECT * FROM usuarios WHERE username='".$_POST['username']."'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            $nombre = $row['nombre_usu'];
            $_SESSION['name']=$_POST["$nombre"];
            echo $_SESSION['name'];
            // header("location:admuse.php");
        }
        else{
            header("location:../index.php?Invalid= Por favor, ingresa un usuario y contraseña valido");
        
        }
    }
} else {
    echo "not working";
}

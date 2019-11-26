<?php
session_start();
include "header.php";
if (!isset($_SESSION['User'])) {
    header("location:../index.php");
}
if (!isset($_SESSION['User']) && $_SESSION['admini'] == 'No') {
    header("location:../index.php");
} else { }

include("../db.php");

if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "DELETE FROM usuarios WHERE id = $id";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }
  echo "<script>
  alert('Eliminado de forma correcta');location.href='admuse.php'</script>";
}


?>
<?php
session_start();
include 'conexion.php';
$link = conexion();
$idHot = $_POST['idHotsale'];
$precio = $_POST['precioHot'];
if (isset($_SESSION['nombre'])&&($_SESSION['rol']== 'ADMINISTRADOR')) {
	  $sql = "UPDATE hotsales SET precio='$precio', estado= 'HOTSALE' WHERE ID=$idHot";
   mysqli_query($link,$sql);
       echo '<script> alert ("Hotsale modificado correctamente")</script>';
       echo '<script> window.location="index.php"</script>'; 
   }
?>
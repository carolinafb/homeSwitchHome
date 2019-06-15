<?php
session_start();
include "conexion.php";
$link=conexion();
$descripcion= $_POST['descripcionDeCancelacion'];
$idUsuario= $_SESSION['id'];


$query="INSERT INTO cancelaciones ( ID_usuario, motivoCancelacion )VALUES ('$idUsuario', '$descripcion')";
mysqli_query($link,$query);

$actualizar= "UPDATE usuario SET estado= 'INACTIVO' WHERE ID=$idUsuario";
mysqli_query($link,$actualizar);
session_destroy();

echo '<script> alert ("Cancelacion Aceptada")</script>';
      echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades


      ?>
<?php
session_start();
include "conexion.php";
$link=conexion();

$idUsuario= $_SESSION['id'];
$query="SELECT * FROM `usuario` WHERE id= $idUsuario";
$consulta=mysqli_query($link, $query);
$datos= mysqli_fetch_array($consulta);
$contrasenaUsuario= $datos['contrasena'];


if(isset($_SESSION['nombre'])){
	if(($_SESSION['rol']== 'ESTANDAR') || ($_SESSION['rol']== 'PREMIUM')){
		if ($_POST['contrasenaActual']== $contrasenaUsuario) {
			if ($_POST['contrasenaNueva']!= '') {
				//actualizo la base de datos completa con los datos
			}elseif ($_POST['contrasenaNueva']== '') {
				//actualizo solo las cosas que vienen menos la contrasenia
			}
		}else{
			 echo '<script> alert ("Contrasenia incorrecta")</script>';
      echo '<script> window.location="modificarPerfil.php"</script>';

		}


   }

		?>
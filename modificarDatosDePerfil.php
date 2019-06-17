<?php
session_start();
include "conexion.php";
$link=conexion();

$idUsuario= $_SESSION['id'];

$query="SELECT * FROM `usuario` WHERE ID = $idUsuario";
$consulta=mysqli_query($link, $query);
$datos= mysqli_fetch_array($consulta);
$contrasenaUsuario= $datos['contrasena'];
$nombre= $_POST['nombreUsuario'];
$apellido=$_POST['apellidoUsuario'];
$fechaNacimiento=$_POST['fechaNacimiento'];
$pais=$_POST['pais'];
$numerotarjeta=$_POST['numerotarjeta'];
$nombreYapellidoDeTarjeta=$_POST['nomYape'];
$fechaExpiracion=$_POST['expiracion'];
$codigoSeguridad=$_POST['codSeg'];
$contrasenaNueva=$_POST['contrasenaNueva'];
$email=$_POST['email'];

if(isset($_SESSION['nombre'])){
		if (($_POST['contrasenaActual']) == $contrasenaUsuario) {
			//echo $contrasenaUsuario;
			if (!preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/",$email)) { /*SE VALIDA QUE EL MAIL TENGA EL FORMATO DE MAIL--> combinacion de letras/numero/signos seguidos de @ seguido de convinacion + . algo */
				echo '<script>  alert ("email incorrecto");</script>';
				echo '<script> window.location="perfilUsuario.php"</script>';
			}
			elseif (($_POST['contrasenaNueva'])!='') {
				//actualizo la base de datos completa con los datos
				$sql= "UPDATE `usuario` SET nombre= '$nombre', apellido='$apellido',email='$email', fechaNacimiento='$fechaNacimiento', contrasena='$contrasenaNueva', pais= '$pais', numeroTarjeta='$numerotarjeta', nombreYapellidoDeTarjeta='$nombreYapellidoDeTarjeta', fechaExpiracion='$fechaExpiracion', codigoSeguridad='$codigoSeguridad' WHERE ID= $idUsuario";
				$primera=mysqli_query($link,$sql);
				//echo $primera;
				//echo "1";
			}elseif (($_POST['contrasenaNueva'])=='') {
				//actualizo la base de datos completa con los datos
				$sql= "UPDATE `usuario` SET nombre= '$nombre', apellido='$apellido',email='$email', fechaNacimiento='$fechaNacimiento', pais= '$pais', numeroTarjeta='$numerotarjeta', nombreYapellidoDeTarjeta='$nombreYapellidoDeTarjeta', fechaExpiracion='$fechaExpiracion', codigoSeguridad='$codigoSeguridad' WHERE ID= $idUsuario";
				$segunda=mysqli_query($link,$sql);
				//echo $segunda;
				//echo "2";
			}
			$_SESSION['nombre']=$nombre;
			$_SESSION ["apellido"]=$apellido;
			$_SESSION["email"]=$email;
			$_SESSION["fechaNacimiento"]=$fechaNacimiento;
			$_SESSION["pais"]=$pais;
			$_SESSION["numeroTarjeta"]= $numerotarjeta;
			$_SESSION["expiracion"]=$fechaExpiracion;

			

			echo '<script> alert ("Datos modificados correctamente")</script>';
			echo '<script> window.location="perfilUsuario.php"</script>';

		}else{
			echo '<script> alert ("Contrasenia incorrecta")</script>';
			echo '<script> window.location="modificarPerfil.php"</script>';



	}
	  }

	?>
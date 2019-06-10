<?php
	session_start();
	include "conexion.php";
	$link=conexion();
	if ((isset($_POST['email']))&& (isset($_POST['contrasena']))){//Este if verifica que los datos recibidos en el formulario de login no esten vacios, si no estan vacios los guarda en las variables.
			$email=$_POST['email'];
			$contrasena=$_POST['contrasena'];
	}
	$sql= mysqli_query($link,"SELECT * FROM usuario WHERE email = '$email' AND contrasena ='$contrasena'");//consulto si el mail y la contrasena recibida coinciden con un usuario en la tabla de la base de datos

	if (mysqli_num_rows($sql)>0) { // obtengo el numero de filas de la variable, si es 0 es porque el mail no esta registrado.
		$row= mysqli_fetch_array ($sql);
		$_SESSION["id"]=$row ['ID'];
		$_SESSION["email"]=$row ['email'];
		$_SESSION["nombre"]=$row ['nombre'];
		$_SESSION["apellido"]=$row ['apellido'];
		$_SESSION['rol']=$row['rol'];
		$_SESSION["fechaNacimiento"]=$row ['fechaNacimiento'];
		$_SESSION["pais"] = $row ['pais'];

		$_SESSION["numeroTarjeta"] = $row ['numeroTarjeta'];
		$_SESSION["nomYape"] = $row ['nombreYapellidoDeTarjeta'];
		$_SESSION["expiracion"] = $row ['fechaExpiracion'];
		$_SESSION["codSeg"] = $row['codigoSeguridad'];

		$_SESSION['login']=true;




		/*if ($row['rol'] == 'ADMINISTRADOR') {
				echo '<script> window.location="MiPerfilAdministrador.php"</script>';
		}else
	echo '<script> window.location="MiPerfil.php"</script>';*/
	echo '<script> window.location = "index.php" </script>';
	}else{
		$_SESSION['login']=false;
		echo '<script> alert ("usuario o contraseña incorrecta");</script>';
		echo '<script> window.location="login.php"; </script>';
	}

?>

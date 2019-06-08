<?php
	session_start();
	include "conexion.php";
	$link=conexion();
	if ((isset($_POST['codigo']))){//Este if verifica que los datos recibidos en el formulario de login no esten vacios, si no estan vacios los guarda en las variables.
			$codigo=$_POST['codigo'];
	}
	$sql= mysqli_query($link,"SELECT * FROM usuario WHERE codigo = '$codigo'");//consulto si el codigo concida con un usuario en la tabla de la base de datos
		if (mysqli_num_rows($sql)>0) { // obtengo el numero de filas de la variable, si es 0 es porque el mail no esta registrado.
		$row= mysqli_fetch_array ($sql);
		$_SESSION["codigo"]=$row ['codigo'];
		$_SESSION['rol']=$row['rol'];
		$_SESSION['id']=$row ['ID'];
		$_SESSION['login']=true;

		/*if ($row['rol'] == 'ADMINISTRADOR') {
				echo '<script> window.location="MiPerfilAdministrador.php"</script>';
		}else
		       echo '<script> window.location="MiPerfil.php"</script>';*/
		echo '<script> window.location = "index.php" </script>';       
	}else{
		$_SESSION['login']=false;
		echo '<script> alert ("codigo incorrecto");</script>';
		echo '<script> window.location="loginLiviano.php"; </script>';
	}
	
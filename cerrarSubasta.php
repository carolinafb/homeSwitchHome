<html>
	<?php
		session_start();
		include 'conexion.php';
		$link=conexion();
    	if(isset($_SESSION['login'])){// si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
   			if($_SESSION['rol']== 'ADMINISTRADOR'){					
				$idSubasta = $_GET["id"];
				$query = "UPDATE `subastas` SET estado = 'NO DISPONIBLE' WHERE ID = $idSubasta";
				$consulta = mysqli_query ($link,$query);	//Calcular el ganador 
				echo '<script> alert ("Subasta cerrada correctamente")</script>';
				echo '<script> window.location="listarSubastas.php"</script>'	;
		}
	}else{
		 echo '<script> window.location="index.php"</script>';
	}?>	
</html>
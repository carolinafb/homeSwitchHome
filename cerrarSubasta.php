<html>
	<?php
		session_start();
		include 'conexion.php';
		$link=conexion();
    	if(isset($_SESSION['login'])){
   			if($_SESSION['rol']== 'ADMINISTRADOR'){					
				$idSubasta = $_GET["id"];
			//Calcular el ganador 	
			$queryGanador="SELECT ID_Usuario, MAX(monto) FROM pujas WHERE ID_subasta=$idSubasta ";//El monto maximo pujado de la subasta. 
			$consultaGanador=mysqli_query($link, $query);
			if (mysqli_num_rows($consultaGanador)>0) {// Si traigo filas
				$fila=mysqli_fetch_array($consultaGanador);
				$IDUsu= $fila['ID_Usuario'];
				$queryUsuario="SELECT nombre,apellido FROM usuario WHERE ID=$IDUsu ";//El monto maximo pujado de la subasta. 
				$consultaUsuario=mysqli_query($link, $query);
				$fila2=mysqli_fetch_array($consultaUsuario);
				// guardo el ID del Usuario ganador de la subasta el la tabla subasta
				$query3="UPDATE subastas SET ID_UsuarioGanador = $IDUsu WHERE ID = $idSubasta";
				// informo los datos del ganador en pantalla.
				echo '<script> alert ("El ganador de la subasta es el usuario:<?php echo $fila2["nombre"] ,$fila2["apellido"];?>")</script>';
				// actualizo el estado de la subasta a no disponible
				$query = "UPDATE subastas SET estado = 'NO DISPONIBLE' WHERE ID = $idSubasta";
				$consulta = mysqli_query ($link,$query);
				echo '<script> alert ("Subasta cerrada correctamente")</script>';
		}else{
			echo '<script> alert ("Subasta cerrada correctamente, Ninuna puja.Sin ganador")</script>'
		}
	}else{
		 echo '<script> window.location="index.php"</script>';
	}?>	
</html>
<html>
	<?php
		session_start();
		include 'conexion.php';
		$link=conexion();
    	if(isset($_SESSION['login'])){// si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
   			if($_SESSION['rol']== 'ADMINISTRADOR'){					
				$queryDisponibles = "SELECT * FROM subastas WHERE estado = 'DISPONIBLE' ";
				$consultaDisponibles = mysqli_query ($link,$query); // me traigo todas las subastas disponibles 
				//por cada subasta disponible controlo si pasaron los 3 dias
				//si se cerro, llamo al cerrar subasta pasandole el id de la subasta
				while ($fila=mysqli_fetch_array($consultaDisponibles)){ //Mientras existan filas en la consulta Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
					$semanaFin= date("Y-m-d",strtotime(date("Y-m-d")."-3 days")); // me creo estas variables para restringir que las semana de las subastas a crear sean dentro de la ventana permitida
					if($fila["fechaInicio"] <  $semanaFin){
						echo '<script> window.location="CerarSubasta.php?id=ID"</script>';
				}
		}
	}else{
		 echo '<script> window.location="index.php"</script>';
	}?>	
</html>
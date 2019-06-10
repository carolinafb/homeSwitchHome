<html>
<?php
session_start();
include 'conexion.php';
$link = conexion();
if (isset($_SESSION['login'])) { // si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
	if ($_SESSION['rol'] == 'ADMINISTRADOR') {
		$queryDisponibles = "SELECT * FROM subastas WHERE estado = 'DISPONIBLE' ";
		$consultaDisponibles = mysqli_query($link, $queryDisponibles); // me traigo todas las subastas disponibles 
		//por cada subasta disponible controlo si pasaron los 3 dias
		//si se cerro, llamo al cerrar subasta pasandole el id de la subasta
		while ($fila = mysqli_fetch_array($consultaDisponibles)) { //Mientras existan filas en la consulta Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
			$semanaFin = date("Y-m-d", strtotime(date("Y-m-d") . "-3 days")); // me creo estas variables para restringir que las semana de las subastas a crear sean dentro de la ventana permitida
			if ($fila["fechaInicio"] <  $semanaFin) {
				$idSub = $fila["ID"];
				//Calcular el ganador 	
				$queryGanador = "SELECT ID_Usuario, MAX(monto) FROM pujas WHERE ID_subasta=$idSub "; //El monto maximo pujado de la subasta. 
				$consultaGanador = mysqli_query($link, $queryGanador);
				if (mysqli_num_rows($consultaGanador) > 0) { // Si traigo filas
					$fila = mysqli_fetch_array($consultaGanador);
					$IDUsu = $fila['ID_Usuario'];
					$queryUsuario = "SELECT nombre,apellido FROM usuario WHERE ID=$IDUsu "; //El monto maximo pujado de la subasta. 
					$consultaUsuario = mysqli_query($link, $queryUsuario);
					$fila2 = mysqli_fetch_array($consultaUsuario);
					// guardo el ID del Usuario ganador de la subasta el la tabla subasta
					$query3 = "UPDATE subastas SET ID_UsuarioGanador = $IDUsu WHERE ID = $idSub";
					// informo los datos del ganador en pantalla.
					echo '<script> alert ("El ganador de la subasta es el usuario:<?php echo $fila2["nombre"] ,$fila2["apellido"];?>")</script>';
					// actualizo el estado de la subasta a no disponible
					$query = "UPDATE subastas SET estado = 'NO DISPONIBLE' WHERE ID = $idSub";
					$consulta = mysqli_query($link, $query);
					echo '<script>alert("Subasta cerrada correctamente")</script>';
				} else {
					echo '<script>alert("Subasta cerrada correctamente, Ninguna puja.Sin ganador")</script>';
				}
			}
		}
	}
} ?>
<script> window.location="listarSubastas.php"</script>

</html>
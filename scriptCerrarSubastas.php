<html>
<?php
session_start();
include 'conexion.php';
$link = conexion();
if (isset($_SESSION['login'])) { // si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
	if ($_SESSION['rol'] == 'ADMINISTRADOR') {
		// me traigo todas las subastas disponibles 
		$querySubastasDisponibles = "SELECT * FROM subastas WHERE estado = 'DISPONIBLE' ";
		$consultaSubastasDisponibles = mysqli_query($link, $querySubastasDisponibles); 
		//por cada subasta disponible controlo si pasaron los 3 dias
		while ($fila = mysqli_fetch_array($consultaSubastasDisponibles)) { 
		
			$semanaFin = date("Y-m-d", strtotime(date("Y-m-d") . "-3 days")); // me creo estas variables para restringir que las semana de las subastas a crear sean dentro de la ventana permitida
			if ($fila["fechaInicio"] <  $semanaFin) {
				$idSub = $fila["ID"];
				//Calcular el usuario ganador  de la subasta pidiendo el monto maximo pujado de la subasta. 
				$queryUsuarioGanador = "SELECT ID_Usuario, monto FROM pujas WHERE ID_subasta=$idSub ORDER BY monto DESC LIMIT 1  "; 
				$consultaUsuarioGanador = mysqli_query($link, $queryUsuarioGanador);
				// Si traigo un usuario ganador
				if (mysqli_num_rows($consultaUsuarioGanador) > 0) { 
					$fila = mysqli_fetch_array($consultaUsuarioGanador);
					$IDUsu = $fila['ID_Usuario'];
					echo '<script>alert("Subasta cerrada correctamente, con ganador ") </script>';
					//actualizo el ganador de la suasta
					$query3 = "UPDATE subastas SET ID_UsuarioGanador = $IDUsu WHERE ID = $idSub";
					$consultaquery3 = mysqli_query($link, $query3);								
					// le resto un credito al usuario que gano la subasta
					$queryCredito = "SELECT creditos FROM usuario WHERE ID=$IDUsu ";  
					$consultaCredito = mysqli_query($link, $queryCredito);
					$filaCredito = mysqli_fetch_array($consultaCredito);
					echo "credito actual del usu",$filaCredito["creditos"];
					$credAct=($filaCredito["creditos"]-1);
					echo "credito descontado:",$credAct;
					$queryCreditosUsuario = "UPDATE usuario SET creditos = $credAct WHERE ID=$IDUsu ";  
					$consultaCreditosUsuario = mysqli_query($link, $queryCreditosUsuario);
				} else {
					echo '<script>alert("Subasta cerrada correctamente, Sin puja.Sin ganador")</script>';
				}
				// actualizo el estado de la subasta a no disponible
				$query = "UPDATE subastas SET estado = 'NO DISPONIBLE' WHERE ID = $idSub";
				$consulta = mysqli_query($link, $query);
			}
		}
	}
} ?>
<script>
	window.location = "listarSubastas.php"
</script>

</html>
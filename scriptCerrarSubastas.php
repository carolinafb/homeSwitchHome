<html>
<?php
session_start();
include 'conexion.php';
$link = conexion();
if (isset($_SESSION['nombre'])) { // si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
	if ($_SESSION['rol'] == 'ADMINISTRADOR') {
		// me traigo todas las subastas disponibles
		$querySubastasDisponibles = "SELECT * FROM subastas WHERE estado = 'DISPONIBLE' ";
		$consultaSubastasDisponibles = mysqli_query($link, $querySubastasDisponibles);
		//por cada subasta disponible controlo si pasaron los 3 dias
		while ($fila = mysqli_fetch_array($consultaSubastasDisponibles)) {

			$diaCierre = date("Y-m-d", strtotime(date("Y-m-d") . "-3 days")); // me creo estas variables para restringir que las semana de las subastas a crear sean dentro de la ventana permitida
			if ($fila["fechaInicio"] <  $diaCierre) {
				$idSub = $fila["ID"];
				//Me traigo la lista de usuarios qe pujaron ordenados descendientemente para calcular
				//el ganador  de la subasta controlando que posea creditos.
				$queryUsuariosPujas = "SELECT ID_Usuario, monto FROM pujas WHERE ID_subasta=$idSub ORDER BY monto DESC   ";
				$consultaUsuariosPujas = mysqli_query($link, $queryUsuariosPujas);
				// Si traigo un usuario ganador
				$encontroGanador = false; // variable e corte booleanda para dejar de buscar usuarios que cumplan las condiciones
				//para ganar las subastas
				while (($filaPuja = mysqli_fetch_array($consultaUsuariosPujas)) and (!$encontroGanador)){
					$IDUsu = $filaPuja['ID_Usuario'];
					// me traio los datos del usuario y actualizo el ganador de la suasta
					$queryCredito = "SELECT creditos FROM usuario WHERE ID=  $IDUsu   ";
					$consultaCredito = mysqli_query ($link, $queryCredito);
					$filaCredito = mysqli_fetch_array ($consultaCredito);
					echo "credito actual del usu", $filaCredito ["creditos"];
					if ($filaCredito ['creditos'] > 0) {
						$credAct = ($filaCredito ["creditos"] - 1);
						$query3 = "UPDATE subastas SET ID_UsuarioGanador=$IDUsu WHERE ID=$idSub  ";
						$consultaquery3 = mysqli_query ($link, $query3);
						$queryCreditosUsuario = "UPDATE usuario SET creditos =   $credAct WHERE ID=  $IDUsu   ";
						$consultaCreditosUsuario = mysqli_query ($link, $queryCreditosUsuario);
						$encontroGanador=true;
						echo '<script>alert("Subasta cerrada correctamente, con ganador ") </script>';
					} else {
					echo '<script>alert("usuario sin creditos") </script>';
					}
				}
			if (!$encontroGanador) {
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
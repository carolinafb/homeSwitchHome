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
				$idProp= $fila['ID_propiedad'];

				$nombrePropiedad ="SELECT nombre FROM `propiedades` WHERE ID = $idProp";
				$querynombre = mysqli_query($link,$nombrePropiedad);
				$filaNombre = mysqli_fetch_array($querynombre);
				$nombreProp = $filaNombre['nombre'];

				$domingo = date("Y-m-d",strtotime(date($fila['semana'])."+ 6 day"));
				$lunes =date($fila['semana']);
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
					//echo "credito actual del usuario (Id de usuario: ",$IDUsu,")", $filaCredito ["creditos"];

					$nombreUsuario="SELECT nombre, apellido FROM `usuario` WHERE id = $IDUsu";
					$queryUsuario = mysqli_query($link,$nombreUsuario);
					$filaUsuario = mysqli_fetch_array($queryUsuario);
					$nombreUsu = $filaUsuario['nombre'];
					$apellidoUsu = $filaUsuario['apellido'];

					if ($filaCredito ['creditos'] > 0) {
						$credAct = ($filaCredito ["creditos"] - 1);
						$query3 = "INSERT INTO `reservas`( `ID_propiedad`, `ID_usuario`, `fechaInicio`, `fechaFin`, `operacion`) VALUES ('$idProp','$IDUsu','$lunes','$domingo','SUBASTA') ";
						$consultaquery3 = mysqli_query ($link, $query3);
						$queryCreditosUsuario = "UPDATE usuario SET creditos =   $credAct WHERE ID=  $IDUsu   ";
						$consultaCreditosUsuario = mysqli_query ($link, $queryCreditosUsuario);
						$encontroGanador=true;

						echo "<script> alert('Subasta de la propiedad $nombreProp cerrada correctamente, con ganador $nombreUsu $apellidoUsu ') </script>";
					} else {
					//echo '<script>alert("usuario sin creditos") </script>';
					}
				}
			if (!$encontroGanador) {// si no encontro no hubo pujas entonces pasa a espera de hotsale


				$hotsale= "INSERT INTO `hotsales`( `ID_propiedad`, `estado`, `numeroSemana`, `lunes`, `domingo`) VALUES ('$idProp','ESPERA',{$fila['numeroSemana']},'$lunes','$domingo')";
				mysqli_query($link,$hotsale);
				echo "<script>alert('Subasta de la propiedad $nombreProp cerrada correctamente, sin ganador. Paso a disponible para Hotsale')</script>";
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

<!--<button type="button" onclick=" location.href='listarSubastas.php' " > Volver </button>
-->
</html>

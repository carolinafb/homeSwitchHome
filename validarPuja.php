<?php
session_start();
include "conexion.php";
$link = conexion();
$idUsu = $_SESSION['id'];
if (isset($_SESSION['nombre'])) {
	if ($_SESSION['rol'] == 'ESTANDAR' or $_SESSION['rol'] == 'PREMIUM') {
		$idSub = $_POST["idSubasta"];
		$idProp = $_POST["idPropiedad"];
		$monto = $_POST["montoPuja"];

		$query = "SELECT ID, ID_subasta, MAX(monto) FROM pujas WHERE ID_subasta=$idSub "; //El monto maximo pujado de la subasta.
		$consulta = mysqli_query($link, $query);

		$queryCreditosUsuario = "SELECT creditos FROM usuario WHERE ID=$idUsu "; //El monto maximo pujado de la subasta.
		$consultaCreditosUsuario = mysqli_query($link, $queryCreditosUsuario);
		//Controlo que el usuario tenga greditos suficientes para poder pujar
		if (mysqli_num_rows($consultaCreditosUsuario) > 0) { // Si traigo filas
			$fila4 = mysqli_fetch_array($consultaCreditosUsuario);
			if ($fila4["creditos"] < 1) {
				echo "<script> alert ('No puede subasta, Creditos insuficientes');</script>	";
			} else {


				if (mysqli_num_rows($consulta) > 0) { // Si traigo filas
					$fila = mysqli_fetch_array($consulta);
					if ($fila['MAX(monto)'] != NULL) { //Si hay puja en esa subasta
						if ($fila['MAX(monto)'] < $monto) { // comparo con el monto maximo pujado
							$query2 = "INSERT INTO pujas (ID_subasta,ID_usuario,monto) VALUES ('$idSub','$idUsu','$monto')";
							$consulta2 = mysqli_query($link, $query2);
							echo "<script> alert ('Su puja fue registrada correctamente');</script>";
						} else {
							echo "<script> alert ('el monto ingresado debe superar la puja maxima de la subasta');</script>";
							echo "<script> window.location=\"pujar.php?idProp=$idProp&idSub=$idSub\"</script>";
						}
					} else { // si NO hay pujas en esa subasta
						$queryPrecioBase = "SELECT ID_propiedad, precioBase FROM subastas WHERE ID_propiedad = $idProp";
						$consultaPrecioBase = mysqli_query($link, $queryPrecioBase);
						$fila2 = mysqli_fetch_array($consultaPrecioBase);
						if ($fila2['precioBase'] < $monto) { // comparo con el precio base
							$query2 = "INSERT INTO pujas (ID_subasta,ID_usuario,monto) VALUES ('$idSub','$idUsu','$monto')";
							$consulta2 = mysqli_query($link, $query2);
							echo "<script> alert ('Su puja fue registrada correctamente');</script>";
						} else {
							echo "<script> alert ('el monto ingresado debe superar el monto base de la subasta');</script>	";
							echo "<script> window.location=\"pujar.php?idProp=$idProp&idSub=$idSub\"</script>";
						}
					}
				}
			}
			echo '<script> window.location="listarSubastas.php"</script>';
		}
		// SACAR LOS ECHO Y AGREGAR IF PARA COMPARAR CON PRECIO BASE Y CAMBIAR EL ERROR DDETALLAS DEL INDEX

} else {
	echo '<script> window.location="index.php"</script>';
}}
?>

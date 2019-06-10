<?php
session_start();
if (isset($_SESSION['login'])) {
	include "conexion.php";
	$link = conexion();
	?>
<html>
	<body>


		<title>Subastas</title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
		<br/>
		<?php
		$query = "SELECT propiedades.nombre, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion,subastas.ID as ID_subasta, subastas.estado, subastas.precioBase, subastas.ID_propiedad as ID_propiedad, subastas.semana FROM `propiedades` INNER JOIN subastas ON propiedades.ID = subastas.ID_propiedad WHERE 1=1"; //consulta a la base con solo datos q necesito
		$consulta = mysqli_query($link, $query);
		if (mysqli_num_rows($consulta) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					<caption>
						<h3> Subastas </h3>
					</caption><!-- titulo -->
					<?php
					while ($fila = mysqli_fetch_array($consulta)) { ?>
						<!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
						<!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
						<?php if ($fila["estado"] == 'DISPONIBLE') { ?>
							<tr>
								<!-- Abro una fila -->
								<td>
									<!--abro una columna muestro la FOTO-->
									<br />
									<img src=<?php echo $fila["foto"] ?> width="200" height="200">
									<!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
									<br />
								</td>
								<td>
									<!--abro una columna y muestro todos los demas datos -->
									<strong><?php echo $fila["nombre"] ?></strong>
									<br /> <!-- salto de linea -->
									<br /> Pais:
									<?php echo $fila["pais"] ?>
									<br />
									Provincia:
									<?php echo $fila["provincia"] ?>
									<br />Ciudad:
									<?php echo $fila["ciudad"] ?>
									<br /> Precio base: $
									<?php echo $fila["precioBase"] ?>
									<br /> Semana a subastar:
									<?php echo $fila["semana"] ?>
									<br />

									<?php
									$idSubasta = $fila['ID_subasta'];
									$queryPujas = "SELECT max(pujas.monto) FROM pujas INNER JOIN subastas ON subastas.ID = pujas.ID_subasta WHERE pujas.ID_subasta =$idSubasta ";
									$consultaPujas = mysqli_query($link, $queryPujas);
									if (mysqli_num_rows($consultaPujas) > 0) {
										$filaPujas = mysqli_fetch_array($consultaPujas);
										if ($filaPujas["max(pujas.monto)"] != null) {
											?>
											Puja mayor: $<?php echo $filaPujas["max(pujas.monto)"];
														}
													} ?>
								</td>
								<!--cierro columna-->

								<td>
									<?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>
										<!-- <a href="cerrarSubasta.php?id=<?php echo $fila["ID_subasta"] ?>"> Cerrar Subasta </a>  -->
									<?php } else {
									if ($_SESSION['rol'] == 'ESTANDAR' or $_SESSION['rol'] == 'PREMIUM') { ?>
											<a href="pujar.php?idSub=<?php echo $fila["ID_subasta"] ?> & idProp= <?php echo $fila['ID_propiedad'] ?>"> Pujar </a>
										<?php }
								} ?>
								</td>
							</tr>

						<?php }
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->
				<?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>
					<a href="scriptCerrarSubastas.php"> correr script para cerrar subastas</a>
					<?php } ?>
				<center>
				<?php if ($fila == NULL) {
					echo " No hay mas subastas "; ?>
					<button type="button" onclick=" location.href='index.php' "> Volver </button>
				<?php }
			?>


			<?php }
		?>

		</body>

	<?php
} else {
	echo '<script> window.location="index.php"</script>';
}?></html>	
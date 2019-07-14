<?php
session_start();
if (isset($_SESSION['nombre'])) {
	include "conexion.php";
	$link = conexion();
	?>
<html>
<style> /*estilos*/
	  table {font-family: arial, sans-serif;border-collapse: collapse;}
	  td, th {text-align: center;padding: 5px;}
	  tr:nth-child(even) {background-color: #dddddd;}
	  </style>
<head>
	<div align = right><a href="cerrarSesion.php"> Cerrar sesion </a></div>
</head>
<body>
<?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>

		<title>Subastas Finalizadas</title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
		<br/>
		<?php
		//me traigo la info de las propiedades que tienen subastas junto a las subastas cerradas con ganador
		$query = "SELECT * FROM propiedades INNER JOIN reservas on reservas.ID_propiedad=propiedades.ID INNER join subastas on subastas.ID_propiedad= reservas.ID_propiedad WHERE subastas.estado='NO DISPONIBLE' AND subastas.numeroSemana=reservas.semana
		"; //consulta a la base con solo datos q necesito
		$consulta = mysqli_query($link, $query);
		if ($fila=mysqli_num_rows($consulta) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					<caption>
						<h3> Subastas cerradas con Ganador: </h3>
					</caption><!-- titulo -->
					<?php
					while ($fila = mysqli_fetch_array($consulta)) { ?>
						<!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
						<!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
						
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
							      
                                    $queryDatosGanador=" SELECT nombre, apellido FROM usuario WHERE ID={$fila ["ID_usuario"]}";
                                    $consultaDatosGanador = mysqli_query($link, $queryDatosGanador);
                                    $filaDatosGanador = mysqli_fetch_array($consultaDatosGanador); ?>
                                	 <?php echo "Ganador: ", $filaDatosGanador ["nombre"]," ", $filaDatosGanador ["apellido"];?>
									<br />  
									 <?php echo "Comprada por: ", $fila ["precio"]?>
                                    <br />  
                                    <?php   
                                    
                                 
                                            }?>
									
								</td>
								<!--cierro columna-->
							</tr>

						<?php 
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

        <?php //}?>

		<center>
					<?php
			 if ($fila == NULL) {
					echo " No hay mas subastas con ganador "; ?>
					
					<?php
				}?>
		</center>




		<?php
		//me traigo la info de las propiedades que tienen subastas junto a las subastas cerradas con ganador
		$query = "SELECT * FROM propiedades INNER JOIN hotsales on hotsales.ID_propiedad=propiedades.ID INNER join subastas on subastas.ID_propiedad=hotsales.ID_propiedad WHERE subastas.estado='NO DISPONIBLE' AND subastas.numeroSemana=hotsales.numeroSemana"; //consulta a la base con solo datos q necesito
		$consulta = mysqli_query($link, $query);
		if ($fila=mysqli_num_rows($consulta) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					<caption>
						<h3> Subastas cerradas sin Ganador: </h3>
					</caption><!-- titulo -->
					<?php
					while ($fila = mysqli_fetch_array($consulta)) { ?>
						<!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
						<!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
						
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
									<?php echo "Ganador: Sin Ganador"?>
									
								</td>
								<!--cierro columna-->
							</tr>

						<?php 
				} }?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

        <?php //}?>

		<center>
					<?php
			 if ($fila == NULL) {
					echo " No hay mas subastas sin ganador "; ?>
					<button type="button" onclick=" location.href='index.php' "> Volver </button>
					<?php
				}?>
		</center>


		</body>

	<?php
    
} else {
    echo '<script> window.location="index.php"</script>';
    } 
}    ?>

 </html>

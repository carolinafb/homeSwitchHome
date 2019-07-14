<?php
session_start();
if (isset($_SESSION['nombre'])) {
	include "conexion.php";
	$link = conexion();
	?>
<html>
<head>
	<div align = right><a href="cerrarSesion.php"> Cerrar sesion </a></div>
</head>
<body>
<?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>

		<style> /*estilos*/
	  table {font-family: arial, sans-serif;border-collapse: collapse;}
	  td, th {text-align: center;padding: 5px;}
	  tr:nth-child(even) {background-color: #dddddd;}
	  </style>
		<title>Subastas Finalizadas</title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
		<br/>
		<?php
		$query = "SELECT propiedades.nombre, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion,subastas.ID as ID_subasta, subastas.estado, subastas.precioBase, subastas.ID_propiedad as ID_propiedad, subastas.semana FROM `propiedades` INNER JOIN subastas ON propiedades.ID = subastas.ID_propiedad AND subastas.estado='NO DISPONIBLE'"; //consulta a la base con solo datos q necesito
		$consulta = mysqli_query($link, $query);
		if ($fila=mysqli_num_rows($consulta) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					<caption>
						<h3> Subastas cerradas: </h3>
					</caption><!-- titulo -->
					<?php
					while ($fila = mysqli_fetch_array($consulta)) { ?>
						<!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
						<!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
						<?php if ($fila["estado"] == 'NO DISPONIBLE') { ?>
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
                                    $semana=date('W', strtotime($fila["semana"]));
                                    echo "numero de semana para la demo: ",$semana;
									$queryGanador = "SELECT ID_Usuario FROM reservas INNER JOIN subastas ON subastas.ID_propiedad = reservas.ID_propiedad WHERE {$fila["ID_propiedad"]}=subastas.ID_propiedad AND $semana=subastas.numeroSemana ";
                                    $consultaGanador = mysqli_query($link, $queryGanador);
									if (mysqli_num_rows($consultaGanador) > 0) {
                                        $filaGanador = mysqli_fetch_array($consultaGanador);
                                            $queryDatosGanador=" SELECT nombre, apellido FROM usuario WHERE ID={$filaGanador ["ID_Usuario"]}";
                                            $consultaDatosGanador = mysqli_query($link, $queryDatosGanador);
                                            $filaDatosGanador = mysqli_fetch_array($consultaDatosGanador); ?>
                                            <br /> <?php echo "Ganador: ", $filaDatosGanador ["nombre"]," ", $filaDatosGanador ["apellido"];?>
                                            <br />  
                                            <?php   
                                    }
                                    
                                    $queryGanador2 = "SELECT subastas.ID FROM subastas INNER JOIN hotsales ON subastas.ID_propiedad = hotsales.ID_propiedad  AND subastas.numeroSemana=hotsales.numeroSemana WHERE {$fila["ID_propiedad"]}=hotsales.ID_propiedad AND $semana=hotsales.numeroSemana ";
                                    $consultaGanador2 = mysqli_query($link, $queryGanador2);
                                        if (mysqli_num_rows($consultaGanador2) > 0) {?>
                                            <br /><?php echo "Ganador: Sin Ganador";}?>
                                    
								</td>
								<!--cierro columna-->
							</tr>

						<?php }
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

        <?php }?>

		<center>
					<?php
			 if ($fila == NULL) {
					echo " No hay mas subastas "; ?>
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

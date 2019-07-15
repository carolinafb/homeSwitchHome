<?php
session_start();
if (isset($_SESSION['nombre'])) {
	include "conexion.php";
	$link = conexion();
	?>
<html>
<head>
<style> /*estilos*/
	  table {font-family: arial, sans-serif;border-collapse: collapse;}
	  td, th {text-align: center;padding: 5px;}
	  tr:nth-child(even) {background-color: #dddddd;}
	  </style>
	<div align = right><a href="cerrarSesion.php"> Cerrar sesion </a></div>

	<script type="text/javascript">
		function ConfirmDemo( idPropiedad, idHotsales) {
		//Ingresamos un mensaje a mostrar
		var mensaje = confirm("¿Desea confirmar la compra del hotsale ?");
		//Detectamos si el usuario acepto el mensaje
		if (mensaje) {
			alert("¡Compra confirmada!");
			document.location='comprarHotsale.php?idProp=' + idPropiedad + '&idHot=' + idHotsales;
		}
		//Detectamos si el usuario denegó el mensaje
		else {
		alert("¡Haz denegado la compra de hotsale!");  }
	}
	</script>





</head>
<body>
		
		<title>Hotsales </title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
        <br/>
        <caption><center>
						<h2>Hotsales </h2></center>
		</caption><!-- titulo -->
		<?php
		$query = "SELECT propiedades.ID as ID_propiedad ,propiedades.nombre, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion,hotsales.ID as ID_hotsales, hotsales.estado, hotsales.precio, hotsales.ID_propiedad as ID_propiedad, hotsales.lunes FROM `propiedades` INNER JOIN hotsales ON propiedades.ID = hotsales.ID_propiedad where hotsales.estado='HOTSALE'"; //consulta a la base con solo datos q necesito
		$consulta = mysqli_query($link, $query);
		if ($fila=mysqli_num_rows($consulta) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					
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
									<br /> Precio: $
									<?php echo $fila["precio"] ?>
									<br /> Semana a subastar:
									<?php echo $fila["lunes"] ?>
									<br /> ID Hotsales:
									<?php 
									
									$idProp=$fila["ID_propiedad"] ;
									$idHot=$fila["ID_hotsales"] ;
									echo $idHot ;?>
								</td>
								<!--cierro columna-->

								<td>
									<?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>
                                        <!--// aca va la linea de cerrar hotsale-->
										<a href="aceptarHotsale.php?ID=<?php echo $idHot?>"> Modificar... </a>
										
									<?php } else {
									if ($_SESSION['rol'] == 'ESTANDAR' or $_SESSION['rol'] == 'PREMIUM') { ?>
											<input type="button" onclick="ConfirmDemo( <?php echo $idProp?>, <?php echo $idHot ?>)" value="Comprar" />;
										<?php }
								} ?>
								</td>
							</tr>

						<?php 
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

		<?php }?>

		<center>
			</br>
			<?php
			 if ($fila == NULL) {
					echo " No hay mas hotsales "; ?>
					<button type="button" onclick=" location.href='index.php' "> Volver </button>
					<?php
				}?>
		</center>

		</body>

	<?php
} else {
	echo '<script> window.location="index.php"</script>';
}?></html>

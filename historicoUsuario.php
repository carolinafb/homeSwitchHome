<?php
    session_start();
    include "conexion.php";
    $link=conexion();
    if(isset($_SESSION['nombre'])){
		    if (($_SESSION['rol']=='ESTANDAR') or ($_SESSION['rol']=='PREMIUM')){
          $IDuser= $_SESSION['id'];

?>
<html>
<style> /*estilos*/
	  table {font-family: arial, sans-serif;border-collapse: collapse;}
	  td, th {text-align: center;padding: 5px;}
	  tr:nth-child(even) {background-color: #dddddd;}
</style>
	<head>
		<title> Mi Historico de Perfil </title>
        <left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a>
        <?php echo "Usuario: ",$_SESSION['nombre']," ",$_SESSION['apellido']; ?>
        </left>
	</head>
<body>
 
<h4><center> Mis Reservas </center> </h4>
		<?php
		$query = "SELECT propiedades.nombre,propiedades.precioDeSubasta,propiedades.precio, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion, reservas.precio, reservas.semana, reservas.operacion, reservas.fechaInicio, reservas.fechaFin FROM `propiedades` INNER JOIN reservas ON propiedades.ID = reservas.ID_propiedad WHERE reservas.ID_Usuario=$IDuser"; //consulta a la base con solo datos q necesito
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
									<br/>
									<br /> Semana :
									<?php echo $fila["fechaInicio"]," a ",$fila["fechaFin"] ?>
									<br />  Adquirida por:
                                    <?php echo $fila["operacion"] ?>
									<br />                                    
								</td>
								<!--cierro columna-->
							</tr>

						<?php 
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

        <?php }?>

		<center>
					<?php
			 if ($fila == NULL) {
					echo " No hay mas reservas ";
				}?>
		</center>

        <h4><center> Mis Pujas </center> </h4>
        <?php
        $queryPujas = "SELECT pujas.monto,subastas.precioBase,subastas.semana, propiedades.nombre, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion FROM `propiedades` INNER JOIN subastas ON propiedades.ID = subastas.ID_propiedad INNER JOIN pujas ON pujas.ID_subasta=subastas.ID WHERE pujas.ID_Usuario=$IDuser ORDER BY propiedades.ID
        "; //consulta a la base con solo datos q necesito
		$consultaPujas = mysqli_query($link, $queryPujas);
		if ($fila=mysqli_num_rows($consultaPujas) > 0) { ?>
			<!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
			<center>
				<!-- centro la tabla -->
				<table width="800">
					<!-- comienza la tabla -->
					<?php
					while ($filaPujas = mysqli_fetch_array($consultaPujas)) { ?>
						<!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
						<!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
							<tr>
								<!-- Abro una fila -->
								<td>
									<!--abro una columna muestro la FOTO-->
									<br />
									<img src=<?php echo $filaPujas["foto"] ?> width="200" height="200">
									<!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
									<br />
								</td>
								<td>
									<!--abro una columna y muestro todos los demas datos -->
									<strong><?php echo $filaPujas["nombre"] ?></strong>
									<br /> <!-- salto de linea -->
									<br /> Pais:
									<?php echo $filaPujas["pais"] ?>
									<br />
									Provincia:
									<?php echo $filaPujas["provincia"] ?>
									<br />Ciudad:
									<?php echo $filaPujas["ciudad"] ?>
									<br /> Precio base: $
									<?php echo $filaPujas["precioBase"] ?>
									<br /> Semana :
									<?php echo $filaPujas["semana"] ?>
									<br /> Monto Puja:       
                                    <?php echo $filaPujas["monto"] ?>
									<br />                               
								</td>
								<!--cierro columna-->
							</tr>

						<?php 
				} ?>
					<!-- fin del while -->
				</table> <!-- fin de tabla -->

        <?php }else{ ?>	
                <center> <?php echo " No hay mas pujas ";?> </center>
                <?php } ?>
				<button type="button" onclick=" location.href='index.php' "> Volver </button>
    
    
    
    
    	</body>





</body>
</html>
<?php } else { // si se quiso acceder pero no estoy logueado, me manda a login
  echo '<script> window.location="login.php"</script>';
}} ?>

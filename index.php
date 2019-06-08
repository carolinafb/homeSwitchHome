<?php
    session_start();
   include 'conexion.php';
   $link=conexion();

?> 
<head> </head>
	<title>Home Switch Home </title>
</head>
	
<body>
	<?php 
    	if(isset($_SESSION['login'])){// si la sesion esta iniciada muestra nombre, rol y el cerrar sesion
    ?>
    	<?php echo " Bienvenido ", $_SESSION['nombre']," eres usuario ",$_SESSION['rol'];?> 
        <div align="right"> 
       		<a href="cerrarSesion.php"> Cerrar sesion </a>
       	</div>	
	<?php }else{//si la sesion no esta iniciada que muestre el iniciar ?> 
			<div align="right">
				<a href="formularioderegistro.php">Registrarse</a>&nbsp|&nbsp 
				<a href="login.php">Iniciar sesion</a> 
			</div>	

	<?php }?>

	<center> <!-- esta es la imagen de la portada -->
			<div class='portada'><img src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" > </div> 
	</center>

	<?php 
    	if(isset($_SESSION['login'])){// si la sesion es un admin muestra el alta de propiedad
   			if($_SESSION['rol']== 'ADMINISTRADOR'){	
   	 ?>
    	<a href="altapropiedad.php"> Agregar propiedad </a>
    	<br/>
	<?php } } 
	if(isset($_SESSION['login'])){?>
	
	<a href="listarSubastas.php"> Lista de subastas </a>
	<?php }

	
//ACA COMIENZA EL CODIGO DE LA TABLA DE PROPIEDADES
	 $query="SELECT foto, nombre, precio,pais, provincia,ciudad,id,estado FROM `propiedades` WHERE 1=1";//consulta a la base con solo datos q necesito
     $consulta=mysqli_query($link, $query);
     if (mysqli_num_rows($consulta)>0) { ?> <!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->

				<center><!-- centro la tabla -->
					<table width="800"> <!-- comienza la tabla -->
						<caption><h3> PROPIEDADES </h3></caption><!-- titulo -->
						
<?php 
	     while ($fila=mysqli_fetch_array($consulta)){?> <!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
	    <!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
						<?php if( $fila["estado"]=="DISPONIBLE"){	?>
							<tr> <!-- Abro una fila -->
								<td> <!--abro una columna muestro la FOTO-->
									<br/> 
									<img src= <?php echo $fila["foto"] ?>  width=200 height="200" > <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
									<br/> 
								</td>
								<td> <!--abro una columna y muestro todos los demas datos -->
									<strong><?php echo $fila["nombre"] ?></strong>
									<br/> <!-- salto de linea -->
									<br/> 
									<?php echo $fila["pais"] ?>,
									<?php echo $fila["provincia"] ?>,
									<br/>
									<?php echo $fila["ciudad"] ?>
									<br/> 
								</td> <!--cierro columna-->
								<td><!--abro columna para mostrar el ver detalles -->
									<a href="propiedad.php?id=<?php echo $fila["id"] ?>"> Ver detalles</a> <!-- es una referencia a la vista de la propiedad -->
								</td>
							</tr>
					<?php }?>

	<?php } // Cierro el while?>
					</table> <!-- fin de tabla -->
				</center>
	<?php } //cierro el if ?>
</body>
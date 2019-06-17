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
    	if(isset($_SESSION['nombre'])){// si la sesion esta iniciada muestra nombre, rol y el cerrar sesion
    ?>

    <?php echo "Bienvenido ",$_SESSION['nombre']," ",$_SESSION['apellido']; ?>
    <?php echo " eres usuario ", $_SESSION["rol"]; ?>

        <div align="right">
          <?php if (($_SESSION["rol"] !== "ADMINISTRADOR")) {?>
            <a href="perfilUsuario.php"> Mi perfil </a>
          &nbsp|&nbsp <?php } ?>
          <a href="cerrarSesion.php"> Cerrar sesion </a>
        </div>

	<?php }else{//si la sesion no esta iniciada que muestre el iniciar ?>
    <div align="right">
      <a href="formularioderegistro.php">Registrarse</a>&nbsp|&nbsp
      <a href="login.php">Iniciar sesion</a>
    </div>

	<?php }?>

	<center> <!-- esta es la imagen de la portada -->
			<div class='portada'><a href='index.php'><img  src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" ></a> </div>
	</center>

	<?php
    	if(isset($_SESSION['nombre'])){// si la sesion es un admin muestra el alta de propiedad
   			if($_SESSION['rol']== 'ADMINISTRADOR'){
   	 ?>
   	 	<hr style="color: #000000;" />
    </br>
    <div align='center'>
          	<a href="altapropiedad.php"> Agregar propiedad </a>
      &nbsp|&nbsp
      		<a href="solicitudPaseUsuario.php"> Ver solicitud de pases de usuarios </a>
      &nbsp|&nbsp
          	<a href="verClientes.php" > Ver Listado de Clientes </a>
      &nbsp|&nbsp
            <a href="modificarTarifas.php"> Ver tarifas </a>
      &nbsp|&nbsp
      	<?php } }
      	if(isset($_SESSION['nombre'])){?>

      	<a href="listarSubastas.php"> Lista de subastas </a>
      </br>
      </br>
      	<hr style="color: #000000;" />
      <?php } ?>
    </div>
  <!-- Codigo del input buscar -->
 <table align ='center'>
    <tr>
      <td>
        <form name='buscarPropiedadPorNombre' action='index.php' method="GET" >
          <fieldset><legend>Buscar por Nombre</legend>
            <table>
              <tr>
                <td><input type= 'text' name='porNombre' id='porNombre' style="width: 100%"></td>
                <td><button type="submit" > Buscar </button></td>
              </tr>
            </table>
          </fieldset>
       </form>
     </td>

     <td>
       <form name='buscarPropiedadPorCiudad' action='index.php' method="GET" >
         <fieldset><legend>Buscar por Ciudad</legend>
            <table>
              <tr>
                <td>
                  <select name="porCiudad">
                    <?php $ciudades ="SELECT ciudad FROM `propiedades`";
                          $queryCiudades= mysqli_query($link,$ciudades);
                          while ($fila=mysqli_fetch_array($queryCiudades)){ ?>
                            <option><?php echo $fila['ciudad'] ?></option>
                          <?php } ?>
                </td>
                <td><button type="submit" > Buscar </button></td>
              </tr>
            </table>
         </fieldset>
       </form>
     </td>

    </tr>
 </table>
<!-- Fin Del input de busqueda -->
  <?php

// COMIENZA EL CODIGO DE LA TABLA DE PROPIEDADES

      $query="SELECT * FROM `propiedades`WHERE 1=1" ; // Colsulta sin condiciones

      if(isset($_GET['porNombre'])){// en caso de que en se ingreso busqueda por nombre
        $query.=' AND nombre LIKE "%'.$_GET['porNombre'].'%"';
      }
      if(isset($_GET['porCiudad'])){ //en caso de que en se ingreso busqueda por Ciudad
        $query.=' AND ciudad LIKE "%'.$_GET['porCiudad'].'%"';
      }
      //orden
      if((isset($_GET['nombre']))||(isset($_GET['ciudad']))){//si se realizo pedido de orden
        if(isset($_GET['nombre'])){ // si se pidio orden por nombre
          $query.=" ORDER BY `propiedades`.`nombre` ASC";
        }else {
          // si se pidio orden por ciudad
            $query.= " ORDER BY `propiedades`.`ciudad` ASC";
        }
      }// fin del orden

     $consulta=mysqli_query($link, $query);
     if (mysqli_num_rows($consulta)>0) { ?> <!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->

				<center><!-- centro la tabla -->
					<table width="800"> <!-- comienza la tabla -->
						<caption><h3> PROPIEDADES </h3></caption><!-- titulo -->
              <tr>
                <th>   </th>
                <td>Ordenar por: <a href="index.php?nombre='1'">Nombre</a>  |  <a href="index.php?ciudad='1'">Ciudad</a></td><!-- para ordenar alfabeticamente por titulo -->
              </tr>
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
              									<?php echo "Pais: ", $fila["pais"] ?>,
                                <br/>
              									<?php echo "Provincia: ",$fila["provincia"] ?>,
              									<br/>
              									<?php echo "Ciudad: ", $fila["ciudad"] ?>
              									<br/>
              								</td> <!--cierro columna-->
              								<td><!--abro columna para mostrar el ver detalles -->
              									<a href="propiedad.php?id=<?php echo $fila["ID"] ?>"> Ver detalles</a> <!-- es una referencia a la vista de la propiedad -->
              								</td>
              							</tr>
              					<?php }?>

              	<?php } // Cierro el while?>
					</table> <!-- fin de tabla -->
				</center>
	<?php }else{
    if(isset($_GET['porNombre'])){
      echo '<script> alert ("No existe propiedad con ese nombre");</script>';
  		echo '<script> window.location="index.php"; </script>';
    }
  }?>
</body>

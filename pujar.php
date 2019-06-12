<?php
    session_start();
    include "conexion.php";
    $link=conexion();

    if(isset($_SESSION['nombre'])){
        if ($_SESSION['rol']== 'ESTANDAR' OR $_SESSION['rol']== 'PREMIUM' ){
            $idSubasta= $_GET["idSub"];
            $idPropiedad = $_GET["idProp"];

            ?>

            <html>
            <head>
 			<title>Puja</title>
	 		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
 			</br>
            </head>
            <?php
     // consulta para traerme la info de las propiedad
     $query="SELECT ID, foto, nombre, precio, pais, provincia,ciudad ,estado, descripcion, direccion FROM `propiedades` WHERE ID= $idPropiedad";//consulta a la base con solo datos q necesito
     $consulta=mysqli_query($link, $query);
     $datos= mysqli_fetch_row($consulta);

    // consulta para traerme la ultima puja de esa propiedad para mostrar la ultima puja
    echo $idPropiedad;
     $queryPuja="SELECT MAX(monto), subastas.ID_propiedad, subastas.semana FROM pujas INNER JOIN subastas WHERE pujas.ID_subasta=subastas.ID AND subastas.ID_propiedad=$idPropiedad" ;//El monto maximo pujado de la subasta.
     $consultaPuja=mysqli_query($link, $queryPuja);

     if (mysqli_num_rows($consultaPuja)>0) {// Si traigo filas
        $fila=mysqli_fetch_array($consultaPuja);
        if($fila['MAX(monto)'] != NULL){ //Si hay puja en esa subasta
            $monto=$fila['MAX(monto)'];
            echo 'monto max:';
            echo $monto;
            $semana= $fila['semana'];


         }else{
            $queryPrecioBase = "SELECT ID_propiedad,precioBase,semana FROM subastas  WHERE ID_propiedad = $idPropiedad";
            $consultaPrecioBase = mysqli_query ($link,$queryPrecioBase);
            $fila2=mysqli_fetch_array($consultaPrecioBase);
           $monto=$fila2['precioBase'];
           echo 'precio base:';
           echo $monto;
           echo 'id prop:';
           echo $fila2['ID_propiedad'];
           $semana= $fila2['semana'];
       }
   }


?>

    <html>
        <body>
			<h1 align="center"> <?php echo $datos[2] ?> </h1><!-- titulo -->

            <div style="width:100%;display: flex;">
                <div style="width:30%;">
                     <img src= <?php echo $datos[1] ?>  width="200" height="200" >
                </div>
                <div style="width:70%;">
                       <b>Descripcion: </b>
                       <p>	<?php echo $datos[8] ?> </p>
                       </br>
                       <b>Dirección: </b>
                       <?php echo $datos[9] ?>
                       </br>
                       <b>Ciudad: </b>
                       <?php echo $datos[6] ?>
                       </br>
                       <b>Provincia: </b>
                       <?php echo $datos[5] ?>
                       </br>
                       <b>Pais: </b>
                       <?php echo $datos[4] ?>
                       </br>
                       <b> Semana a subastar:</b>
							<?php echo $semana ?>
			    </div>
            </div>
						<form name='ingresarPuja' action='ValidarPuja.php' method="POST">
						<fieldset>
                        <legend> <h1> Pujar:</h1>	</legend>
	    	 			<table>
                        <tr>
                        <td>Monto a superar: <?php echo $monto ?> </td>
                        </tr>
    		  		    <tr>
	    	  			    <td>Monto de puja: </td>
    	  			        <td><input type= 'number' min='0' name='montoPuja' id='montoPuja' required/></td>
    	  			    </tr>
                            <td><input type="hidden" value="<?php echo $idSubasta ?>" name="idSubasta" id="idSubasta"></td>
                            <td><input type="hidden" value="<?php echo $idPropiedad ?>" name="idPropiedad" id= "idPropiedad"></td>
                      	</table>
							<input type="submit" value="Pujar"> <!--boton-->
							</fieldset>
						</form>

            </body>
    </html>
<?php
    }
	}else{
		 echo '<script> window.location="index.php"</script>';
    }
?>

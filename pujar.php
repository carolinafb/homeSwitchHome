<?php
    session_start();
    include "conexion.php";
    $link=conexion();
   
    if(isset($_SESSION['login'])){
        if ($_SESSION['rol']== 'USUARIO'){        
            $idSubasta= $_GET["idSub"];
            $idPropiedad = $_GET["idProp"];
            ?>

            <html>
            <head>
 			<title>Puja</title>
	 		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
 			</br>
            </head>
            <body>
						<form name='ingresarPuja' action='ValidarPuja.php' method="POST">
						<fieldset>
                        <legend> <h1> Ingresar monto de puja:</h1>	</legend>
	    	 			<table>
    		  		    <tr>
	    	  			    <td>Monto: </td>
    	  			        <td><input type= 'number' min='0' name='montoPuja' id='montoPuja' required/></td>
    	  			    </tr>
                            <td><input type="hidden" value="<?php echo $idSubasta ?>" name="idSubasta" id="idSubasta"></td>   
                            <td><input type="hidden" value="<?php echo $idPropiedad ?>" name="idPropiedad" id= "idPropiedad"></td>                    
                      	</table>
							<input type="submit" value="Pujar"> <!--boton-->
							</fieldset>
						</form>

            </html>



<?php	
    }
	}else{
		 echo '<script> window.location="index.php"</script>';
    }	
?>
<?php	
 	include "conexion.php";
	 $link=conexion();
	 session_start();
	 $query="SELECT ID, foto, nombre, precio, pais, provincia,ciudad ,estado, descripcion, direccion FROM `propiedades` WHERE ID= $idPropiedad";//consulta a la base con solo datos q necesito
     $consulta=mysqli_query($link, $query);
     $datos= mysqli_fetch_row($consulta);

	 if(isset($_SESSION['login'])){
	 	if($_SESSION['rol']== 'ADMINISTRADOR'){
?>
</html>

<?php	 	}

	 }



?>


	<html>


					<head>
 						<title>HomeSwitchHome</title>
	 					<left> 
   	 	 			 <a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a>
 	 					</left>
 							</br>

					</head>
<body>
				<caption><h1><div align="center"> <?php echo $datos[2] ?> </div></h1></caption><!-- titulo -->
	
						<tr>
						<br> 
							<img src= <?php echo $datos[1] ?>  width="300" height="300" > 
							<hr style="color: #000000;" />
						<td>
							<br> <b>Descripcion: </b>
							<p>
								<?php echo $datos[8] ?> 
								<hr style="color: #000000;" />
							</p>
							</br>	
						</td>
						<tr>
						<td><br> <b>Dirección: </b>
								<?php echo $datos[9] ?> 
								<hr style="color: #000000;" />
							</br></td>	
						</tr>
						<tr>
						<td><br> <b>Ciudad: </b>
								<?php echo $datos[6] ?> 
								<hr style="color: #000000;" />
							</br></td>	
						</tr>
							<tr>
						<td><br> <b>Provincia: </b>
								<?php echo $datos[5] ?> 
								<hr style="color: #000000;" />
							</br></td>	
						</tr>
						<tr>
						<td><br> <b>Pais: </b>
								<?php echo $datos[4] ?> 
								<hr style="color: #000000;" />
							</br></td>	
						</tr>
						<tr>
						<td><br> <b>Precio: $ </b>
								<?php echo $datos[3] ?> 
								<hr style="color: #000000;" />
							</br></td>	
						</tr>

						</tr>
						
</body>
 </html>						            
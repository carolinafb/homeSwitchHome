<?php
    session_start();
      include "conexion.php";
	  $link=conexion();
    if(isset($_SESSION['nombre'])){
        if($_SESSION['rol']== 'ADMINISTRADOR'){

					 
					 ?>
				<html>
					<head>
 						<title>Alta Propiedad</title>
	 					<left>
   	 	 			 <a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a>
 	 					</left>
 							</br>
					</head>
					<body>
						<form name='ingresar' action='ingresarPropiedad.php' method="POST">
						<fieldset>
	    	 			<legend> <h1> Ingresar datos de la propiedad:</h1>	</legend>
						<table>
    		  		<tr>
	    	  			<td>Nombre: </td>
    	  			<td><input type= 'text' name='nombrePropiedad' id='nombrePropiedad' style="width:417;" required/></td>
    	  			</tr>
          		<tr>
	    	  			<td>Descripcion: </td>
    	  				<td><textArea type= 'text' name='descripcionPropiedad' id='descripcionPropiedad' rows="10" cols="50" required></textArea></td>
    	  			</tr>
          		<tr>
	    	  			<td>Precio: </td>
    	  				<td><input type= 'number' name='precioPropiedad' id='precioPropiedad' style="width:417;" required/></td>
							</tr>
								<tr>
								<td>Direccion: </td>
								<td><input type= 'text' name='direccionPropiedad' id='direccionPropiedad' style="width:417;" required/></td>
							</tr>
								<tr>
								<td>Pais: </td>
								<td><input type= 'text' name='paisPropiedad' id='paisPropiedad' style="width:417;" required/></td>
							</tr>
								<tr>
								<td>Provincia: </td>
								<td><input type= 'text' name='provinciaPropiedad' id='provinciaPropiedad' style="width:417;" required/></td>
							</tr>
							<!--	<tr>
								<td>Estado: </td>
								<td>
											<select name='estadoPropiedad'  type= 'text' required>
													<option value="RESERVA DIRECTA ">Reserva Directa</option>
													<option value="SUBASTA">Subasta</option>
													<option value="ESPERANDO HOTSALE">Esperando Hotsale</option>
													<option value="HOTSALE">Hotsale</option>
											</select>
										</td>
							</tr>-->
							<tr>
								<td>Ciudad: </td>
								<td><input type="text" name="ciudadPropiedad" id='ciudadPropiedad'   style="width:417;" required/> </td>
							</tr>
							<tr>
								<td>Foto: </td>
								<td><input type='text' name='fotoPropiedad' id='fotoPropiedad'  style="width:417;" required/></td>
								</tr>

							</table>
							</br>
							<input type="submit" value="Ingresar"> <!--boton-->
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

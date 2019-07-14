<?php
session_start();
include "conexion.php";
$link=conexion();

$idUsuario= $_SESSION['id'];



$query= "SELECT * FROM `usuario` WHERE id= $idUsuario";
$consulta=mysqli_query($link, $query);
$datos= mysqli_fetch_array($consulta);

if(isset($_SESSION['nombre'])){
	if(($_SESSION['rol']== 'ESTANDAR') || ($_SESSION['rol']== 'PREMIUM')){

		?>	
		<!DOCTYPE html>
		<html>
		<head>
			<title>HomeSwitchHome</title>
			<left>
				<a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a>
			</left>

			<style>
			table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 50%;
			}

			td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
			}

			tr:nth-child(even) {
				background-color: #dddddd;
			}
			</style>
		</head>
		<body>
			<form name='modificarPerfil' action='modificarDatosDePerfil.php' method="POST">
				
				<fieldset><legend><strong>Modificar Datos del Perfil </strong></legend>
					<table>
						<tr>

							<th>Nombre: </th>
							<td><input type= 'text' name='nombreUsuario' id='nombreUsuario' value = '<?php echo $datos['nombre'] ?>' style="width: 100%" required/>
							</td>
						</tr>
						<tr>
							<th> Apellido: </th>
							<td><input type= 'text' name='apellidoUsuario' id='apellidoUsuario' value = '<?php echo $datos['apellido'] ?>' style="width: 100%" required/>
							</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td><input type= 'text' name='email' id='email' value= '<?php echo $datos['email'] ?>' required/></td>

						</tr>
						<tr>
							<th> Fecha de Nacimiento: </th>
							<td> <input type="date" name="fechaNacimiento" value= '<?php echo $datos['fechaNacimiento'] ?>'> </td>
						</tr>
						<tr>
							<th>Nueva Contraseña</th>
							<td><input type= 'password' name='contrasenaNueva' id='contrasenaNueva'  title="Minimo 6 caracteres, letras mayusculas y minisculas y por lo menos un numero o simbolo"></td>
						</tr>
						<tr>
							<th>Pais: </th>
							<td>
								<select name='pais' id='pais' required>
									<option>Argentina</option>
									<option>Bolivia</option>
									<option>Brasil</option>
									<option>Chile</option>
									<option>Colombia</option>
									<option>Costa Rica</option>
									<option>Cuba</option>
									<option>Ecuador</option>
									<option>El Salvador</option>
									<option>Guatemala</option>
									<option>Honduras</option>
									<option>México</option>
									<option>Nicaragua</option>
									<option>Panamá</option>
									<option>Paraguay</option>
									<option>Puerto Rico</option>
									<option>Perú</option>
									<option>República Dominicana</option>
									<option>Uruguay</option>
									<option>Venezuela</option>
								</select>
							</td>
						</tr>
						
						<tr><th>Datos de tarjeta</th></tr>

						<tr>
							<th>Numero de tarjeta: </th>				
							<td><input type= 'number' name='numerotarjeta' id='numerotarjeta' value='<?php echo $datos['numeroTarjeta'] ?>' required/></td>
						</tr>
						<tr>
							<th>Nombre y apellido </th>
							<td><input type="text" name="nomYape" id="nomYape" value='<?php echo $datos['nombreYapellidoDeTarjeta'] ?>' required/></td>
						</tr>
						<tr>
							<th>Fecha de expiracion</th> 
							<td><input type="Month" name="expiracion" id="expiracion" value='<?php echo $datos['fechaExpiracion'] ?>' required/></td>

						</tr>
						<tr>
							<th>Codigo de seguridad</th>
							<td><input type="number" name="codSeg" id="codSeg" value='<?php echo $datos['codigoSeguridad'] ?>' required/></td>

						</tr>
						<tr>
							<th>Ingrese su contraseña actual para confirmar los cambios</th>
							<td><input type= 'password' name='contrasenaActual' id='contrasenaActual' title="Minimo 6 caracteres, letras mayusculas y minisculas y por lo menos un numero o simbolo" required/ ></td>

						</tr>
						<tr>
							<td><input  type="submit" value="Confirmar Cambios" onclick="validarform()"></td>
						</tr>

					</table>
				</fieldset>

			</form>
			  <br><button type="button" onclick=" location.href='perfilUsuario.php' " > Volver </button>
		</body>
		</html>
		<?php

	}

}

?>
 <?php
    session_start();
    include "conexion.php";
    $link=conexion();
    $idCliente= $_GET['id'];
    if(isset($_SESSION['nombre'])){
		    if ($_SESSION['rol']=='ADMINISTRADOR'){
?>
<html>
	<head>
		<title>Detalle del Cliente</title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
		<h1 align ='center'> Detalle de Cliente </h1>
		
	</head>
	    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
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
	<body>

		<?php
			$query="SELECT * FROM `usuario` WHERE  ID = $idCliente ";//consulta a la base con solo datos q necesito
    		$consulta=mysqli_query($link, $query);
    		$persona= mysqli_fetch_array($consulta);

		?>
		<table>
			<tr>
				<td>Nombre </td>
				<td>Apellido  </td>
				<td>Fecha de Nacimiento </td>
				<td> Pais</td>
				<td> Email</td>
				<td> Numero de Tarjeta</td>
				<td> Nombre y Apellido de Tarjeta</td>
				<td> Fecha de Expiracion </td>
				<td> Fecha de Registro </td>
			</tr>
		<tr>
				<td><?php echo $persona["nombre"]   ?> </td>
				<td><?php echo $persona["apellido"]  ?></td>
				<td><?php echo $persona["fechaNacimiento"]   ?></td>
				<td><?php echo $persona["pais"]   ?></td>
				<td><?php echo $persona["email"]  ?></td>
				<td><?php echo $persona["numeroTarjeta"]   ?></td>
				<td><?php echo $persona["nombreYapellidoDeTarjeta"]  ?></td>
				<td><?php echo $persona["fechaExpiracion"]  ?></td>
				<td><?php echo $persona["fechaRegistro"]  ?></td>

			</tr>
			</table>
			 <button type="button" onclick=" location.href='verClientes.php' " > Volver </button>

		<?php
			}
		}
		?>
		</html>
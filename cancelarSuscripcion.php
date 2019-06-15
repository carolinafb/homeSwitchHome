<?php
session_start();
include "conexion.php";
$link=conexion();
if(isset($_SESSION['nombre'])){
	if (($_SESSION['rol']=='ESTANDAR') or ($_SESSION['rol']=='PREMIUM')){
		?>
		<html>
		<head>
			<title>Cancelar la Suscripcion</title>
			<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
			<h1 align ='center'> Cancelar la Suscripcion </h1>

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
			<form name='bajaSuscripcion' action='bajaSuscripcion.php' method="POST" >

				<table>
					<tr>
						<th>Lo extrañaremos</th>

					</tr>
					<tr>
						<th> A continuacion, cuentenos el motivo de su cancelacion </th>

						<tr> <td><textArea type= 'text' name='descripcionDeCancelacion' id='descripcionDeCancelacion' style="width:600px; height:200px;" required></textArea></td>
						</tr>
					</tr>

				</table>
				<td><button type="submit" > Confirmar </button></td>
				<button type="button" onclick=" location.href='perfilUsuario.php' " > Cancelar </button>
			</form>


		</body>


		<?php


	}
}
?>
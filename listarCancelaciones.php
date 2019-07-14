<?php
session_start();
include 'conexion.php';
$link=conexion();
?>
<html>

<head> 
	<title>Home Switch Home </title>

</head>
<center> <!-- esta es la imagen de la portada -->
	<div class='portada'><a href='index.php'><img  src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" ></a> </div>
</center>
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

<?php
if(isset($_SESSION['nombre'])&&($_SESSION['rol']== 'ADMINISTRADOR')){ 
	$queryCancelaciones= "SELECT usuario.nombre, usuario.apellido, usuario.email , usuario.ID as userID, cancelaciones.ID_usuario, cancelaciones.motivoCancelacion, cancelaciones.ID as cancelID FROM usuario INNER JOIN cancelaciones WHERE usuario.ID= cancelaciones.ID_usuario";
	$consultaCancelaciones = mysqli_query($link, $queryCancelaciones);
	if (mysqli_num_rows($consultaCancelaciones) > 0) { 

		while ($datos = mysqli_fetch_array($consultaCancelaciones)) {
			?>

			<body>
				<h2>Listado de Cancelaciones</h2>
				<table>
					<tr>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Email</td>
						<td>Descripcion</td>
					</tr>
					<tr>
						<td><?php echo $datos['nombre']?></td>
						<td><?php echo $datos['apellido']?></td>
						<td><?php echo $datos['email']?></td>
						<td><?php echo $datos['motivoCancelacion']?></td>
					</tr>
				</table>	



		
			<?php }}else echo 'No hay datos para mostrar';}  ?>
				<button type="button" onclick=" location.href='index.php' "> Volver </button>
				</body>

			</html>
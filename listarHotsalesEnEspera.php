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
//traer datos de Hotsale
$query= "SELECT * FROM hotsales WHERE estado='ESPERA'";
$consulta=mysqli_query($link, $query);
if (mysqli_num_rows($consulta) > 0) {
	while ($datos = mysqli_fetch_array($consulta)) {
		$query2= "SELECT nombre FROM propiedades WHERE ID = {$datos['ID_propiedad']}";
		$consulta2=mysqli_query($link, $query2);
		$nombreP =  mysqli_fetch_array($consulta2);
			?>

			<body>
				<h2>Listado de Hotsales en Espera</h2>
				<table>
					<tr>
						<td>Nombre de la Propiedad</td>
						<td>Precio</td>
						<td>Estado</td>
						<td>Semana de reserva</td>
						<td>Habilitar Hotsale</td>
					</tr>
					<tr>
						<td><?php echo $nombreP['nombre']?></td>
						<td><?php echo $datos['precio']?></td>
						<td><?php echo $datos['estado']?></td>
						<td><?php echo $datos['lunes']?></td>
						<td><a href="aceptarHotsale.php?idHotsale=<?php echo $datos['ID'] ?>">Habilitar Hotsale</a></td>
						
					</tr>
				</table>	



		
			<?php }
}else{
	echo "No hay datos para mostrar";
	//botón de volver

}
} ?>
<button type="button" onclick=" location.href='index.php' "> Volver </button>
				</body>

			</html>
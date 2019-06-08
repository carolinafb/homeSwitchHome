 <?php
    session_start();
    $id = $_SESSION["ID"];
//VER SI ME TRAIGO EL ID O NO DE LA SESION    
    include "conexion.php";
    $link=conexion();
    if(isset($_SESSION['login'])){
		if (($_SESSION['rol']=='ESTANDAR') or ($_SESSION['rol']=='PREMIUM')){ 
?>
<html>
	<head> 
		<title> Mi Perfil </title>
		<div align="right"> 
       		<a href="cerrarSesion.php"> Cerrar sesion </a>
       	</div>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
	</head>
	<body>
		<?php
		$query="SELECT nombre, apellido, email, rol,fechaNacimiento,numeroTarjeta,pais FROM `usuario` WHERE ID = $id";
		$consulta=mysqli_query($link, $query);
		     ?>

	</body>



</html>
<?php }
}else{
echo '<script> window.location="login.php"</script>'; // si se quiso acceder pero no estoy logueado, me manda a login
}
?>
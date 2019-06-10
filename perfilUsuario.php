 <?php
    session_start();
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
    <h1><center> Mi Perfil </center> </h1>

    <div>
      <h4> Datos Personales </h4>
      <?php echo "Nombre: ", $_SESSION["nombre"];?>
      <hr/>
      <?php  echo "Apellido: ", $_SESSION ["apellido"] ; ?>
      <hr/>
      <?php echo "Email: ", $_SESSION["email"];?>
      <hr/>
      <?php echo "Fecha Nacimiento: ", $_SESSION["fechaNacimiento"];?>
      <hr/>
      <?php echo "Pa&iacutes de Recidencia: ", $_SESSION["pais"];?>
      <hr/>
      <?php echo "Usuario: ", $_SESSION["rol"];?>
  </div>

    <br/>

    <div>
      <h4> Datos de Tarjeta </h4>
      <?php echo "&Uacuteltimos d&iacutegitos de Tarjeta: XXXX XXXX XXXX ", substr($_SESSION["numeroTarjeta"], -4); ?>
      <hr/>
      <?php echo "Fecha de Expiracion: ", $_SESSION["expiracion"] ; ?>
    </div>
	</body>



</html>
<?php }
}else{// si se quiso acceder pero no estoy logueado, me manda a login
echo '<script> window.location="login.php"</script>';
}
?>

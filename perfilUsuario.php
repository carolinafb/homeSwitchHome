 <?php
    session_start();
    include "conexion.php";
    $link=conexion();
    if(isset($_SESSION['nombre'])){
		    if (($_SESSION['rol']=='ESTANDAR') or ($_SESSION['rol']=='PREMIUM')){
          $IDuser= $_SESSION['id'];
       
?>
<html>
	<head>
		<title> Mi Perfil </title>
		<div align="right">
       		<a href="cerrarSesion.php"> Cerrar sesion </a>
         <br> <a href="modificarPerfil.php"> Modificar Perfil </a> </br>
       	</div>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
	</head>
	<body>
    <h1><center> Mi Perfil </center> </h1>   

       <div>
         <h4> Datos Personales </h4>
         <?php echo "Nombre: ", $_SESSION["nombre"]; ?>
         <hr />
         <?php echo "Apellido: ", $_SESSION["apellido"]; ?>
         <hr />
         <?php echo "Email: ", $_SESSION["email"]; ?>
         <hr />
         <?php echo "Fecha Nacimiento: ", $_SESSION["fechaNacimiento"]; ?>
         <hr />
         <?php echo "Pa&iacutes de Recidencia: ", $_SESSION["pais"]; ?>
         <hr />
         <?php echo "Usuario: ", $_SESSION["rol"]; ?>
         <?php
          $tarifas = "SELECT * FROM `tarifas` ";
          $consulta = mysqli_query($link, $tarifas);
          ?>
         <?php if ($_SESSION["rol"] == "ESTANDAR") {
            $tarifas = "SELECT precio FROM `tarifas` WHERE titulo = 'Estandar'";
            $consulta = mysqli_query($link, $tarifas);
            $fila = mysqli_fetch_array($consulta);
            echo "$", $fila["precio"];
          } else if ($_SESSION["rol"] == "PREMIUM") {
            $tarifas = "SELECT precio FROM `tarifas` WHERE titulo = 'Premium'";
            $consulta = mysqli_query($link, $tarifas);
            $fila = mysqli_fetch_array($consulta);
            echo "$", $fila["precio"];
          } ?>

         <!--le pongo el enlace para solicitar el pase de tipo de usario-->

         <a href="PedirPaseDesdeUsuario.php?idUser=<?php echo $IDuser ?>"> Solicitar cambio de suscripcion</a>
       </div>

       <br />

    <div>
      <h4> Datos de Tarjeta </h4>
      <?php echo "&Uacuteltimos d&iacutegitos de Tarjeta: XXXX XXXX XXXX ", substr($_SESSION["numeroTarjeta"], -4); ?>
      <hr/>
      <?php echo "Fecha de Expiracion: ", $_SESSION["expiracion"] ; ?>
      <hr/>
    </div>
  <a href="cancelarSuscripcion.php"> Cancelar Suscripcion </a>  

  <br><button type="button" onclick=" location.href='index.php' " > Volver </button>
	</body>



     </html>
   <?php }
} else { // si se quiso acceder pero no estoy logueado, me manda a login
  echo '<script> window.location="login.php"</script>';
}
?>
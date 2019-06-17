<?php
      session_start();
      include 'conexion.php';
      $link=conexion();

      $nombre = $_POST['nombrePropiedad'];
      $descripcion=$_POST['descripcionPropiedad'];
      $precio= $_POST['precioPropiedad'];
      $direccion= $_POST['direccionPropiedad'];
      $pais= $_POST['paisPropiedad'];
      $provincia= $_POST['provinciaPropiedad'];
      $ciudad = $_POST['ciudadPropiedad'];
      $estado= 'DISPONIBLE';
      $foto = $_POST ['fotoPropiedad'];
      $idAdmin = $_SESSION['email'];

 
      $query="INSERT INTO `propiedades` ( nombre, descripcion, precio, direccion, pais, provincia, ciudad, estado, foto, ID_administrador, semanaDeAlta,semanaInicioVentana, semanafinVentana, anioInicioVentana, anioFinVentana )VALUES ('$nombre', '$descripcion', '$precio', '$direccion', '$pais', '$provincia','$ciudad','$estado', '$foto','$idAdmin', 'CURDATE()', 'DATE_ADD(CURDATE(), INTERVAL 6 MONTH)' , 'DATE_ADD(CURDATE(), INTERVAL 1 YEAR)', 'DATE_ADD(CURDATE(), INTERVAL 6 MONTH)', 'DATE_ADD(CURDATE(), INTERVAL 1 YEAR)')";
      $resul= mysqli_query($link,$query);

      echo '<script> alert ("Propiedad cargada correctamente")</script>';
      echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
//en date W me da el numero de semanas
// este anda CURDATE() es para mandar la fecha directamente en la consultaa
?>
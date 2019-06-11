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
      // $estado= $_POST['estadoPropiedad'];
      $foto = $_POST ['fotoPropiedad'];
      $idAdmin = $_SESSION['email'];
<<<<<<< HEAD
      $semanaAlta= date ('Y-m-d');
      $semanaInicio= date("Y-m-d",strtotime($semanaAlta."+ 6 months"));
      $semanaFin =  date("Y-m-d",strtotime($semanaAlta."+ 1 years"));
      $anioInicio = date('Y-m-d');
      $anioFin = date("Y-m-d",strtotime($semanaAlta."+ 1 years"));
     
      
      $query="INSERT INTO propiedades (nombre,descripcion, precio, direccion, pais, provincia, ciudad, foto, ID_administrador, semanaDeAlta, semanaInicioVentana,semanaFinVentana,anioInicioVentana,anioFinVentana) 
      VALUES ('$nombre','$descripcion', '$precio', '$direccion', '$pais', '$provincia','$ciudad','$foto','$idAdmin','$semanaAlta','$semanaInicio','$semanaFin','$anioInicio','$anioFin')";
      
     $consulta=mysqli_query($link,$query);
     if ($consulta==1){
      echo '<script> alert ("Propiedad cargada correctamente")</script>';
     } else {
      echo '<script> alert ("La propiedad no se cargo correctamente")</script>'; 
     }

      
     echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
=======
      $fecha=date('Y-m-d');
 
      $query="INSERT INTO propiedades ( nombre, descripcion, precio, direccion, pais, provincia, ciudad, foto, ID_administrador, semanaDeAlta,semanaInicioVentana, semanafinVentana, anioInicioVentana, anioFinVentana )VALUES ('$nombre', '$descripcion', '$precio', '$direccion', '$pais', '$provincia','$ciudad','$foto','$idAdmin', '$fecha', DATE_ADD(CURDATE(), INTERVAL 6 MONTH),DATE_ADD(CURDATE(), INTERVAL 1 YEAR))";
      mysqli_query($link,$query);
      echo '<script> alert ("Propiedad cargada correctamente")</script>';
      echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
>>>>>>> 9e395d3f213d9b5dc595befc9e0f01dfa728e483

//en date W me da el numero de semanas
// este anda CURDATE() es para mandar la fecha directamente en la consultaa
?>
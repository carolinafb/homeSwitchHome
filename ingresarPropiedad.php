<?php
      session_start();
      include 'conexion.php';
      $link=conexion();

      $nombre = $_POST['nombrePropiedad'];
      $descripcion=$_POST['descripcionPropiedad'];
      $precio= $_POST['precioPropiedad'];
      $precioSubasta= $_POST['precioSubasta'];
      $direccion= $_POST['direccionPropiedad'];
      $pais= $_POST['paisPropiedad'];
      $provincia= $_POST['provinciaPropiedad'];
      $ciudad = $_POST['ciudadPropiedad'];
      $estado= 'DISPONIBLE';
      $foto = $_POST ['fotoPropiedad'];
      $idAdmin = $_SESSION['email'];
      $semanaAlta=date ('W');
      $semanaInicio= $semanaAlta + 24;
      $anioInicio = date('Y');
      $semanaFin = $semanaInicio + 23;
      if($semanaFin > 52){ // Si la semana de fin es mayor a 52 q es el total de semanas del año, el fin sera el año que viene. entonces:
        $semanaFin = $semanaFin - 52; // obtengo el numero de semana del año siguiente
        $anioFin = $anioInicio + 1; // aumento un año
      }else { // es dentro del mismo año, no modifico nada, solo me guardo el mismo año
        $anioFin =  date('Y');
      }

      $query="INSERT INTO propiedades (nombre,descripcion, precio,precioDeSubasta, direccion, pais, provincia, ciudad, foto, ID_administrador, semanaDeAlta, semanaInicioVentana, semanaFinVentana, anioInicioVentana, anioFinVentana)
      VALUES ('$nombre','$descripcion', '$precio','$precioSubasta', '$direccion', '$pais', '$provincia','$ciudad','$foto','$idAdmin','$semanaAlta','$semanaInicio','$semanaFin','$anioInicio','$anioFin')";
      mysqli_query($link,$query);

      //DAR DE ALTA LAS  24 SEMANAS DISPONIBLES (INICIALIZAR LAS SEMANAS)
      $query2="SELECT MAX(ID) AS ID FROM propiedades";
      $consulta= mysqli_query($link,$query2); // obtener el id de la propiedad
      $idPropiedad=mysqli_fetch_array($consulta)['ID'];
      $semana = $semanaInicio;
      $anio = $anioInicio;
      for ($i=0; $i <> 24 ; $i++) {
        $inicializar ="INSERT INTO `ventanadesemanas`(`ID_propiedad`, `numeroDeSemana`, `estado`,`anio`) VALUES('$idPropiedad','$semana','DISPONIBLE','$anio')";
        mysqli_query($link,$inicializar);
        $semana ++;
        if($semana > 52){ // Si la semana de fin es mayor a 52 q es el total de semanas del año, el fin sera el año que viene. entonces:
          $semana = $semana - 52;
          $anio = $anio + 1;
        }
      }

      echo '<script> alert ("Propiedad cargada correctamente")</script>';
      echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
?>

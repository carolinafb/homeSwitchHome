<?php
    session_start();
   include 'conexion.php';
   $link=conexion();
?>
    <?php
    $semanaDeHoy = date('W'); // numero de la semana actual (HOY)
    //echo $semanaDeHoy," ";
    $principioDeVentana = $semanaDeHoy + 24; // numero de semana del comienzo de la ventana de semanas para reserva
    //  echo $principioDeVentana;

    if($principioDeVentana > 52){ // 52 es el total de samanas del 2019, si es mayo ya es semana del 2020
      $principioDeVentana = $principioDeVentana - 52;
      $anioComienzoVentana = 2020;
    }else { // el numero de semana pertenece al 2019
      $anioComienzoVentana = 2019;
    }

    $hoy= date ("Y-m-d"); // fecha de hoy
    // me traigo de la base de datos todas las semanas que quedaron antes de la ventana de reservas
    $consulta = "SELECT * FROM `ventanadesemanas` WHERE anio = $anioComienzoVentana AND numeroDeSemana < $principioDeVentana";
    $query = mysqli_query($link,$consulta);
    while ($fila=mysqli_fetch_array($query)){ // por cada semana que quedo fuera
        if ($fila['estado']=='DISPONIBLE'){// si esta disponible es que nunca nadie la reservo
            if ($fila['anio']== 2019) { // determino la fecha exacta del comienzo de la semana (el lunes)
              $comienzo= date("Y-m-d",strtotime(date("2018-12-24")."+".$fila['numeroDeSemana']." week"));
            }else {
              $comienzo= date("Y-m-d",strtotime(date("2019-12-23")."+".$fila['numeroDeSemana']." week"));

            }
            //traer el precio base de la base de datos, dependiendo de que propiedad se TokyoTyrantTable
            $consultaPrecioBase ="SELECT propiedades.precioDeSubasta FROM `ventanadesemanas` INNER JOIN propiedades ON ventanadesemanas.ID_propiedad = propiedades.ID WHERE propiedades.ID = {$fila['ID_propiedad']}";
            $queryPrecioBase = mysqli_query($link,$consultaPrecioBase);
            $filaPrecioBase=mysqli_fetch_array($queryPrecioBase);
            $precioBase= $filaPrecioBase['precioDeSubasta'];
            $idProp = $fila['ID_propiedad'];
            $numeroDeSemana = $fila['numeroDeSemana'];

            $nombrePropiedad ="SELECT nombre FROM `propiedades` WHERE ID = $idProp";
            $querynombre = mysqli_query($link,$nombrePropiedad);
            $filaNombre = mysqli_fetch_array($querynombre);
            $nombre = $filaNombre['nombre'];
            
            echo "<script> alert ('La semana numero $numeroDeSemana, que comienza el dia $comienzo, de la propiedad $nombre fue pasada a subasta ya que quedo fuera de la ventana de reservas.')</script>";
            // La inserto en la tabla de subastas
            $insertar="INSERT INTO `subastas`(`ID_propiedad`, `precioBase`, `estado`, `semana`, `fechaInicio`, `numeroSemana`) VALUES ({$fila['ID_propiedad']},'$precioBase','DISPONIBLE','$comienzo','$hoy',{$fila['numeroDeSemana']})";
            mysqli_query($link,$insertar);
        }
        $numeroSemanaFinal= $fila['numeroDeSemana'] + 24;
        if($numeroSemanaFinal > 52){
          $numeroSemanaFinal = $numeroSemanaFinal - 52;
          $anio = 2020;
        }else {
          $anio = 2019;
        }
        $semanaDelFinal = "INSERT INTO `ventanadesemanas`(`ID_propiedad`, `numeroDeSemana`, `anio`, `estado`) VALUES({$fila['ID_propiedad']},'$numeroSemanaFinal','$anio','DISPONIBLE')";
        mysqli_query ($link,$semanaDelFinal);
        $borrar="DELETE FROM `ventanadesemanas` WHERE ID = {$fila['ID']}";
        mysqli_query($link,$borrar);
    }
    echo '<script> alert ("Semanas actualizadas correctamente")</script>';
    echo '<script> window.location="index.php"</script>';
     ?>

<?php
      session_start();
      include 'conexion.php';
      $link=conexion();
      $idPropiedad = $_POST['idPropiedad'];
      $precioBase=$_POST['precioBase'];
      $idAdministrador= $_POST['idAdministrador'];
      $semanaSubasta= $_POST['semanaSubasta'];
      $estadoPropiedad= $_POST['estadoPropiedad'];
      $numeroSemana=date('W', strtotime($semanaSubasta));// el numero de semana de la fecha se que ingresa en el input
      
      $subasta = "SELECT ID, ID_propiedad, semana, numeroSemana  FROM `subastas` WHERE ID_propiedad= $idPropiedad AND numeroSemana =$numeroSemana";
      $consulta=mysqli_query($link, $subasta);
  echo "subasta: ",$subasta; 
      if (mysqli_num_rows($consulta)>0){ // que  la consulta traiga filas
          $fila=mysqli_fetch_array($consulta);// me traigo lo que tenga la consulta
          $numeroSemanaExistente = $fila['numeroSemana'];  // me guardo la numero de semana que vino en la consulta
          echo $numeroSemanaExistente;
          if($numeroSemanaExistente <> $numeroSemana){ // si los valores de numeros de semana son distintos puedo agregar
     
            $query="INSERT INTO subastas ( ID_propiedad, precioBase, ID_administrador, estado, semana, numeroSemana ) VALUES ('$idPropiedad', '$precioBase', '$idAdministrador', '$estadoPropiedad', '$semanaSubasta','$numeroSemana')";
            $result=  mysqli_query($link,$query);
            if($result == FALSE ){
              echo 'false';
            }
            if($result == TRUE){
               echo '<script> alert ("Subasta cargada correctamente")</script>';
            //  echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
            }
     
      }else{// si el numero de semana que ingreso en el input ya existe en la base
          ?> 
           <br> <div align ="center"> <b> Ya existe una subasta para esa semana en esa propiedad </div> <b> </br> 
                           <button type="button" onclick=" location.href='index.php' " > Volver </button>


     <?php }
    }else{// si la consulta no trajo nada agrego sin problemas
          $fechaInicio=date("Y-m-d");
            $query="INSERT INTO subastas ( ID_propiedad, precioBase, ID_administrador, estado, semana, numeroSemana, fechaInicio ) VALUES ('$idPropiedad', '$precioBase', '$idAdministrador', '$estadoPropiedad', '$semanaSubasta','$numeroSemana','$fechaInicio')";
            $result=  mysqli_query($link,$query);
            if($result == FALSE ){
              echo 'false';
            }
            if($result == TRUE){
               echo '<script> alert ("Subasta cargada correctamente")</script>';
              echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
              }
    }     
     
    
     
?>
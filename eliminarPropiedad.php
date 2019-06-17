<?php
      session_start();
      include 'conexion.php';
      $link=conexion();
      $idPropiedad = $_GET['id'];

		if(isset($_SESSION['nombre'])){// si la sesion esta iniciada muestra codigo, rol y el cerrar sesion
   			if($_SESSION['rol']== 'ADMINISTRADOR'){

   				$query= "SELECT ID FROM `subastas` WHERE ID_propiedad = $idPropiedad  AND estado = 'DISPONIBLE'";
    			$consulta = mysqli_query($link,$query);

         	if(mysqli_num_rows($consulta)> 0){
       			echo 'No se ha podido eliminar la propiedad';
       			}
       else {
     	 $actualizar= "UPDATE propiedades SET estado= 'NO DISPONIBLE' WHERE ID=$idPropiedad";
     	 mysqli_query($link,$actualizar);
         echo '<script> alert ("Propiedad eliminada correctamente")</script>';
         echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
     }
      }
  }
  ?>

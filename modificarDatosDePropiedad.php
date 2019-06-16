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
      $idProp= $_POST['ID'];

      $idAdmin = $_SESSION['codigo'];

      $idAdmin = $_SESSION['email'];


      if (isset($idProp)){

   $sql = "UPDATE propiedades SET nombre='$nombre', descripcion= '$descripcion', precio='$precio', direccion='$direccion',pais='$pais',provincia='$provincia',ciudad='$ciudad',foto= '$foto', ID_administrador= '$idAdmin' WHERE ID=$idProp";
   mysqli_query($link,$sql);
       echo '<script> alert ("Propiedad modificada correctamente")</script>';
       echo '<script> window.location="index.php"</script>'; 
}else{
   echo "Debe especificar un 'id'.\n";
}

?>

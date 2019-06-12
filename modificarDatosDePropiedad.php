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
<<<<<<< HEAD
      $idAdmin = $_SESSION['codigo'];
=======
      $idAdmin = $_SESSION['email'];

>>>>>>> 3c2874cfe6e3ecbbaae2154492d6916327551c4d
      if (isset($idProp)){
   // process form
  // $link = mysql_connect("localhost", "root");
  // mysql_select_db("mydb",$db);
   $sql = "UPDATE propiedades SET nombre='$nombre', descripcion= '$descripcion', precio='$precio', direccion='$direccion',pais='$pais',provincia='$provincia',ciudad='$ciudad',foto= '$foto', ID_administrador= '$idAdmin' WHERE ID=$idProp";
   mysqli_query($link,$sql);
       echo '<script> alert ("Propiedad modificada correctamente")</script>';
       echo '<script> window.location="index.php"</script>'; // Esto deberia ir al listado de propiedades
}else{
   echo "Debe especificar un 'id'.\n";
}

?>

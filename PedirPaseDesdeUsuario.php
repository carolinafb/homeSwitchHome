<?php
session_start();
include 'conexion.php';
$link = conexion();
$userID = $_GET['idUser'];

      if (isset($_SESSION['nombre'])) {
        if (($_SESSION["rol"] !== "ADMINISTRADOR")) {

          $consultaSol="SELECT * FROM solicitudpases WHERE ((ID_Usuario=$userID) AND (estado='PENDIENTE'))";
          $querySol=  mysqli_query($link,$consultaSol);
          if(mysqli_num_rows($querySol) > 0){
            echo '<script> alert ("Solicitud  ya existente, por favor espere.")</script>';
          }else{

              $query="INSERT INTO solicitudpases ( ID_Usuario, estado )VALUES ('$userID', 'PENDIENTE')";
              mysqli_query($link,$query);
              echo '<script> alert ("Solicitud cargada en el sistema correctamente.")</script>';}
        }
        echo '<script> window.location="perfilUsuario.php"</script>'; 
      }

?>

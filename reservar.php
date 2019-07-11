<?php
    session_start();
   include 'conexion.php';
   $link=conexion();

   $IDUsu = $_SESSION['id'];
   $semana = $_GET['sem'];
   $anio = $_GET['anio'];
   $idProp= $_GET['id'];
   $IDsemana = $_GET['idsemana'];


   if($anio == '2019'){ // determino la fecha de comienzo de la estadia
         $comienzo= date("Y-m-d",strtotime(date("2018-12-24")."+".$semana." week"));
   }else {
       $comienzo= date("Y-m-d",strtotime(date("2019-12-23")."+".$semana." week"));
   }
   $fin= date("Y-m-d",strtotime(date("$comienzo")."+ 6 day"));
   echo $semana," ",$comienzo;
   if ($_SESSION['rol']== 'PREMIUM') {
     $queryCreditosUsuario = "SELECT creditos FROM usuario WHERE ID=$IDUsu "; //creditos del usuario
     $consultaCreditosUsuario = mysqli_query($link, $queryCreditosUsuario);

     if (mysqli_num_rows($consultaCreditosUsuario) > 0) { // Si traigo filas
        $fila = mysqli_fetch_array($consultaCreditosUsuario);
        if ($fila["creditos"] > 0) {
          $cargar ="INSERT INTO reservas(`ID_propiedad`, `ID_usuario`, `fechaInicio`, `fechaFin`,`operacion`) VALUES('$idProp','$IDUsu','$comienzo','$fin','RESERVA DIRECTA')";
          $query = mysqli_query($link,$cargar);
          $credAct = ($fila["creditos"] - 1);
          $queryCreditosUsuario = "UPDATE usuario SET creditos = $credAct WHERE ID= $IDUsu   ";
          $consultaCreditosUsuario = mysqli_query ($link, $queryCreditosUsuario);

          $modificar= "SELECT * FROM `ventanadesemanas` WHERE ID =  $IDsemana";
          $queryModificar= mysqli_query($link,$modificar);
          $filaModificar = mysqli_fetch_array($queryModificar);

          $borrar = "UPDATE `ventanadesemanas` SET `ID`= {$filaModificar['ID']},`ID_propiedad`={$filaModificar['ID_propiedad']},`numeroDeSemana`={$filaModificar['numeroDeSemana']},`anio`={$filaModificar['anio']},`estado`='RESERVADA' WHERE ID = $IDsemana";
          mysqli_query($link,$borrar);
          echo '<script> alert ("Semana reservada correctamente")</script>';
          echo '<script> window.history.back()</script>';
        } else {
         echo "<script> alert ('No puede completar la reserva, Creditos insuficientes');</script>	";
         echo '<script> window.history.back()</script>';
     }
   }
 }


?>

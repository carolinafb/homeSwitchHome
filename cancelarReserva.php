<?php
  session_start();
  include "conexion.php";
  $link=conexion();

  $idReserva = $_GET['idReserva'];// id de la reserva
  $idProp = $_GET['idProp'];
  echo "id de reserva ",$idReserva;
  $modificar= "UPDATE `reservas` SET `estado`='CANCELADO' WHERE `ID` = $idReserva "; // actualizar estado de la reserva a cancelado
  $query = mysqli_query($link,$modificar);

  $queryCredito = "SELECT creditos FROM usuario WHERE ID= {$_SESSION['id']}   "; //devolver el credito
  $consultaCredito = mysqli_query ($link, $queryCredito);
  $filaCredito = mysqli_fetch_array ($consultaCredito);
  $credAct = ($filaCredito ["creditos"] + 1);
  $actualizarCreditos= "UPDATE `usuario` SET `creditos`= $credAct  WHERE 1";
  mysqli_query ($link, $actualizarCreditos);


  $consultaSemana ="SELECT * FROM `reservas` WHERE `ID` = $idReserva "; //
  $query2= mysqli_query($link,$consultaSemana);
  $fila = mysqli_fetch_array($query2);
  $comienzoDeVentana = date("Y-m-d");
  $comienzoDeVentana = date("Y-m-d",strtotime(date($comienzoDeVentana)."+ 24 week"));
  $numeroDeSemana = $fila['fechaInicio'];
  $numeroDeSemana = date('W',strtotime(date("$numeroDeSemana")));
/*  ?></br><?php
  echo "Comienzo de ventana ", $comienzoDeVentana;
  ?></br><?php
  echo " fecha de reserva :", $fila['fechaInicio'];*/
  if ($comienzoDeVentana < $fila['fechaInicio']) {//Si la fecha de la reserva es menor a la de comienzo de ventana
    $actualizar = "UPDATE `ventanadesemanas` SET `estado`='DISPONIBLE' WHERE `numeroDeSemana`= $numeroDeSemana AND `ID_propiedad` =$idProp";
    mysqli_query($link,$actualizar); //VUelve a estar en disponoble en la tabla de semanas disponibles
  }else { // Si la fecha de reserva es mayor al comienzo de ventana
    $lunes = $fila['fechaInicio'];
    $domingo = $fila['fechaFin'];
/* echo " lunes ", $lunes," domingo ",$domingo;*/
    $insertar = "INSERT INTO `hotsales`( `ID_propiedad`, `estado`, `numeroSemana`, `lunes`, `domingo`) VALUES ({$fila['ID_propiedad']},'ESPERA','$numeroDeSemana','$lunes','$domingo')";
    mysqli_query($link,$insertar); //Se da de alta como disponible para hotsale
  }
  //echo '<script> window.history.back()</script>';

?>

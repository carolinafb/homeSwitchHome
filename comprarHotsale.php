
<?php
 	include "conexion.php";
	 $link=conexion();
	 session_start();
     $idPropiedad = $_GET['idProp'];
  
     $idHotsale= $_GET['idHot'];
     echo "id h: ",$idHotsale,"id p: ",$idPropiedad;
	

	 if(isset($_SESSION['nombre'])){
	 	
            $query="UPDATE `hotsales` SET `estado`='CANCELADO' WHERE ID=$idHotsale";//consulta a la base con solo datos q necesito
            $consulta=mysqli_query($link, $query);
        
            $queryHotsale="SELECT * FROM hotsales WHERE ID=$idHotsale";
            $consultaHotsale=mysqli_query($link, $queryHotsale);
            if (mysqli_num_rows($consultaHotsale) > 0) { 
                $hotsale= mysqli_fetch_array($consultaHotsale);
               
          //consultar monto  de tajeta if true

                $queryReservar= "INSERT INTO reservas ( ID_propiedad, ID_usuario, fechaInicio, fechaFin, operacion, semana, precio) 
               VALUES ($idPropiedad, {$_SESSION['id']}, '{$hotsale['lunes']}', '{$hotsale['domingo']}','HOTSALE', {$hotsale["numeroSemana"]}, {$hotsale["precio"]})";
                $consulta=mysqli_query($link, $queryReservar);

            //if false mensaje de moto insuficiente
        }
            echo '<script> window.location="listarHotsalesVigentes.php"</script>';
         
} 
?>
  
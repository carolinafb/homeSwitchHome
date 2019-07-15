
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
        
            $queryHostale="SELECT * FROM hotsales WHERE ID=$idHotsale";
            $consultaHotsale=mysqli_query($link, $queryHostale);
            if (mysqli_num_rows($consultaHotsale) > 0) { 
                $hotsale= mysqli_fetch_array($consultaHotsale);
               
                //esta cosa rara funca en el script de cerrar subastas pero aca no :(
                $domingo = date("Y-m-d",strtotime(date($hotsale['lunes'])."+ 6 day"));
                $lunes =date($hotsale['lunes']);
                echo "FECHAS:   ",$lunes,"..",$domingo,"||",$hotsale['lunes']," ",$hotsale['domingo'];

              
                $queryReservar= "INSERT INTO `reservas`( `ID_propiedad`, `ID_usuario`, `fechaInicio`, `fechaFin`, `operacion`, `estado`, `semana`, `precio`) 
                                                VALUES ($idPropiedad,{$_SESSION['id']},{$hotsale["lunes"]},{$hotsale["domingo"]},'HOTSALE','RESERVADO',{$hotsale["numeroSemana"]},{$hotsale["precio"]})";
                $consulta=mysqli_query($link, $queryReservar);
        }
            //echo '<script> window.location="listarHotsalesVigentes.php"</script>';
               //  $lunes =date($hotsale['lunes']);
            //     $domingo = date("Y-m-d",strtotime(date($hotsale['lunes'])."+ 6 day"));
               // echo "FECHAS:   ",$lunes,"..",$domingo,"||",$hotsale['lunes']," ",$hotsale['domingo'];
} 
?>
  
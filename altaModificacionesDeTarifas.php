<?php
		session_start();
    include 'conexion.php';
    $link=conexion();
		$pEstandar = $_POST['precioEstandar'];
		$pPremium = $_POST['precioPremium'];
		$queryEstandar = "UPDATE `tarifas` SET `precio`= $pEstandar WHERE titulo ='ESTANDAR'";
		$queryPremium = "UPDATE `tarifas` SET `precio`= $pPremium WHERE titulo ='PREMIUM'";
		 mysqli_query($link,$queryEstandar);
		 mysqli_query($link,$queryPremium);
		 echo '<script> alert ("Tarifas modificadas correctamente")</script>';
		 echo '<script> window.location="index.php"</script>';
?>

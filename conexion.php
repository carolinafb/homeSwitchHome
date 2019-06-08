<?php
	function conexion(){
		$db="hshliviana";//nombre de la base de datos
		$link=mysqli_connect("localhost", "root","","$db")or die ("problemas para conectar");//conexion
		return $link;
	}
?>
<?php	
 	session_start();
 	include "conexion.php";
	 $link=conexion(); 
   $idProp = $_GET['id'];
	 $estadoProp= 'DISPONIBLE';
	 $query= "SELECT ID FROM `usuario` WHERE codigo = {$_SESSION['codigo']}";
	 $consulta=mysqli_query($link, $query);
	 $idAdministrador= mysqli_fetch_row($consulta);
	 $idAdmin= $idAdministrador[0];

	 if(isset($_SESSION['login'])){
	 	if($_SESSION['rol']== 'ADMINISTRADOR'){

	 		//la subasta necesita los siguientes datos: id propiedad, precio base de la subasta y semana 
?>
<!DOCTYPE html>
<html>
<head>
	<title>HomeSwitchHome</title>
	 		<left> 
   	 	 		<a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a>
 	 		</left>
 			
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
</head>
<body>
<form name='crearSubasta' action='altaSubasta.php' method="POST">
<fieldset>
<h2>Agregar Propiedad a Subasta </h2>
<td> <input type= 'hidden' name='idPropiedad' id='idPropiedad' value= "<?php echo $idProp ?>" required/>
<table>
  <tr>
    <th>Precio Base: </th>
   <td> <input type= 'number' name='precioBase' id='precioBase' style="width: 100%" required/>
   </td>
  </tr>
  <tr>
    <td><input type= 'hidden' name='idAdministrador' id='idAdministrador'  value= "<?php echo $idAdmin ?>" required/>
    </td>
   
  </tr>
  <?php
    $semanaInicio= date("Y-m-d",strtotime(date("Y-m-d")."+ 6 months")); 
    $semanaFin=  date("Y-m-d",strtotime(date("Y-m-d")."+ 1 years")); // me creo estas variables para restringir que las semana de las subastas a crear sean dentro de la ventana permitida
  ?>
  <tr>
    <th>Semana: </th>
    <td><input type= 'date' name='semanaSubasta' id='semanaSubasta' style="width: 100%"  min= "<?php echo $semanaInicio?>" max= "<?php echo $semanaFin?>" required/></td>
  </tr>
  <tr>
    <td><input type= 'hidden' name='estadoPropiedad' id='estadoPropiedad' value= "<?php echo $estadoProp ?>" required/></td>
  </tr>
</table>
		<input type="submit" value="Guardar"> <!--boton-->
		</fieldset>
</form>

</body>
</html>


<?php	 	}

	 }



?>
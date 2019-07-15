<?php
session_start();
include 'conexion.php';
$link = conexion();
$idHot = $_GET['ID'];
if (isset($_SESSION['nombre'])&&($_SESSION['rol']== 'ADMINISTRADOR')) {
	$query= "SELECT * FROM hotsales WHERE ID= $idHot";
	$consulta=mysqli_query($link, $query);
	$datos= mysqli_fetch_array($consulta);

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
       <form name='modificarHotsale' action='modificarDatosHotsale.php' method="POST">
        <fieldset>
        <h2>Indique un Precio Para hotsale</h2>
         <table>
          <tr>
          	<input type= 'hidden' name='idHotsale' id='idHotsale' value= "<?php echo $idHot ?>" required/>
            <th>Nombre: </th>
           <td> <input type= 'text' name='precioHot' id='precioHot' value = " <?php echo $datos['precio'] ?>" style="width: 100%" required/>
           </td>
          </tr>
      </table>
      <input type="submit" value="Guardar"> <!--boton-->
    </fieldset>
     </form>
     <button type="button" onclick=" location.href='index.php' "> Volver </button>
<?php
}
?>
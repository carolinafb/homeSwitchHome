<?php	
  session_start();
  include "conexion.php";
  $link=conexion();
  $idProp = $_GET['id'];
  $queryPujas="SELECT subastas.ID_propiedad, subastas.id as id_subasta, pujas.ID as id_puja FROM `subastas` INNER JOIN `pujas` on subastas.ID = pujas.ID_subasta where subastas.ID_propiedad = $idProp ";
  $consultaPujas= mysqli_query ($link , $queryPujas);// consulta si hay pujas asociadas al id de la propiedad que quiero modificar

  if(mysqli_num_rows($consultaPujas) == 0){// si es = 0 es porque no tiene pujas 

        $query="SELECT ID, foto, nombre, precio, pais, provincia,ciudad ,estado, descripcion FROM `propiedades` WHERE ID= $idProp";
        $consulta=mysqli_query($link, $query);
          //$datos= mysqli_fetch_row($consulta);

        	 if(isset($_SESSION['login'])){
        	 	if($_SESSION['rol']== 'ADMINISTRADOR'){
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
        <form name='modificarPropiedad' action='modificarDatosDePropiedad.php' method="POST">
        <fieldset>
        <h2>Modificar Propiedad</h2>
        <td> <input type= 'hidden' name='ID' id='idPropiedad' value= "<?php echo $idProp ?>" required/>
        <table>
          <tr>
            <th>Nombre: </th>
           <td> <input type= 'text' name='nombrePropiedad' id='nombrePropiedad' style="width: 100%" required/>
           </td>
          </tr>
          <tr>
          	<th> Descripcion: </th>
            <td><textArea type= 'text' name='descripcionPropiedad' id='descripcionPropiedad' rows="10" cols="50"style="width: 100%" required></textArea></td>
           
          </tr>
          <tr>
            <th>Precio:</th>
        	  <td><input type= 'text' name='precioPropiedad' id='precioPropiedad' style="width: 100%" required/></td>
          </tr>
          <tr>
            <th>Direccion:</th>
            <td><input type= 'text' name='direccionPropiedad' id='direccionPropiedad' style="width: 100%" required/></td>
            
          </tr>
          <tr>
            <th>Ciudad:</th>
            <td><input type="text" name="ciudadPropiedad" id="ciudadPropiedad"   style="width: 100%" required/> </td>
          </tr>
          <tr>
            <th>Provincia:</th>
            <td><input type= 'text' name='provinciaPropiedad' id='provinciaPropiedad' style="width: 100%" required/></td>
          </tr>
          <tr>
            <th>Pais: </th>
            <td><input type= 'text' name='paisPropiedad' id='paisPropiedad' style="width: 100%" required/></td>
          </tr>
          <tr>
            <th>Foto: </th>
            <td><input type= 'text' name='fotoPropiedad' id='fotoPropiedad' style="width: 100%" required/></td>
          </tr>
        </table>
        		<input type="submit" value="Guardar"> <!--boton-->
        		</fieldset>
        </form>

        </body>
        </html>


        <?php	 	}
        	 }
  }else{// si tiene pujas no permito modificar y vuelve la pantalla al index
    echo  '<script> alert ("No se puede modificar la propiedad porque tiene pujas asociadas");</script>';
    echo '<script> window.location="index.php"; </script>';
  }
?>
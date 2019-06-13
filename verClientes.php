<?php
session_start();
include "conexion.php";
$link = conexion();

	
  ?>
    <html>
	<head>
		<title>Clientes</title>
		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
		<h1 align ='center'> Clientes </h1>
		
	</head>
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
	<body>
<?php
  //lo que tengo que hacer es lo siguiente: Si soy admin
  //mostrar todos los clentes.
  //en html hacer un punteo por nombre, o por fecha de creacion que tenga el h2 Filtrar por 
  //en php usar select para hacer la consulta
        	 	if (isset($_SESSION['nombre'])) {
        	 	if($_SESSION['rol']== 'ADMINISTRADOR'){

  ?>

	<br><td> <form name='verClientesPorFiltro' action='verClientesPorFiltro.php' method="POST" align ='center'>
        <fieldset><h2>Buscar Clientes</h2>
        	<table align ='center'>
          <tr>
            <th>Buscar por Nombre </th>
           <td> <input type= 'text' name='nombre' id='nombre' value = 'ingrese un nombre' style="width: 100%">
           	 <button type="button" onclick=" location.href='index.php' " > Buscar </button>
           </td>
          </tr>
        </td>

			</tr>
			<tr>
            <th>Buscar por Fecha de Creacion </th>
          <td> <input type="date" name="fechaNacimiento"> 
           <button type="button" onclick=" location.href='index.php' " > Buscar </button>
       </td>    
          </tr>
        </td>

			</tr>
		</table>
	 </fieldset>
 </form>

		<table>
			<tr>
				<td> Nombre</td>
				<td>Apellido</td>
				<td> Fecha De Nacimiento</td>
				<td>Pa&iacutes</td>
				<td>Email</td>
				<td> </td>
				
	<?php

        	 		$query="SELECT * FROM `usuario` WHERE  rol = 'ESTANDAR' OR rol= 'PREMIUM' ";//consulta a la base con solo datos q necesito
    				$consulta=mysqli_query($link, $query);
    				
    				while ($persona= mysqli_fetch_array($consulta)) {
    ?>
    		<tr>
				<td><?php echo $persona["nombre"]   ?> </td>
				<td><?php echo $persona["apellido"]  ?></td>
				<td><?php echo $persona["fechaNacimiento"]   ?></td>
				<td><?php echo $persona["pais"]   ?></td>
				<td><?php echo $persona["email"]  ?></td>
				<td> <a href="detallesCliente.php?id=<?php echo $persona["ID"] ?> "> Ver Detalles </a></td>

			</tr>
			
    <?php				



        	 }

        	}

        	 }

	?>
	  </table>
	  <button type="button" onclick=" location.href='index.php' " > Volver </button>

	</body>		
	</html>

		
		
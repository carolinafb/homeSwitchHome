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
  width:100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
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
    <table>
      <tr>
        <td>
          <form name='verClientesPorFiltro' action='verClientes.php' method="POST" align ='center'>
            <fieldset><legend>Buscar por Nombre</legend>
              <table>
                <tr>
                  <td><input type= 'text' name='nombreUsuario' id='nombreUsuario' style="width: 100%"></td>
                  <td><button type="submit" > Buscar Por Nombre </button></td>
                </tr>
              </table>

            </fieldset>
            </form>
          </td>
          <td>
            <form name='verClientesPorFecha' action='verClientes.php' method="POST" align ='center'>
              <fieldset><legend>Buscar por Fecha de Registro</legend>
                <table>
                  <tr>
                    <td><input type="date" name="fechaRegistro"></td>
                    <td><button type="submit" > Buscar Por Fecha de Registro </button></td>
                  </tr>
                </table>
              </fieldset>
               </form>
            </td>
            <td>
          <form name='verClientesPorTipo' action='verClientes.php' method="POST" align ='center'>
            <fieldset><legend>Buscar por Tipo de Usuario</legend>
              <table>
                <tr>
                  <td><select name= 'rol' id='rol'>
                    <option>-------</option>
                    <option>ESTANDAR</option>
                    <option>PREMIUM</option>
                  </select></td>
                  <td><button type="submit" > Buscar </button></td>
                </tr>
              </table>
            </fieldset>
          </form>
          </td>
          </tr>
          <tr>
            <th>Ordenar por: </th>
            <td><a href="verClientes.php?nombre='1'">Nombre</a></td>
            <td><a href="verClientes.php?rol='1'">Rol</a></td>
            <td><a href="verClientes.php?fechaRegistro='1'">FechaDeRegistro</a></td>
          </tr>  
        </table>

        <table>
         <tr>
          <td> Nombre</td>
          <td>Apellido</td>
          <td> Fecha De Nacimiento</td>
          <td>Pa&iacutes</td>
          <td>Email</td>
          <td>Fecha De Registro</td>

          <?php
          if (isset($_POST['rol'])&&(($_POST['rol'])!= '-------')) {
             $query= "SELECT * FROM `usuario` WHERE rol = '{$_POST['rol']}' ";
          }elseif (isset($_POST['nombreUsuario'])&& ($_POST['nombreUsuario'] != '')) {
             $query= "SELECT * FROM `usuario` WHERE nombre = '{$_POST['nombreUsuario']}' ";
          } elseif (isset($_POST['fechaRegistro'])&& ($_POST['fechaRegistro']!= '')) {
           $query= "SELECT * FROM `usuario` WHERE fechaRegistro = '{$_POST['fechaRegistro']}' ";  
         }elseif (!(isset($_GET['nombre']))&& !(isset($_GET['fecha'])) && !(isset($_GET['rol']))) {
           $query="SELECT * FROM `usuario` WHERE rol = 'ESTANDAR' OR rol= 'PREMIUM'";
         } elseif (isset($_GET['nombre'])) {
          $query="SELECT * FROM `usuario`  WHERE rol = 'ESTANDAR' OR rol= 'PREMIUM' ORDER BY `usuario`.`nombre` ASC ";
        }elseif (isset($_GET['rol'])) {
         $query = "SELECT * FROM `usuario` WHERE rol = 'ESTANDAR' OR rol= 'PREMIUM' ORDER BY `usuario`.`rol` ASC ";
       }else{
         $query = "SELECT * FROM `usuario` WHERE rol = 'ESTANDAR' OR rol= 'PREMIUM' ORDER BY `usuario`.`fechaRegistro` ASC ";
       }

       $consulta=mysqli_query($link, $query);

       if (mysqli_num_rows($consulta)>0) {

        while ($persona= mysqli_fetch_array($consulta)) {
          ?>
          <tr>
            <td><?php echo $persona["nombre"]   ?> </td>
            <td><?php echo $persona["apellido"]  ?></td>
            <td><?php echo $persona["fechaNacimiento"]   ?></td>
            <td><?php echo $persona["pais"]   ?></td>
            <td><?php echo $persona["email"]  ?></td>
            <td><?php echo $persona["fechaRegistro"]  ?></td>
            <td> <a href="detallesCliente.php?id=<?php echo $persona["ID"] ?> "> Ver Detalles </a></td>

          </tr>

          <?php				



        }
      }else {
        echo 'No hay datos para mostrar';
      } 

    }

  }

  ?>
</table>
<button type="button" onclick=" location.href='index.php' " > Volver </button>

</body>		
</html>



<?php
   session_start();
   include "conexion.php";
   $link=conexion();
   if(isset($_SESSION['nombre'])){
       if ($_SESSION['rol']=='ADMINISTRADOR'){
          $query="SELECT titulo,precio FROM `tarifas` WHERE titulo='ESTANDAR'";
          $consulta=mysqli_query($link,$query);
          $estandar= mysqli_fetch_array($consulta);



          $query="SELECT titulo,precio FROM `tarifas` WHERE titulo='PREMIUM'";
          $consulta=mysqli_query($link,$query);
          $premium= mysqli_fetch_array($consulta);

?>
<html>
  <head>
      <left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a></left>
      <br/>
  </head>
  <body>
        <form name='modificarTarifas' action='altaModificacionesDeTarifas.php' method="POST"  >
              <fieldset>
              <table>
                  <th>Tarifas</th>
                  <tr>
                    <td><?php echo $estandar["titulo"]; ?></td>
                    <td> <input type="number" name="precioEstandar" id="precioEstandar" value= <?php  echo $estandar["precio"] ?>> </td>
                  </tr>
                  <tr>
                    <td><?php echo $premium["titulo"]; ?></td>
                    <td> <input type="number" name="precioPremium" id="precioPremium" value= <?php   echo $premium["precio"] ?>> </td>
                  </tr>
              </table>
                  <input type="submit" value="Modificar"> <!--boton-->
                  <button type="button" onclick=" location.href='index.php' " > Cancelar </button>
              </fieldset>
          </form>
    </body>
</html>
<?php }} ?>

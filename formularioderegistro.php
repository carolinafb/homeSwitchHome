<?php
include "conexion.php";
$link=conexion();
 ?>
<html>
<head>

  <center>
      <a href="index.php"><img src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" > </a>
  </center>

   <title> Registro </title>

  </head>
<body>
  <?php
  $tarifas = "SELECT * FROM `tarifas` ";
  $consulta = mysqli_query($link,$tarifas);
   ?>
   <h2>Tarifas</h2>
  <?php  while ($fila=mysqli_fetch_array($consulta)){?>
    <table>
      <tr> <!-- Abro una fila -->
        <td> <?php echo $fila["titulo"], " "; ?> </td>
        <td> <?php echo "$",$fila["precio"] ?></td>
      </tr>
     <?php } ?>
  </table>
 <form name='datosUsuario' action="accion.php" method="POST" >
   <fieldset>
    <legend> <h1> Registro de Usuario </h1>	</legend>
    <table>
       <tr>
          <td> Nombre: </td>
          <td><input type= 'text' name='nombre' id='nombre' required/></td>
        </tr>
    <th></th>
       <tr>
          <td>Apellido: </td>
          <td><input type= 'text' name='apellido' id='apellido' required/></td>
       </tr>
    <th></th>
      <tr>
        <td>Fecha Nacimiento: </td>
        <td> <input type="date" name="fechaNacimiento"> </td>
      </tr>
    <th></th>
        <tr>
          <td> Email: </td>
          <td><input type= 'text' name='email' id='email' required/></td>
        </tr>
    <th></th>
        <tr>
         <td>Contrseña: </td>
          <td><input type= 'password' name='contrasena' id='contrasena' title="Minimo 6 caracteres, letras mayusculas y minisculas y por lo menos un numero o simbolo" required/ ></td>
        </tr>
    <th></th>
          <tr>
            <td>Pais: </td>
            <td>
              <select name='pais' id='pais' required>
                <option>Argentina</option>
                <option>Bolivia</option>
                <option>Brasil</option>
                <option>Chile</option>
                <option>Colombia</option>
                <option>Costa Rica</option>
                <option>Cuba</option>
                <option>Ecuador</option>
                <option>El Salvador</option>
                <option>Guatemala</option>
                <option>Honduras</option>
                <option>México</option>
                <option>Nicaragua</option>
                <option>Panamá</option>
                <option>Paraguay</option>
                <option>Puerto Rico</option>
                <option>Perú</option>
                <option>República Dominicana</option>
                <option>Uruguay</option>
                <option>Venezuela</option>
              </select>
           <!--   <input type= 'text' name='pais' id='pais' required/>-->
           </td>
       </tr>
       <th></th>
       <tr>
          <td><h2><strong> Datos de tarjeta</strong></h2></td>
       </tr>
       <tr>
          <td>Numero de tarjeta: </td>
          <td><input type= 'number' name='numerotarjeta' id='numerotarjeta' placeholder="16 caracteres correspondientes" required/></td>
       </tr>
       <th></th>
       <tr>
          <td>Nombre y apellido </td>
          <td><input type="text" name="nomYape" id="nomYape" placeholder="tal cual impreso en la tarjeta" required/></td>
       </tr>
       <tr>
         <td>Fecha de expiracion</td>
         <td><input type="Month" name="expiracion" id="expiracion"  required/></td>
       </tr>
       <tr>
         <td>Codigo de seguridad</td>
         <td><input type="number" name="codSeg" id="codSeg"  required/></td>
       </tr>
  </table>
  <br>
  <input  type="submit" value="Registrarse" onclick="validarform()">
   </fieldset>
 </form>
</body>
</html>

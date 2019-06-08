<html>
<head> 
   
  <center> 
      <a href="index.php"><img src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" > </a>
  </center>

   <title> Registro </title>   
  
  </head>
<body>
  
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
          <td>Numero de tarjeta: </td> 
          <td><input type= 'number' name='numerotarjeta' id='numerotarjeta' required/></td>
       </tr>
       <th></th>
    
       <tr>
          <td>Pais: </td> 
          <td><input type= 'text' name='pais' id='pais' required/></td>
       </tr>
  </table>
  <br>
  <input  type="submit" value="Registrarse" onclick="validarform()"> 
   </fieldset>
 </form>
</body>
</html>
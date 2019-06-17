<?php
session_start();
include 'conexion.php';
$link = conexion();

?>
<html>

<head> </head>
<title>Home Switch Home </title>

</head>

<body>

    <center>
        <!-- esta es la imagen de la portada -->
        <div class='portada'><img src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250"> </div>
    </center>
    <div align="right">
        <a href="formularioderegistro.php">Registrarse</a>&nbsp|&nbsp
        <a href="login.php">Iniciar sesion</a>
    </div>
    <div style="display:flex; width:100%">

    
        <?php
        $query = "SELECT ID, foto, nombre, precio, pais, provincia,ciudad ,estado, descripcion, direccion FROM `propiedades` ORDER BY RAND() LIMIT 1";
        $consulta = mysqli_query($link, $query);
        if (mysqli_num_rows($consulta) > 0) {
            $datos = mysqli_fetch_row($consulta);
            ?>
            <div style=" width:50%">
                <tr>
                <center>
                        <h2>Propiedad para reserva directa:</h2>
                      
                        <br>
                        <img src=<?php echo $datos[1]  ?>width="300" height="300">
                        <br>
                        <h3>
                            <strong>
                                <div align="center"> <?php echo $datos[2] ?> </div>
                            </strong>
                      
                        </h3>
                        <td>
                            <br> <b>Descripcion: </b>
                            <p>
                                <?php echo $datos[8] ?>
                            </p>
                        </td>
                <tr>
                    <td><br> <b>Dirección: </b>
                        <?php echo $datos[9] ?>
                    </td>
                </tr>
                <tr>
                    <td><br> <b>Ciudad: </b>
                        <?php echo $datos[6] ?>
                    </td>
                </tr>
                <tr>
                    <td><br> <b>Provincia: </b>
                        <?php echo $datos[5] ?>
                    </td>
                </tr>
                <tr>
                    <td><br> <b>Pais: </b>
                        <?php echo $datos[4] ?>
                    </td>
                </tr>
                <tr>
                    <td><br> <b>Precio: $ </b>
                        <?php echo $datos[3] ?>
                    </td>
                </tr>
            </div>
            </tr>
        </center>

        <?php } ?>
        <?php
        $querySubasta = "SELECT propiedades.nombre,propiedades.direccion, propiedades.descripcion, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion,subastas.ID as ID_subasta, subastas.estado as estado, subastas.precioBase, subastas.ID_propiedad as ID_propiedad, subastas.semana FROM `propiedades` INNER JOIN subastas ON propiedades.ID = subastas.ID_propiedad AND subastas.estado='DISPONIBLE' ORDER BY RAND() LIMIT 1";
        $consultaSubasta = mysqli_query($link, $querySubasta);
        if (mysqli_num_rows($consultaSubasta) > 0) {
            $filaSubasta = mysqli_fetch_array($consultaSubasta);
            ?>
            <div style=" width:50%">
            <center>
                <h2>Propiedad subastandose:</h2>

                <tr>
                    <!-- Abro una fila -->
                    <td>
                        <!--abro una columna muestro la FOTO-->
                        <br />
                        <img src=<?php echo $filaSubasta["foto"] ?> width="200" height="200">
                        <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                        <br />
                    </td>
                    <td>
                        <!--abro una columna y muestro todos los demas datos -->
                        <h3>
                            <strong>
                                <div align="center"> <?php echo $filaSubasta["nombre"] ?> </div>
                            </strong>
                      
                        </h3>
                        <br /> <!-- salto de linea -->
                        <td>
                            <br> <b>Descripcion: </b>
                            <p>
                                <?php echo $filaSubasta["descripcion"] ?>
                            </p>
                        </td>
                        <br /> <b>Direccion:</b>
                        <?php echo $filaSubasta["direccion"] ?>
                        <br /><b>Ciudad:</b>
                        <?php echo $filaSubasta["ciudad"] ?>
                        <b>  Provincia:</b>
                        <?php echo $filaSubasta["provincia"] ?>
                        <br /> <b>Pais:</b>
                        <?php echo $filaSubasta["pais"] ?>
                        <br />
                        <br/>
                        <b>Datos de la subasta:</b>
                        <br/>
                        <br /> <b>Semana a subastar:</b>
                        <?php echo $filaSubasta["semana"] ?>
                        <br />
                        <br /><b> Precio base: </b>$
                        <?php echo $filaSubasta["precioBase"] ?>
                        <br>
                       <?php
                        $idSubasta = $filaSubasta['ID_subasta'];
                        $queryPujas = "SELECT max(pujas.monto) FROM pujas INNER JOIN subastas ON subastas.ID = pujas.ID_subasta WHERE pujas.ID_subasta =$idSubasta ";
                        $consultaPujas = mysqli_query($link, $queryPujas);
                        if (mysqli_num_rows($consultaPujas) > 0) {
                            $filaPujas = mysqli_fetch_array($consultaPujas);
                            if ($filaPujas["max(pujas.monto)"] != null) {
                                ?>
                               <b> Puja mayor:</b> $<?php echo $filaPujas["max(pujas.monto)"];
                                            }
                                        } ?>
                    </td>
            </div>
            <!--cierro columna-->
            </center>
        <?php } ?>
       
    </div>
</body>

</html>
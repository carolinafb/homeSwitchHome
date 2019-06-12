<?php
session_start();
include 'conexion.php';
$link = conexion();

?>

<head> </head>
<title>Home Switch Home </title>
</head>

<body>
    <left>
        <a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a>
    </left>

    <?php
    if (isset($_SESSION['login'])) { // si la sesion es un admin muestra el alta de propiedad
        if ($_SESSION['rol'] == 'ADMINISTRADOR') {
            $queryPases = "SELECT usuario.nombre, usuario.apellido, usuario.ID, usuario.rol, solicitudpases.estado  FROM usuario INNER JOIN solicitudpases WHERE usuario.ID=solicitudpases.ID_Usuario "; //consulta a la base con solo datos q necesito
            $consultaPases = mysqli_query($link, $queryPases);
            if (mysqli_num_rows($consultaPases) > 0) { ?>
                <center>
                    <!-- centro la tabla -->
                    <table width="800">
                        <!-- comienza la tabla -->
                        <caption>
                            <h3> SOLICITUD DE PASES: </h3>
                        </caption><!-- titulo -->

                        <?php
                        while ($fila = mysqli_fetch_array($consultaPases)) { ?>
                            <!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
                            <!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->

                            <?php if ($fila["estado"] == "PENDIENTE") {    ?>
                                <tr>
                                    <!-- Abro una fila -->
                                    <td>
                                        <!--abro una columna  y muestro los datos de los usuarios-->
                                        <br />
                                        <h3>*************************</h3>
                                        <br />
                                        <?php echo "Nombre y Apellido: ", $fila["nombre"] ;?> 
                                        <?php echo " ",$fila["apellido"] ;?> 
                                        <br />
                                        <br />
                                        <?php echo "es usuario:",$fila["rol"], "y solicita el pase a:"; 
                                        if($fila["rol"]=='PREMIUM'){ echo "ESTANDAR";}else{ echo "PREMIUM";}?> 
                                        <br />
                                        <br />
                                        <?php echo "estado de la solicitud de pase: ", $fila["estado"] ;?> 
                                        <br />
                                        <br />
                                    </td>
                                    <td>
                                        <!--abro una columna y muestro todos los demas datos -->
                                      
                                    </td>
                                    <!--cierro columna-->
                                    <td>
                                        <!--abro columna para mostrar el aceptar -->
                                        <a href="aceptarPase.php?id=<?php echo $fila["id"] ?>">Aceptar pase</a> 
                                    </td>
                                </tr>
                            <?php } ?>

                        <?php
                    }
                    ?>
                    </table> <!-- fin de tabla -->
                </center>

            <?php }
    }
}  ?>



</body>
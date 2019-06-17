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
    if (isset($_SESSION['nombre'])) { // si la sesion es un admin muestra el alta de propiedad
        if ($_SESSION['rol'] == 'ADMINISTRADOR') {
            $queryPases = "SELECT usuario.nombre, usuario.apellido, usuario.ID as userID, usuario.rol, solicitudpases.estado, solicitudpases.ID as paseID  FROM usuario INNER JOIN solicitudpases WHERE usuario.ID=solicitudpases.ID_Usuario "; //consulta a la base con solo datos q necesito
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

                        while ($fila = mysqli_fetch_array($consultaPases)) {
                            //Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
                            //Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
                            $IDuser = $fila["userID"];
                            $IDSolicitud = $fila["paseID"];
                            if ($fila["estado"] == "PENDIENTE") { ?>

                                <tr>
                                    <!-- Abro una fila -->
                                    <td>
                                        <!--abro una columna  y muestro los datos de los usuarios-->
                                        <br />
                                        <br />
                                        <?php echo "Nombre y Apellido: ", $fila["nombre"], " ", $fila["apellido"]; ?>
                                        <br />
                                        <br />
                                        <?php echo "es usuario: ", $fila["rol"], " y solicita el pase a:";
                                        if ($fila["rol"] == 'PREMIUM') {
                                            echo "ESTANDAR";
                                        } else {
                                            echo "PREMIUM";
                                        } ?>
                                        <br />
                                        <br />
                                        <?php echo "estado de la solicitud de pase: ", $fila["estado"]; ?>
                                        <br />
                                    </td>
                                    <td>
                                        <!--abro columna para mostrar el aceptar -->
                                        <a href="aceptarPase.php?idUser=<?php echo $IDuser ?>&idPase=<?php echo $IDSolicitud ?>">Aceptar pase</a>
                                    </td>

                                <?php
                            } ?>

                                <?php if ($fila == NULL or $fila == 'HABILITADA') { // ESTO DEL HABILITADA NO ESTOY SEGRA DESPUES LO MIRO
                                    echo "Sin solicitudes pentientes";
                                }
                                ?>

                            <?php } ?>


                    </table> <!-- fin de tabla -->

                </center>

            <?php } ?>
            <center>
                <tr>
                    <?php if ($fila == NULL) {
                        echo " No hay mas solicitudes de pases "; ?>
                        <button type="button" onclick=" location.href='index.php' "> Volver </button>
                    <?php } ?>
                </tr>
                <br />
            </center>
        <?php }
}  ?>



</body>
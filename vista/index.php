<?php
include_once("../configuracion.php");
$session = new Sesion();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angel Wings Jewelry</title>
    <link rel="icon" href="../vista/assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("./estructura/bootstrap.php"); ?>
    <link rel="stylesheet" href="./css/estilos.css">
    <!---- fontawesome ---->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include_once("./estructura/cabecera.php"); ?>
    <main>
        <img src="https://tomaprimera.es/wp-content/uploads/2023/03/tipos-de-anillos-de-compromiso-1.jpg" height="50%" width=100%/>
        <h3>Quienes somos?</h3>
        <p>Somos una empresa dedicada a la venta de anillos, de plata y de oro. Con m&aacute;s de 45 años de trayectoria, los clientes nos eligen para marcar tendencia y sentirse felices</p>
    </main>

    <?php include_once("./estructura/footer.php"); ?>
</body>

</html>
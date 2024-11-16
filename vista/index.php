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
</head>

<body>
    <?php include_once("./estructura/cabecera.php"); ?>
    <main>
        <h1>Pagina pública</h1>
        <p>Esta es la página principal de la tienda de anillos</p>
    </main>

    <?php include_once("./estructura/footer.php"); ?>
</body>

</html>
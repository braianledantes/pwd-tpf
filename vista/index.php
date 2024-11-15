<?php
include_once("../configuracion.php");
$session = new Session();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angel Wings Jewelry</title>
    <link rel="icon" href="../favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("./estructura/bootstrap.php"); ?>

    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <?php
    if ($session->esAdministrador()) {
        include_once("./estructura/cabecera-admin.php");
    } else if ($session->esCliente()) {
        include_once("./estructura/cabecera-cliente.php");
    } else {
        include_once("./estructura/cabecera-publica.php");
    }
    ?>
    <main>
        <h1>Pagina pública</h1>
        <p>Esta es la página principal de la tienda de anillos</p>
    </main>

    <?php include_once("./estructura/footer.php"); ?>
</body>

</html>
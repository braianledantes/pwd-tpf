<?php include_once("../../configuracion.php");
$session = new Sesion();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los productos</title>
    <link rel="icon" href="../../favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php
    if ($session->esAdministrador()) {
        include_once("../estructura/cabecera-admin.php");
    } else if ($session->esCliente()) {
        include_once("../estructura/cabecera-cliente.php");
    } else {
        include_once("../estructura/cabecera-publica.php");
    }
    ?>

<h2>Productos</h2>

<table border>  
    <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Stock</th>
                </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Nombre1</td>
                <td>Descripcion1</td>
                <td>Stock1</td>
            </tr>
        </tbody>
</table>

    <?php include_once("../estructura/footer.php"); ?>
</body>

</html>

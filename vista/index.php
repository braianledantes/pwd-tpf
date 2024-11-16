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
    <!-- Carrusel -->
     <section style=" margin-top:-17px;">
     <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button id="tienda"type="button"><a href="./productos/index.php">Ver productos!</a></button>
            </div>
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./assets/imagenes/anillo1.png" class=" w-100" alt="Anillo de alas plateado">
                </div>
                <div class="carousel-item ">
                    <img src="./assets/imagenes/anillo2.png" class=" w-100" alt="Anillo de corazon gema">
                </div>
                <div class="carousel-item">
                    <img src="./assets/imagenes/anillo3.png" class=" w-100" alt="Anillo de ala de angel">
                </div>
            </div>
        </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
    <div id="info"><p>¡Despachamos todos los días hábiles para que reciba el producto cuanto antes!</p></div>
     </section>
<?php include_once("./estructura/footer.php"); ?>
</body>

</html>
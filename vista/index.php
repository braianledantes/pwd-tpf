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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <!---- fontawesome ---->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include_once("./estructura/cabecera.php"); ?>
    <!-- Carrusel -->
     <section style=" margin-top:-30px;">
     <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" style="border-radius: 3rem;padding:20px; margin:570px 100px;width:600px; background-color:lightgrey;border:1px solid black;color: #001220"><a href="./productos/index.php">Mira nuestros productos!</a></button>
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
     </section>
<?php include_once("./estructura/footer.php"); ?>
</body>

</html>
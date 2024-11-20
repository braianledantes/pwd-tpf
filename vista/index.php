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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        // Llamar a la función que actualiza el contador del carrito cuando la página carga
            actualizarContadorCarrito();
        });
    </script>
</head>

<body>
    <?php include_once("./estructura/cabecera.php"); ?>
    <!-- Carrusel -->
     <section style="margin-top:-17px;">
        <div id="carouselExample" class="carousel" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

            <!-- Slides -->
        <div class="carousel-inner ">
            <div class="carousel-item">
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 500px; background-color: #f8f9fa;">
                <img src="./assets/imagenes/anillo1.png" class=" w-100" alt="Anillo de alas plateado">
                     <button class="btn btn-outline-dark" style="position: absolute; top:20%; left: 50%; transform: translate(-50%, -50%);z-index:-1">Ver productos</button>
                </div>
            </div>
            <div class="carousel-item active">
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 500px; background-color: #e9ecef;">
                    <img src="./assets/imagenes/anillo2.png" class=" w-100" alt="Anillo de corazon gema">
                    <p style="font-weight:bolder;font-size:larger;color:#e9ecef;position: absolute; top: 10%; left: 22%; transform: translate(-50%, -50%); z-index:10">Descubre nuestras nuevas joyas!</p>
                    <button class="btn btn-outline-dark rounded-pill px-4" style="position: absolute; top: 20%; left: 16%; transform: translate(-50%, -50%);"> <a class="text-decoration-none" href="./listaProductos/index.php" style="color:white;font-weight:bold;">Comprar Ya!</a></button>
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 500px; background-color: #dee2e6;">
                    <img src="./assets/imagenes/anillo3.png" class=" w-100" alt="Anillo de ala de angel">
                    <button class="btn btn-outline-dark" style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); z-index:-1">Ver productos</button>
                </div>
            </div>
        </div>

         <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

     </section>
     <div id="info"><p>¡Despachamos todos los días hábiles para que reciba el producto cuanto antes!</p></div>
     <script src="./js/app.js"></script>
    <?php include_once("./estructura/footer.php"); ?>
</body>

</html>
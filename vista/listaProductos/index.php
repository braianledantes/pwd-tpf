<?php
include_once("../../configuracion.php");

// Verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() /*|| !$session->tieneAccesoAMenuActual()*/) {
    header("Location: ../login");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <!-- JQuery -->
    <?php include_once("../estructura/jquery.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>
    <main>
        <h2 class="mt-3">Nuestros Anillos</h2>
        <hr style="width: 500px;margin: 0 auto;">
        <section id="lista" class="mt-5 mb-5"></section>
    </main>
    <?php include_once("../estructura/footer.php"); ?>

    <script>
        $(document).ready(function() {
            mostrarLista();
        });

        function mostrarLista() {
            $.ajax({
                type: "GET",
                url: "./accionListar.php",
                success: function(result) {
                    //console.log("Respuesta del servidor:", result);
                    const data = result.data;
                    let contenido = `<div class="row">`;
                    //console.log("Productos:", data);
                    if (data.length === 0) {
                        contenido = '<h2>No hay productos cargados</h2>';
                    } else {
                        data.forEach(producto => {
                            // Acción de compra
                            const accionComprar = `
                            <a href="./comprar.php?idproducto=${producto.idproducto}" class='btn btn-success btn-sm btn-block'>
                                Comprar
                            </a>
                            `;
                            contenido += `
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <img src="${producto.prourlimagen}" class="card-img-top" alt="${producto.pronombre}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">${producto.pronombre}</h5>
                                        <p class="card-text">${producto.prodetalle}</p>
                                        <p class="card-text"><strong>Stock:</strong> ${producto.procantstock}</p>
                                        <p class="card-text"><strong>Precio:</strong> $${producto.proprecio}</p>
                                        <div class="d-flex justify-content-between">
                                            ${accionComprar}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    }

                    contenido += `</div>`;
                    $("#lista").html(contenido);
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }
    </script>
</body>

</html>

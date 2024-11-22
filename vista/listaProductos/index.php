<?php
include_once("../../configuracion.php");

// Verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header('Location: ../login?messageErr=' . urlencode('Debe Inciar Sesion para poder ver los Productos.'));
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
        <section id="lista" class="container mt-5 mb-5"></section>
    </main>
    <?php include_once("../estructura/footer.php"); ?>

    <script>
        $(document).ready(function() {
            mostrarLista();
            actualizarContadorCarrito();
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
                             // Lógica para mostrar "Comprar" o "Sin stock"
                            let accionComprar = '';
                            let mensajeSinStock = '';

                            if (producto.procantstock > 0) {
                                accionComprar = `
                                <a onclick="agregarACarrito(${producto.idproducto}, this)" class='comprar btn btn-outline-dark btn-sm btn-block  px-5 rounded-pill'>
                                    Comprar
                                </a>
                                `;
                            } else {
                                mensajeSinStock = `
                                <div class="overlay">
                                    <p class="stock text-center">Sin stock!</p>
                                </div>
                                `;
                            }

                            contenido += `
                            <div class="col">
                                <div class="card h-100">
                                    <img src="${producto.prourlimagen}" class="card-img-top" alt="${producto.pronombre}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body display ">
                                        <h5 class="nombre card-title">${producto.pronombre}</h5>
                                        <p class="detalle card-text">${producto.prodetalle}</p>
                                        <p class="precio card-text"><strong>$${producto.proprecio}</strong></p>
                                        <div class="mt-auto"> <!-- mt-auto asegura que el botón de comprar esté al fondo -->
                                            ${accionComprar}
                                            ${mensajeSinStock}
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

        function agregarACarrito(idproducto, buttonElement) {
        $.ajax({
            type: "POST",
            url: "./accionAgregarACarrito.php",
            data: { idproducto: idproducto },
            success: function(result) {
                console.log("Respuesta del servidor:", result);
                if (result.status === "success") {
                    $(buttonElement).text("Producto Agregado")
                                .attr("disabled", true) 
                                .removeClass('btn-outline-dark')
                                .addClass('btn-secondary') 
                                .off('click'); 
                    $(buttonElement).removeAttr("onclick"); 

                    // Actualizar el contador de productos en la cabecera
                    actualizarContadorCarrito();
                } else {
                    console.log("Error al agregar el producto al carrito");
                }
            },
            error: function(result) {
                console.error(result);
            }
        });
    }
    </script>
    <script src="../js/app.js"></script>
</body>

</html>

<?php
include_once("../../configuracion.php");

// Verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angel Wings Jewelry</title>
    <link rel="icon" href="../vista/assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

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
        <div class="container">

            <h2 class="mt-3">Carrito de compras</h2>
            <hr style="width: 500px;margin: 0 auto;">
            <section id="lista" class="mt-5 mb-5">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button class="btn btn-danger" onclick="vaciarCarrito()">Vaciar carrito</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" onclick="iniciarCompra()">Iniciar compra</button>
                                    </td>
                                
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>


        </div>

    </main>

    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            mostrarCarrito();
        });

        function mostrarCarrito() {
            $.ajax({
                type: "GET",
                url: "./accionObtenerCarrito.php",
                success: function(result) {
                    const data = result.data;
                    let contenido = `<div class="row">`;

                    if (data.items.length !== 0) {
                        data.items.forEach(item => {

                            // Acción de aumentar cantidad
                            const accionAumentarCantidad = `
                            <button class='btn btn-primary btn-sm' onclick='aumentarCantidad(${item.producto.idproducto})'>
                                <i class="fas fa-plus"></i>
                            </button>
                            `;
                            // Acción de disminuir cantidad
                            const accionDisminuirCantidad = `
                            <button class='btn btn-danger btn-sm' onclick='disminuirCantidad(${item.producto.idproducto})'>
                                <i class="fas fa-minus"></i>
                            </button>
                            `;
                            // Acción de eliminar producto
                            const accionEliminarProducto = `
                            <button class='btn btn-danger btn-sm' onclick='eliminarProducto(${item.producto.idproducto})'>
                                <i class="fas fa-trash"></i>
                            </button>
                            `;
                            contenido += `
                            <tr>
                                <td>
                                    <img src="${item.producto.prourlimagen}" alt="${item.producto.pronombre}" style="height: 50px; object-fit: cover;">
                                    ${item.producto.pronombre}
                                </td>
                                <td>$${item.producto.proprecio}</td>
                                <td>${item.cantidad}</td>
                                <td>$${item.subtotal}</td>
                                <td>
                                    ${accionAumentarCantidad}
                                    ${accionDisminuirCantidad}
                                    ${accionEliminarProducto}
                                </td>
                            </tr>
                            `;
                        });
                    }

                    contenido += `</div>`;
                    $("tbody").html(contenido);

                    // Total
                    const total = `<tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>$${data.total}</td>
                        <td></td>
                    </tr>`;
                    $("tbody").append(total);
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function aumentarCantidad(idproducto) {
            $.ajax({
                type: "GET",
                url: "./aumentarCantidad.php",
                data: {
                    idproducto: idproducto
                },
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarCarrito();
                    } else {
                        alert(result.data);
                    }
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function disminuirCantidad(idproducto) {
            $.ajax({
                type: "GET",
                url: "./disminuirCantidad.php",
                data: {
                    idproducto: idproducto
                },
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarCarrito();
                    } else {
                        alert(result.data);
                    }
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function eliminarProducto(idproducto) {
            $.ajax({
                type: "GET",
                url: "./accionEliminiarDelCarrito.php",
                data: {
                    idproducto: idproducto
                },
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarCarrito();
                    } else {
                        alert(result.data);
                    }
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function vaciarCarrito() {
            $.ajax({
                type: "GET",
                url: "./accionVaciarCarrito.php",
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarCarrito();
                    } else {
                        alert(result.data);
                    }
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function iniciarCompra() {
            $.ajax({
                type: "GET",
                url: "./accionIniciarCompra.php",
                success: function(result) {
                    if (result.status === 'success') {
                        window.location.href = "./compra";
                    } else {
                        alert(result.data);
                    }
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }
    </script>
</body>

</html>
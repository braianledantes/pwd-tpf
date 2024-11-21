<?php include_once("../../configuracion.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angel Wings Jewelry</title>
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <!-- JQuery -->
    <?php include_once("../estructura/jquery.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
    <!---- fontawesome ---->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>

    <main class="contenedor mt-5 mb-5">
    <div class="base w-100 row" style="margin:0 auto;">
        <!-- Form de compra -->
        <div class="pagoForm col-md-7 bg-white border card-shadow-lg" style="padding:60px; margin-right:20px;">
            <h2>Detalles de la compra</h2>
            <div class="pago mt-5 mb-3">
                <h5 class="mb-3">Seleccione Tipo de <span class="text-primary">Tarjeta</span></h5>
                <a href="#!" type="submit" class="text-dark" tabindex="0"><i class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                <a href="#!" type="submit" class="text-dark" tabindex="0"><i class="fab fa-cc-visa fa-2x me-2"></i></a>
                <a href="#!" type="submit" class="text-dark" tabindex="0"><i class="fab fa-cc-amex fa-2x me-2"></i></a>
                <a href="#!" type="submit" class="text-dark" tabindex="0"><i class="fab fa-cc-paypal fa-2x"></i></a>
            </div>

            <form id="pago">

                <div class="w-100 row">
                    <div class="col-md-4  mt-3">
                        <div class="form-floating">
                        <input type="text" name="nombreapellido" id="nombreapellido" class="form-control form-control-lg" siez="17" placeholder="Nombre y Apellido" required/>
                        <label class="form-label" for="nombreapellido">Nombre y Apellido</label>
                        </div>
                    </div>
                    <div class="col-md-8 mt-3">
                        <div class="form-floating">
                        <input type="text" name="numtarjeta" id="numtarjeta" class="form-control form-control-lg" siez="17" placeholder="1234 5678 9012 3456" minlength="16" maxlength="16" required />
                        <label class="form-label" for="numtarjeta">Número de tarjeta</label>
                        </div>
                    </div>

                </div>
                <div class="w-100 row">
                    <div class="col-md-8 mt-3">
                        <div class="form-floating">
                        <input type="text" name="vencimiento" id="vencimiento" class="form-control form-control-lg" placeholder="MM/AAAA" size="7" id="exp" minlength="7" maxlength="7" required/>
                        <label class="form-label" for="vencimiento">Vencimiento</label>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-floating">
                        <input type="password" name="codigo" id="codigo" class="form-control form-control-lg" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" required />
                        <label class="form-label" for="typeText">Código de seguridad</label>
                        </div>
                    </div>

                </div>

                <div class="mt-4 mb-3">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark rounded-pill" onclick="iniciarCompra()">Pagar</button>
                    </div>
                </div>
                
            </form>
        </div>
        
        <!--Resumen de Compra-->
        <div class="resumenCompra col-md-4 bg-white border card-shadow-lg" style="padding:60px;">
            <h2>Mi Compra</h2>
            <hr class="w-50" style="margin:0 auto;">
            <div class="row mt-4">
            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
            </table>
            <div>
        </div>
    </div>
    </main>

    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            mostrarCarrito();
            actualizarContadorCarrito();
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
                            contenido += `
                            <tr>
                                <td>
                                    <img src="${item.producto.prourlimagen}" alt="${item.producto.pronombre}" style="height: 50px; object-fit: cover;">
                                    ${item.producto.pronombre}
                                </td>
                                <td>$${item.producto.proprecio}</td>
                                <td>${item.cantidad} </td>
                                <td>$${item.subtotal}</td>
                            </tr>
                            `;
                        });
                    }

                    contenido += `</div>`;
                    $("tbody").html(contenido);

                    // Total
                    const total = `<tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td class="total">$${data.total}</td>
                        <td></td>
                    </tr>`;
                    $("tbody").append(total);
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
                        window.location.href = "./inicioCompra.php";
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
    <script src="../js/app.js"></script>
    <script src="../js/validaciones.js"></script>
</body>

</html>
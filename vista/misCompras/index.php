<?php include_once("../../configuracion.php") ?>

<!DOCTYPE html>
<html lang="es">

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
    <!---- fontawesome ---->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>

    <main>
        <div class="container">

            <h2 class="mt-3">Estado de Compras</h2>
            <hr style="width: 500px;margin: 0 auto;">
            <section id="historialCompras">

            </section>
        </div>
    </main>

    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            cargarEstadoCompra();
        });

        function cargarEstadoCompra() {
            $.ajax({
                url: './accionListar.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        let html = '';
                        response.data.forEach(function(compra) {
                            const ultimoEstado = compra.ultimoestado.compraestadotipo;
                            html += `
                            <div class="compraEstado">
                                <p><strong>Compra ID:</strong> ${compra.idcompra}</p>
                                <p><strong>Fecha de Inicio:</strong> ${compra.cofecha}</p>
                                <p><strong>Último estado:</strong> ${ultimoEstado.cetdescripcion} - ${compra.ultimoestado.cefechaini}</p>`;

                            if (ultimoEstado.idcompraestadotipo < 3) {
                                html += `<button class="btn btn-danger" onclick="cancelarCompra(${compra.idcompra})">Cancelar Compra</button>`
                            }

                            html += `</div>
                        <hr>`;
                        });
                        $('#historialCompras').html(html);
                    } else {
                        $('#historialCompras').html('<p>No se encontraron estados de compra.</p>');
                    }
                },
                error: function() {
                    $('#historialCompras').html('<p>Error al cargar los datos.</p>');
                }
            });
        }

        function cancelarCompra(idcompra) {
            // desactiva el boton y cambia el texto
            const boton = $(event.target);
            boton.prop('disabled', true);
            boton.text('Cancelando...');

            $.ajax({
                url: './accionCancelarCompra.php',
                type: 'POST',
                data: {
                    idcompra: idcompra
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.status == 'success') {
                        cargarEstadoCompra();
                    } else {
                        alert('Error al cancelar la compra');
                    }
                },
                error: function() {
                    alert('Error al cancelar la compra');
                }
            });
        }
    </script>

</body>

</html>
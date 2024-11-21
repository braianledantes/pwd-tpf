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
        console.log('Página cargada, iniciando pAJAX...');
        $.ajax({
            url: './accionEstadoCompra.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                if (response.success) {
                    let html = '';
                    response.data.forEach(function(estado) {
                        html += `
                            <div class="compraEstado">
                                <p><strong>Compra ID:</strong> ${estado.idcompra}</p>
                                <p><strong>Estado:</strong> ${estado.estado}</p>
                                <p><strong>Fecha de Inicio:</strong> ${estado.cefechaini}</p>
                                <p><strong>Fecha de Fin:</strong> ${estado.cefechafin || 'N/A'}</p>
                            </div>
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
</script>

</body>

</html>
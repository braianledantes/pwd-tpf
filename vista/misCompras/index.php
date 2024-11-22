<?php
include_once("../../configuracion.php");

// Verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header('Location: ../login?messageErr=' . urlencode('Debe Inciar Sesion para acceder a esta página.'));
}
?>

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
        <div class="container w-75">

            <h2 class="mt-3">Estado de Compras</h2>
            <hr style="width: 500px;margin: 0 auto;">
            <section id="historialCompras" class="mt-5">

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
                            <table class="compraEstado w-75 table table-light table-striped table-borderless mb-5" style="border-radius: 2rem;border-collapse: separate;box-shadow: 0 0 5px grey;overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th>Compra ID</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Ultimo Estado</th>
                                        <th>Fecha Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${compra.idcompra}</p></td>
                                        <td>${compra.cofecha}</p></td>
                                        <td>${ultimoEstado.cetdescripcion}</td>
                                        <td>${compra.ultimoestado.cefechaini}</td>
                                    </tr>
                                </tbody>`;
                    
                            if (ultimoEstado.idcompraestadotipo == 1) {
                                html += `<tr><td colspan="4"><button class="btn btn-danger rounded-pill px-5" onclick="cancelarCompra(${compra.idcompra})">Cancelar Compra</button></td></tr>`
                            }

                            html += `</table>`;
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
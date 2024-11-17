<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <!-- JQuery -->
    <?php include_once("../estructura/jquery.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>
    <main>
        <!-- formulario de modificacion de menu -->
        <div class="w-75 mx-auto mt-3 mb-5">
            <div class="row">
                <h1>Alta de Producto</h1>
            </div>
            <div class="row">
                <form id="form" action="./accionAlta.php" method="POST" enctype="multipart/form-data" class="col-md-11 mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="nombre" name="pronombre" type="text" placeholder="Nombre" required>
                                <label for="nombre">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="detalle" name="prodetalle" type="text" placeholder="Detalle" required>
                                <label for="detalle">Detalle</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4">
                            <div class="form-floating">
                                <input class="form-control" id="precio" name="proprecio" type="number" placeholder="Precio"  required>
                                <label for="precio">Precio</label>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                            <div class="form-floating">
                                <input class="form-control" id="stock" name="procantstock" type="number" placeholder="Stock"  required>
                                <label for="stock">Stock</label>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- imagen del producto -->
                    <div class="mb-3 mt-5">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="proimagen">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-dark mt-3">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('#form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = './';
                        } else {
                            alert(response.data);
                        }
                    },
                    error: function() {
                        alert('Error al crear el producto');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                
            });
        });
    </script>
</body>

</html>
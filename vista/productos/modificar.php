<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y sea administrador
$session = new Sesion();
if (!$session->estaActiva()) {
    header("Location: ../index.php");
}

if (!$session->esAdministrador()) {
    header('Location: ../');
    exit;
}

$data = data_submitted();

$producto = null;
try {
    $idproducto = $data['idproducto'];
    if (!isset($idproducto)) {
        throw new Exception("Falta el id del producto");
    }

    $abmproducto = new ABMproducto();
    $listaproducto = $abmproducto->buscar(['idproducto' => $idproducto]);
    if (empty($listaproducto)) {
        throw new Exception("El producto no existe");
    }
    $producto = $listaproducto[0];
} catch (Exception $e) {
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
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>
    <main>
        <!-- formulario de modificacion de menu -->
        <div class="container">
            <div class="row">
                <h1>Modificación de Producto <?= $producto->getidproducto() ?> </h1>
            </div>
            <div class="row">
                <form id="form" action="./accionModificar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idproducto" value="<?= $producto->getidproducto() ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="pronombre" value="<?= $producto->getusnombre() ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="detalle" class="form-label">Detalle</label>
                        <input type="text" class="form-control" id="detalle" name="prodetalle" value="<?= $producto->getprodetalle() ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="proprecio" value="<?= $producto->getproprecio() ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="procantstock" value="<?= $producto->getprocantstock() ?>" required>
                    </div>
                    <!-- imagen del producto -->
                    <div class="mb-3">
                        <img src="<?= $producto->getprourlimagen() ?>" alt="imagen del producto" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="proimagen">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Modificar</button>
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
                        alert('Error al modificar el producto');
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
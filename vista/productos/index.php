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
    <title>Productos</title>
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
    <main>
        <h2 class="mt-3">ABM de Productos</h2>
        <a href="./alta.php" class="btn btn-dark mt-3">+Crear producto</a>
        <section id="lista">

        </section>
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
                    const data = result.data;
                    let contenido = `
                    <div class="contenedor mb-5">
                    <table class='table table-light table-striped table-borderless' style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Detalle</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (data.length === 0) {
                        contenido = '<h2>No hay menús cargados</h2>';
                    } else {
                        data.forEach(producto => {
                            const acciones = `
                            <a href="./modificar.php?idproducto=${producto.idproducto}" class='btn circle-icon rounded-circle'><i class="bi bi-pen "></i></a>
                            <a onclick="eliminar(${producto.idproducto})" class='btnEliminar btn btn-danger btn-sm rounded-circle'><i class='bi bi-trash3-fill'></i></a>
                            `;
                            contenido += `
                            <tr>
                                <td><img src="${producto.prourlimagen}" width="100"></td>
                                <td>${producto.idproducto}</td>
                                <td>${producto.pronombre}</td>
                                <td>${producto.prodetalle}</td>
                                <td>${producto.procantstock}</td>
                                <td>${producto.proprecio}</td>
                                <td>${acciones}</td>
                            </tr>`;
                        });
                    }
                    contenido += `
                        </tbody>
                    </table>
                    </div>`;
                    $("#lista").html(contenido);
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function eliminar(idproducto) {
            if (confirm("¿Está seguro que desea eliminar el producto?")) {
                $.ajax({
                    type: "GET",
                    url: "./accionBaja.php",
                    data: {
                        idproducto: idproducto
                    },
                    success: function(result) {
                        if (result.status === 'success') {
                            alert("Producto eliminado correctamente");
                            mostrarLista();
                        } else {
                            alert("Error al eliminar el producto");
                        }
                    },
                    error: function(result) {
                        console.error(result);
                    }
                });
            }
        }
    </script>
</body>

</html>
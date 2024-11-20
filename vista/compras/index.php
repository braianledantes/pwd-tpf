<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() /*|| !$session->tieneAccesoAMenuActual()*/) {
    header("Location: ../login");
}

$abmCompra = new ABMCompra();
$lista = $abmCompra->buscar(null);
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
        <div class="container">
            <h2 class="mt-3">Compras</h2>
            <section id="lista">
                <table class='table table-light table-striped table-borderless' style="margin-top: 30px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Id Usuario</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        
                    </tbody>
                </table>
            </section>
        </div>

    </main>

    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            mostrarLista();
        });

        function mostrarLista() {
            $.ajax({
                url: './accionListar.php',
                type: 'GET',
                success: function(response) {
                    if (response.status == 'success') {
                        let lista = response.data;
                        $('#tbody').empty();
                        lista.forEach(compra => {
                            let tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${compra.idcompra}</td>
                                <td>${compra.objusuario.idusuario}</td>
                                <td>${compra.cofecha}</td>
                                <td>
                                    <a href="./modificar.php?idcompra=${compra.idcompra}" class="btn btn-primary">Modificar</a>
                                </td>
                            `;
                            $('#tbody').append(tr);
                        });

                    } else {
                        alert(response.data);
                    }
                },
                error: function() {
                    alert('Error al cargar la lista de compras');
                }
            });
        }

        function modificarEstado(idcompra, idcompraestadotipo) {
            $.ajax({
                url: './accionModificar.php',
                type: 'GET',
                data: {
                    idcompra: idcompra,
                    idcompraestadotipo: idcompraestadotipo
                },
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Compra actualizada');
                        mostrarLista();
                    } else {
                        alert(response.data);
                    }
                },
                error: function() {
                    alert('Error al modificar la compra');
                }
            });
        }
    </script>
</body>

</html>
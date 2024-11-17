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
    <title>Roles</title>
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
        <h2 class="mt-3">ABM de Roles</h2>
        <a href="./alta.php" class="btn btn-dark mt-3">Crear Rol</a>
        <section id="listaMenus">

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
                    <div class="mx-auto w-50 mb-5">
                    <table class='table table-light table-striped table-borderless' style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Descripcion</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (data.length === 0) {
                        contenido = '<h2>No hay menús cargados</h2>';
                    } else {
                        data.forEach(rol => {
                            const acciones = `
                            <a href="./modificar.php?idrol=${rol.idrol}" class='btn circle-icon rounded-circle'><i class="bi bi-pen "></i></a>
                            <a onclick="eliminar(${rol.idrol})" class='btn btn-danger btn-sm rounded-circle'><i class='bi bi-trash3-fill'></i></a>
                            `;
                            contenido += `
                            <tr>
                                <td>${rol.idrol}</td>
                                <td>${rol.rodescripcion}</td>
                                <td>${acciones}</td>
                            </tr>`;
                        });
                    }
                    contenido += `
                        </tbody>
                    </table>`;
                    $("#listaMenus").html(contenido);
                },
                error: function(result) {
                    console.error(result);
                }
            });
        }

        function eliminar(idrol) {
            if (confirm("¿Está seguro que desea eliminar el rol?")) {
                $.ajax({
                    type: "GET",
                    url: "./accionBaja.php",
                    data: {
                        idrol
                    },
                    success: function(result) {
                        if (result.status === 'success') {
                            alert("Rol eliminado correctamente");
                            mostrarLista();
                        } else {
                            alert("Error al eliminar el rol");
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
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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menus</title>
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
        <h2>ABM de Menús</h2>
        <a href="./alta.php" class="btn btn-dark mt-3">Crear Menú</a>
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
                    <table border>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Id padre</th>
                                <th>Roles</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (data.length === 0) {
                        contenido = '<h2>No hay menús cargados</h2>';
                    } else {
                        data.forEach(menu => {
                            const roles = menu.roles.map(rol => rol.rodescripcion).join(', ');

                            const acciones = `
                            <a href="..${menu.medescripcion}" class="btn btn-info">Ver</a>
                            <a href="./modificar.php?idmenu=${menu.idmenu}" class='btn circle-icon rounded-circle'><i class="bi bi-pen "></i></a>
                            <a onclick="eliminar(${menu.idmenu})" class='btnEliminar btn btn-danger btn-sm rounded-circle'><i class='bi bi-trash3-fill'></i></a>
                            `;
                            contenido += `
                            <tr>
                                <td>${menu.idmenu}</td>
                                <td>${menu.menombre}</td>
                                <td>${menu.medescripcion}</td>
                                <td>${menu.idpadre}</td>
                                <td>${roles}</td>
                                <td>${acciones}</td>
                            </tr>`;
                        });
                    }
                    contenido += `
                        </tbody>
                    </table>`;
                    $("#listaMenus").html(contenido);
                }
            });
        }

        function eliminar(idmenu) {
                if (confirm("¿Está seguro que desea eliminar el menú?")) {
                    $.ajax({
                        type: "GET",
                        url: "./accionBaja.php",
                        data: {
                            idmenu: idmenu
                        },
                        success: function(result) {
                            if (result.status === 'success') {
                                alert("Menú eliminado correctamente");
                                mostrarLista();
                            } else {
                                alert("Error al eliminar el menú");
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
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
        <h1>Pagina de ABM de Roles</h1>
        <a href="./alta.php" class="btn btn-primary">Crear Rol</a>
        <section id="listaMenus">

        </section>
    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
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
                            <a href="./modificar.php?idrol=${rol.idrol}" class="btn btn-warning">Modificar</a>
                            <a href="./accionBaja.php?idrol=${rol.idrol}" class="btn btn-danger">Eliminar</a>
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
        });
    </script>
</body>

</html>
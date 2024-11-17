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
<<<<<<< HEAD
        <h2>Pagina de ABM de menús</h2>
=======
        <h1>Pagina de ABM de Menús</h1>
        <a href="./alta.php" class="btn btn-dark mt-3">Crear Menú</a>
>>>>>>> ad006f876cc4a12ff895b13c610df1a1dcafd7a4
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
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Id padre</th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (data.length === 0) {
                        contenido = '<h2>No hay menús cargados</h2>';
                    } else {
                        data.forEach(element => {
<<<<<<< HEAD
                            // crear un article con cada elemento menu

                            
                            // TODO: tienen que estar en una tabla

                            contenido += `<article class="card col-12 col-md-6 col-lg-4">
                            <div id="listaMenus" class="row">
                            <a href="..${element['medescripcion']}">
                                <div class="card-body">
                                    <h5 class="card-title">${element['menombre']}</h5>
                                    <a href="./accionModificar.php?idmenu=${element['idmenu']}" class="btn btn-primary">Modificar</a>
                                    <a href="./accionEliminar.php?idmenu=${element['idmenu']}" class="btn btn-danger">Eliminar</a>
                                </div>
                            </a>
                            </div>
                            </article>`;
=======
                            const menu = element.objMenu;
                            const rol = element.objrol;
>>>>>>> ad006f876cc4a12ff895b13c610df1a1dcafd7a4

                            const acciones = `
                            <a href="..${menu.medescripcion}" class="btn btn-info">Ver</a>
                            <a href="./modificar.php?idmenu=${menu.idmenu}" class="btn btn-warning">Modificar</a>
                            <a href="./accionBaja.php?idmenu=${menu.idmenu}" class="btn btn-danger">Eliminar</a>
                            `;
                            contenido += `
                            <tr>
                                <td>${menu.idmenu}</td>
                                <td>${menu.menombre}</td>
                                <td>${menu.medescripcion}</td>
                                <td>${menu.idpadre}</td>
                                <td>${rol.rodescripcion}</td>
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
        });
    </script>
</body>

</html>
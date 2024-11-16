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
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>
    <main>
        <h1>Pagina de ABM de menús</h1>
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
                    console.log(data);
                    let contenido = '';
                    if (data.length === 0) {
                        contenido = '<h2>No hay menús cargados</h2>';
                    } else {
                        data.forEach(element => {
                            // crear un article con cada elemento menu

                            
                            // TODO: tienen que estar en una tabla

                            contenido += `<article class="card col-12 col-md-6 col-lg-4">
                            <a href="..${element['medescripcion']}">
                                <div class="card-body">
                                    <h5 class="card-title">${element['menombre']}</h5>
                                    <a href="./accionModificar.php?idmenu=${element['idmenu']}" class="btn btn-primary">Modificar</a>
                                    <a href="./accionEliminar.php?idmenu=${element['idmenu']}" class="btn btn-danger">Eliminar</a>
                                </div>
                            </a>
                            </article>`;

                        });
                    }
                    $("#listaMenus").html(contenido);
                }
            });
        });
    </script>
</body>

</html>
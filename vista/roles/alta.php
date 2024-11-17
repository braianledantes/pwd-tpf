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
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>
    <main>
        <div class="w-50 mx-auto mt-3 mb-5">
            <div>
                <h1 class="mt-3">Alta de Rol</h1>
            </div>
            <div>
                <form id="form" class="w-25 mx-auto mt-4" action="./accionAlta.php" method="POST">
                    <div class="mb-3">
                        <div class="form-floating">
                                <input class="form-control" id="descripcion" name="rodescripcion" type="text" placeholder="Descripcion" required>
                                <label for="descripcion">Descripcion</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Crear</button>
                </form>
            </div>
        </div>

    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('#form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "./accionAlta.php",
                    data: $(this).serialize(),
                    success: function(result) {
                        if (result.status === 'success') {
                            // redirige a la pagina de roles
                            window.location.href = "./";
                        } else {
                            alert(result.data);
                        }
                    },
                    error: function(result) {
                        console.error(result);
                    }
                });
            });
        });
    </script>
</body>

</html>
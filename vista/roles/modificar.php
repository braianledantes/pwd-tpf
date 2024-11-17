<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

$data = data_submitted();

$rol = null;
try {
    $idRol = $data['idrol'];
    if (!isset($idRol)) {
        throw new Exception("Falta el id del rol");
    }

    $abmRol = new ABMRol();
    $listaRol = $abmRol->buscar(['idrol' => $idRol]);
    if (empty($listaRol)) {
        throw new Exception("El rol no existe");
    }
    $rol = $listaRol[0];
} catch (Exception $e) {
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
        <!-- formulario de modificacion de menu -->
        <div class="w-50 mx-auto mt-3 mb-5">
            <div>
                <h1 class="mt-3">Modificación de Rol <?= $rol->getidrol() ?> </h1>
            </div>
            <div>
                <form id="form" class="w-25 mx-auto mt-4">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="hidden" name="idrol" value="<?= $rol->getidrol() ?>">
                                <input class="form-control" id="descripcion" name="rodescripcion" type="text" placeholder="Descripcion" value="<?= $rol->getrodescripcion() ?>" required>
                                <label for="descripcion">Descripcion</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Modificar</button>
                </form>
            </div>
        </div>
    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "./accionModificar.php",
                    data: $(this).serialize(),
                    success: function(result) {
                        window.location.href = "./";
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
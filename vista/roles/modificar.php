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
        <div class="container">
            <div class="row">
                <h1>Modificación de Rol <?= $rol->getidrol() ?> </h1>
            </div>
            <div class="row">
                <form id="form">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="rodescripcion" value="<?= $rol->getrodescripcion() ?>" required>
                        <input type="hidden" name="idrol" value="<?= $rol->getidrol() ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar</button>
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
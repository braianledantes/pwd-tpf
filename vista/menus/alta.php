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

$abmrol = new AbmRol();
$roles = $abmrol->buscar(null);

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
        <div class="container">
            <!-- formulario de alta de menu -->
            <div class="row">
                <h1>Alta de Menú</h1>
            </div>
            <div class="row">
                <form id="formCrearMenu" action="./accionAlta.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="menombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="descripcion" name="medescripcion" required value="" placeholder="/ejemplo">
                    </div>
                    <div class="mb-3">
                        <label for="idpadre" class="form-label">ID del menú Padre</label>
                        <input type="number" class="form-control" id="idpadre" name="idpadre">
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="idrol" required>
                            <option value="">Seleccione un rol</option>
                            <?php foreach ($roles as $rol) : ?>
                                <option value="<?= $rol->getIdrol() ?>"><?= $rol->getRodescripcion() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>

        </div>

    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('#formCrearMenu').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "./accionAlta.php",
                    data: $(this).serialize(),
                    success: function(result) {
                        if (result.status === 'success') {
                            // redirige a la pagina de menus
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
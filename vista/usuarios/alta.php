<?php
include_once '../../configuracion.php';
$datos = data_submitted();
// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

$abmrol = new AbmRol();
$roles = $abmrol->buscar(null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
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
    <div class="w-25 mx-auto mt-3 mb-5">
        <div class="row">
            <h1>Alta de Usuario</h1>
        </div>
        <div class="row">
            <form id="formCrearMenu" action="./accionAlta.php" method="POST">
                <div class="form-floating mt-3 mb-3">
                    <input class="form-control" id="nombre" name="usnombre" type="text" placeholder="Nombre" required>
                    <label for="nombre">Nombre</label>

                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="usmail" name="usmail" placeholder="ejemplo@ejemplo.com">
                    <label for="usmail">Correo Electrónico</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="uspass" required value="" placeholder="Contraseña">
                    <label for="password" class="form-label">Contraseña</label>
                </div>

                <div class="form-floating mb-3">
                    <!-- selecciona multiples roles -->
                    <label for="roles" class="form-label">Roles:</label>
                    <?php foreach ($roles as $rol) : ?>
                        <div class="form-check w-25 mx-auto">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $rol->getIdrol() ?>" id="<?= $rol->getIdrol() ?>">
                            <label class="form-check-label" for="<?= $rol->getIdrol() ?>">
                                <?= $rol->getRodescripcion() ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-dark">Crear Menu</button>
            </form>
        </div>

    </div>

</main>

<?php include_once("../estructura/footer.php"); ?>

<script src="../js/validacIones.js"></script>
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
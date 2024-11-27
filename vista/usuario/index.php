<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y sea administrador
$session = new Sesion();
if (!$session->estaActiva()) {
    header("Location: ../index.php");
}

$data = data_submitted();

$abmRoles = new AbmRol();
$roles = $abmRoles->buscar(null);

$error = null;
$usuario = null;
$rolesDelUsuario = [];
try {
    $usuario = $session->getUsuario();
    // obtiene los roles del menu
    $abmUsuarioRol = new ABMUsuarioRol();
    $usuarioRoles = $abmUsuarioRol->buscar(['idusuario' => $usuario->getIdUsuario()]);
    foreach ($usuarioRoles as $mr) {
        $rolesDelUsuario[] = $mr->getobjrol();
    }

} catch (Exception $e) {
    $error = $e;
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
    <!-- formulario de modificacion de menu -->
    <div class="w-25 mx-auto mt-3 mb-5">
        <div class="row">
            <h2>Usuario: <?= $usuario->getusnombre() ?></h2>
        </div>
        <div class="row">
            <h3>Roles:</h3>
            <p>
                <?php foreach ($rolesDelUsuario as $rol) { ?>
                    <strong><?= $rol->getrodescripcion() ?></strong>,
                <?php } ?>
            </p>
        </div>
        <div class="row">
            <h3>Datos</h3>
            <form id="formModificar" action="./accionModificar.php" method="POST">
                <div class="form-floating mt-3 mb-3">
                    <input class="form-control" id="nombre" name="usnombre" type="text" placeholder="Nombre" required value="<?= $usuario->getusnombre(); ?>">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="usmail" name="usmail" placeholder="ejemplo@ejemplo.com" value="<?= $usuario->getusmail(); ?>">
                    <label for="usmail">Correo Electrónico</label>
                </div>
                <input type="hidden" name="idusuario" value="<?= $usuario->getidusuario(); ?>">
                <button type="submit" class="btn btn-dark">Actualizar</button>
            </form>
        </div>
        <!-- Formulario para cambia de clave -->
        <div class="row mt-4">
            <h3>Modificar Contraseña</h3>
            <form id="formCambiarClave" action="./cambiarClave.php" method="POST">
                <input type="hidden" name="idusuario" value="<?= $usuario->getidusuario(); ?>">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Clave" required min="6">
                    <label for="uspass">Clave</label>
                </div>
                <button type="submit" class="btn btn-dark">Cambiar Clave</button>
            </form>
        </div>
    </div>
</main>
<?php include_once("../estructura/footer.php"); ?>
<script>
    $(document).ready(function() {
        $('#formModificar').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./accionModificar.php",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        // redirige a la pagina de menus
                        window.location.href = "./";
                    } else {
                        alert(response.data);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('#formCambiarClave').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./accionCambiarContrasenia.php",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload()
                    } else {
                        alert(response.data);
                    }
                }
            });
        });
    });
</script>
</body>

</html>
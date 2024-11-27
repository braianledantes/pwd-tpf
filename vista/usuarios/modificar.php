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

$abmRoles = new AbmRol();
$roles = $abmRoles->buscar(null);

$error = null;
$usuario = null;
$rolesDelUsuario = [];
try {
    if (!isset($data['idusuario'])) {
        throw new Exception("Falta el id del menu");
    }

    $abmUsuario = new ABMUsuario();
    $usuarios = $abmUsuario->buscar(['idusuario' => $data['idusuario']]);
    if (empty($usuarios)) {
        throw new Exception("El menu no existe");
    }
    $usuario = $usuarios[0];
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
            <h1>Modificar Usuario <?= $usuario->getidusuario() ?></h1>
        </div>
        <div class="row">
            <form id="formModificarMenu" action="./accionModificar.php" method="POST">
                <div class="form-floating mt-3 mb-3">
                    <input class="form-control" id="nombre" name="usnombre" type="text" placeholder="Nombre" required value="<?= $usuario->getusnombre(); ?>">
                    <label for="nombre">Nombre</label>

                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="usmail" name="usmail" placeholder="ejemplo@ejemplo.com" value="<?= $usuario->getusmail(); ?>">
                    <label for="usmail">Correo Electrónico</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="uspass" value="" placeholder="Contraseña" required>
                    <label for="password" class="form-label">Contraseña</label>
                </div>
                <div class="form-floating mb-3">
                    <!-- selecciona multiples roles -->
                    <label for="roles" class="form-label">Roles:</label>
                    <?php foreach ($roles as $rol) : ?>
                        <div class="form-check w-25 mx-auto">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $rol->getIdrol() ?>" id="<?= $rol->getIdrol() ?>" <?= in_array($rol, $rolesDelUsuario) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="<?= $rol->getIdrol() ?>">
                                <?= $rol->getRodescripcion() ?>
                            </label>
                        </div>

                    <?php endforeach; ?>
                </div>

                <input type="text" name="usdeshabilitado" value="<?= $usuario->getusdeshabilitado(); ?>" hidden>
                <input type="hidden" name="idusuario" value="<?= $usuario->getidusuario(); ?>">
                <button type="submit" class="btn btn-dark">Modificar</button>
            </form>
        </div>
    </div>
</main>
<?php include_once("../estructura/footer.php"); ?>
<script>
    $(document).ready(function() {
        $('#formModificarMenu').submit(function(e) {
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
</script>
</body>

</html>
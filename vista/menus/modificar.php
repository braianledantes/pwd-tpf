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
$menu = null;
$menuPadre = null;
$rolesDelMenu = [];
try {
    if (!isset($data['idmenu'])) {
        throw new Exception("Falta el id del menu");
    }

    $abmMenu = new AbmMenu();
    $menus = $abmMenu->buscar(['idmenu' => $data['idmenu']]);
    if (empty($menus)) {
        throw new Exception("El menu no existe");
    }
    $menu = $menus[0];
    // obtiene los roles del menu
    $abmMenuRol = new AbmMenuRol();
    $menuRoles = $abmMenuRol->buscar(['idmenu' => $menu->getIdmenu()]);
    foreach ($menuRoles as $mr) {
        $rolesDelMenu[] = $mr->getobjrol();
    }

    $menuPadre = $menu->getobjmenu();
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
        <div class="container">
            <div class="row">
                <h1>Modificar Menú <?= $menu->getIdmenu() ?></h1>
            </div>
            <div class="row">
                <form id="formModificarMenu" action="./accionModificar.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="menombre" value="<?= $menu->getMenombre(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="descripcion" name="medescripcion" value="<?= $menu->getMedescripcion(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="idpadre" class="form-label">ID del menú Padre</label>
                        <input type="number" class="form-control" id="idpadre" name="idpadre" value="<?= $menuPadre ? $menuPadre->getIdmenu() : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <!-- selecciona multiples roles -->
                        <label for="roles" class="form-label">Roles</label>
                        <?php foreach ($roles as $rol) : ?>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $rol->getIdrol() ?>" id="<?= $rol->getIdrol() ?>" <?= in_array($rol, $rolesDelMenu) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="<?= $rol->getIdrol() ?>">
                                    <?= $rol->getRodescripcion() ?>
                                </label>
                            </div>

                        <?php endforeach; ?>
                    </div>

                    <input type="hidden" name="idmenu" value="<?= $menu->getIdmenu(); ?>">
                    <button type="submit" class="btn btn-primary">Modificar</button>
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
<?php
include_once '../../configuracion.php';
$datos = data_submitted();
$sesion = new Sesion();

if (!$sesion->esAdministrador()) {
    header('Location: ../index.php?messageErr=' . urlencode("No tiene los permisos para acceder"));
    exit;
}
$abmUsuario = new abmusuario();
$lista = $abmUsuario->buscar($datos);

if (isset($lista)) {
    $idUsuario = $lista[0]->getIdusuario();
    //include_once '../estructuras/cabecera.php';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>

    <div class="contenedor">
        <h1 class="text-center">Modificar Usuario</h1>
        <form id="datosUsuario" class="col-md-11 mt-4" method="post" action="../accion/accionModificarUsuario.php">
            <input type="hidden" name="idusuario" value=<?php echo $idUsuario ?>>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="usnombre" name="usnombre" type="text" placeholder="Nombre" value="<?php echo $lista[0]->getUsnombre() ?>">
                        <label for="idproducto">Nombre</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="usmail" name="usmail" type="text" placeholder="Mail" value="<?php echo $lista[0]->getUsmail() ?>">
                        <label for="usmail">Mail</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mt-4">
                        <div class="form-floating">
                            <input class="form-control" id="uspass" name="uspass" type="password" placeholder="Contraseña" value="<?php echo $lista[0]->getUspass() ?>">
                            <label for="uspass">Contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-4">
                        <div class="form-floating">
                            <input class="form-control" id="uspass2" name="uspass2" type="password" placeholder="Confirmar contraseña" value="<?php echo $lista[0]->getUspass() ?>">
                            <label for="uspass2">Confirmar contraseña</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <?php
                $abmUsuarioRol = new abmusuariorol();
                $listaUsuarioRol = $abmUsuarioRol->buscar($datos);
                $rol = $listaUsuarioRol[0]->getObjRol()->getIdrol();
                if ($_SESSION['idusuario'] != $idUsuario) {
                ?>

                    <div class="col-md-4">
                        <div class="mt-4">
                            <input class="form-check-input" id="cliente" name="idrol" type="radio" value="2" <?php if ($rol == 1) { ?> checked <?php } ?>>
                            <label for="cliente">Cliente</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-4">
                            <input class="form-check-input" id="deposito" name="idrol" type="radio" value="3" <?php if ($rol == 2) { ?> checked <?php } ?>>
                            <label for="deposito">Depósito</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-4">
                            <input class="form-check-input" id="admin" name="idrol" type="radio" value="1" <?php if ($rol == 3) { ?> checked <?php } ?>>
                            <label for="admin">Administrador</label>
                        </div>
                    </div>

                <?php
                }
                ?>

            </div>
            <div class="mt-5">
                <div class="d-grid offset-md-4 col-md-4">
                    <button class="btn" style="color: white;background: black;" type="submit">Modificar</button>
                </div>
            </div>
        </form>
    </div>
    <?php include_once("../estructura/footer.php"); ?>
</body>

</html>
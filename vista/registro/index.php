<?php
include_once '../../configuracion.php';
// verifica que el usuario no esté logueado
$session = new Sesion();
if ($session->estaActiva()) {
    header("Location: ../");
}

$datos = data_submitted();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <!-- JQuery -->
    <?php include_once("../estructura/jquery.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
    <!---- fontawesome ---->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include_once("../estructura/cabecera.php"); ?>

    <main>
        <?php
        if (count($datos) > 0) {
            if (isset($datos['messageOk']) || isset($datos['messageErr'])) {
                if (isset($datos['messageOk'])) {
                    $message = $datos['messageOk'];
                    $alert = "success";
                } else {
                    $message = $datos['messageErr'];
                    $alert = "danger";
                }
        ?>
                <div class='alert alert-<?php echo $alert ?> d-flex align-items-center text-center col-md-4 offset-md-4' role='alert'>
                    <i class="bi bi-exclamation-triangle-fill text-center">&nbsp;<?php echo $message ?></i>
                </div>
        <?php
            }
        }
        ?>


        </div>
        <div class="container mt-3">
            <div class="d-flex justify-content-center">
                <div class="col d-flex justify-content-center" style="max-width: 500px;padding-top: 40px;padding-bottom:80px;">
                    <form action="./accionRegistro.php" method="post" class="container bg-white border rounded shadow p-4" id="datosUsuario" name="usuarioNuevo">
                        <h2 id="subtitulo" class="text-center">Bienvenido!</h1>
                        <div class="col-md-12" style="z-index:-1">
                            <div class="mt-3">
                                <div class="form-floating">
                                    <input class="form-control" id="usnombre" name="usnombre" type="text" placeholder="Nombre de usuario" required>
                                    <label for="usnombre">Nombre de usuario </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3">
                                <div class="form-floating">
                                    <input class="form-control" id="usmail" name="usmail" type="text" placeholder="Mail" required>
                                    <label for="usmail">Mail </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3">
                                <div class="form-floating">
                                    <input class="form-control" id="uspass" name="uspass" type="password" placeholder="Contraseña" required>
                                    <label for="uspass">Contraseña </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3">
                                <div class="form-floating">
                                    <input class="form-control" id="uspass2" name="uspass2" type="password" placeholder="Confirmar contraseña" required>
                                    <label for="uspass">Confirmar contraseña </label>
                                </div>
                            </div>
                        </div>
                        <div class=" mt-4">
                            <div class="d-grid">
                                <button class="btn btn-dark" type="submit">Registrarme</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <?php include_once("../estructura/footer.php"); ?>

    <script src="../js/validacIones.js"></script>
    <script>
        $(document).ready(function() {
            $("#nombre").focus();

            $("form").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "./accionRegistro.php",
                    method: "post",
                    data: $("form").serialize(),
                    success: function(respuesta) {
                        console.log(respuesta);
                        if (respuesta.status == "ok") {
                            window.location.href = "../";
                        } else {
                            alert(respuesta.message);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php include_once("../../configuracion.php");
$datos = data_submitted();

$sesion = new Session();
$homeUrl = "$PROJECT_PATH/index.php";

if ($sesion->activa()) {
    header("Location: $homeUrl");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../../favicon-32x32.png" type="image/png" sizes="32x32">
    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>

    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include_once("../estructura/cabecera-publica.php"); ?>

    <main>

        <!--Login-->
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
        <div class="container-fluid d-flex align-items-start justify-content-center" style="min-height: 60vh; padding-top: 40px;">
            <div class="row justify-content-center mt-3">
                <div class="col" style="max-width: 400px;">
                    <form id="datosUsuario" name="login" class="container bg-white border rounded shadow p-4" action="../accion/accionLogin.php" method="post">
                        <div class="row mb-4">
                            <h2 class="text-center">¡Hola! :)</h2>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                                <input type="text" id="usnombre" name="usnombre" class="form-control" placeholder="Nombre de Usuario" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="uspass" id="uspass" class="form-control" placeholder="Contraseña de Usuario" aria-label="Password" aria-describedby="basic-addon2">
                            </div>
                        </div>

                        <div class="row mb-4 mx-1">
                            <button class="btn btn-dark" type="submit">Iniciar Sesion</button>
                        </div>
                        <div class="text-center">
                            <p class="mb-0 text-muted">¿No tenés una cuenta? <a href="../registro">Click Aqui!</a></p>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </main>

    <?php include_once("../estructura/footer.php"); ?>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery Validate CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../js/validacIones.js"></script>

</body>

</html>
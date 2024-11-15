<?php include_once("../../configuracion.php");
$datos = data_submitted();

$sesion = new Sesion();
$homeUrl = "$PROJECT_PATH/index.php";

if ($sesion->estaActiva()) {
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
    <link rel="icon" href="../assets/imagenes/favicon-32x32.png" type="image/png" sizes="32x32">
    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <!-- JQuery -->
    <?php include_once("../estructura/jquery.php"); ?>

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
                    <form id="datosUsuario" name="login" class="container bg-white border rounded shadow p-4">
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

    <script>
        $(document).ready(function() {
            $("#nombre").focus();

            $("form").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "accionLogin.php",
                    method: "post",
                    data: $("form").serialize(),
                    success: function(respuesta) {
                        if (respuesta.status == "ok") {
                            window.location.href = "../";
                        } else {
                            alert("Usuario o contraseña incorrectos");
                        }
                    }
                });
            });
        });
    </script>

    <script src="../js/validacIones.js"></script>
    <?php include_once("../estructura/footer.php"); ?>
</body>

</html>
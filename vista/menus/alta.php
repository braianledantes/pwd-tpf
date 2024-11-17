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
        <div class="w-25 mx-auto mt-3 mb-5">
            <!-- formulario de alta de menu -->
            <div class="row">
                <h1>Alta de Menú</h1>
            </div>
            <div class="row">
                <form id="formCrearMenu" action="./accionAlta.php" method="POST">
                    <div class="form-floating mt-3 mb-3">
                        <input class="form-control" id="nombre" name="menombre" type="text" placeholder="Nombre" required>
                        <label for="nombre">Nombre</label>
                            
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="descripcion" name="medescripcion" required value="" placeholder="/ejemplo">
                        <label for="descripcion" class="form-label">Ubicación</label>
                    </div>
                    <div class="form-floating mb-3">
                    
                        <input type="number" class="form-control" id="idpadre" name="idpadre" placeholder="ID del menu Padre" required>
                        <label for="idpadre">ID del menú Padre</label>
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
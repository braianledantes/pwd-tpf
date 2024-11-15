<?php
include_once '../../configuracion.php';
$datos = data_submitted();
$sesion = new Sesion(); 

if (!$sesion->esAdministrador()) {
    header('Location: ../index.php?messageErr=' . urlencode("No tiene los permisos para acceder"));
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Cargados</title>
    <link rel="icon" href="../../favicon-32x32.png" type="image/png" sizes="32x32">

    <!-- bootstrap -->
    <?php include_once("../estructura/bootstrap.php"); ?>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include_once("../estructura/cabecera-admin.php"); ?>

    <div class="contenedor">

    <?php
    $abmUsuario = new abmusuario();
    $lista = $abmUsuario->buscar(null);
    if (count($lista) > 0) {
    ?>

        <h1 class="text-center">Lista de Usuarios Cargados :)</h1>

        <table class='table table-light table-striped table-borderless' style="margin-top: 30px;">
            <thead>
                <tr>
                    <th scope='col' class='text-center'>ID</th>
                    <th scope='col' class='text-center'>Rol</th>
                    <th scope='col' class='text-center'>Nombre</th>
                    <th scope='col' class='text-center'>Contraseña</th>
                    <th scope='col' class='text-center'>Mail</th>
                    <th scope='col' class='text-center'>Deshabilitado</th>
                    <th scope='col' class='text-center'>Modificar</th>
                    <th scope='col' class='text-center'>Deshabilitar</th>
                    <th scope='col' class='text-center'>Eliminar</th>
                </tr>
            </thead>

            <?php
            foreach ($lista as $usuario) {
                $id = $usuario->getIdusuario();
                $abmUsuarioRol = new abmusuariorol();
                $datos['idusuario'] = $id;
                $listaUsuarioRol = $abmUsuarioRol->buscar($datos);
                $rol = $listaUsuarioRol[0]->getObjRol()->getRodescripcion();
            ?>

                <tr id="row<?php echo $id ?>">
                    <td class='text-center'><?php echo $id ?></td>
                    <td class='text-center'><?php echo "<span style='font-style: italic;'>" . strtoupper($rol). "</span>"; ?></td>
                    <td class='text-center'><?php echo $usuario->getUsnombre() ?></td>
                    <td class='text-center'><?php echo md5($usuario->getUspass()) ?></td>
                    <td class='text-center'><?php echo $usuario->getUsmail() ?></td>
                    <td id="fechaDeshabilitado<?php echo $id ?>" class='text-center'><?php echo $usuario->getUsdeshabilitado() ?></td>
                    <form method='post' action='modificarUsuario.php'>
                        <td class='text-center'>
                            <input name='idusuario' id='idusuario' type='hidden' value=<?php echo $id ?>><button class='btn circle-icon rounded-circle' type='submit'><i class="bi bi-pen "></i></button>
                        </td>
                    </form>
                    <form>
                        <td class='text-center'>
                            <button type="button" id="deshabilitar<?php echo $id ?>" class='btn circle-icon rounded-circle'  onclick="deshabilitar('deshabilitar<?php echo $id ?>', '<?php echo $id ?>', '<?php echo $usuario->getUsdeshabilitado() ?>')">

                                <?php
                                    if ($usuario->getUsdeshabilitado() == '0000-00-00 00:00:00') {
                                ?>
                                    <i class="bi bi-emoji-smile-fill "></i>
                                <?php
                                    } else {
                                ?>
                                    <i class="bi bi-emoji-frown-fill "></i>
                                <?php
                                    }
                                ?>
                            </button>
                        </td>
                    </form>
                    <form action="../accion/accionEliminarUsuario.php">
                        <td class='text-center'>
                            <input name='idusuario' id='idusuario' type='hidden' value=<?php echo $id ?>><button type="submit" class='btn btn-danger btn-sm rounded-circle'><i class='bi bi-trash3-fill'></i></button>
                        </td>
                    </form>
                </tr>

            <?php
            }
            ?>

        </table>

        <div id="mensaje" class='alert d-flex align-items-center text-center col-md-4 offset-md-4' role='alert'></div>

    <?php
    } else {
    ?>

        <h1 class='text-center'>No hay usuarios cargados en la base de datos</h1>

    <?php
    }
    ?>
    </div>

    <?php include_once("../estructura/footer.php"); ?>

    <script>
    function deshabilitar(idBoton, idUsuario, usDeshabilitado) {
        $.ajax({
            data: {
                idusuario: idUsuario
            },
            url: "../accion/accionDeshabilitarUsuario.php",
            type: "post",
            success: function(respuesta) {
                respuesta = JSON.parse(respuesta);
                console.log("Respuesta parseada:", respuesta);

                if (respuesta.status == "EXITO") {
                    $('#mensaje').removeClass("alert-danger");
                    $('#mensaje').addClass("alert-success");
                    $('#mensaje').addClass("rounded-5");
                    $('#mensaje').addClass("text-center"); // Asegura que el texto se centre
                    $('#mensaje').addClass("d-flex align-items-center justify-content-center"); 
                    $('#mensaje').html('<i class="bi bi-check-lg">Accion Realizada!</i>');
                    //console.log(respuesta.status);
                    if (respuesta.fecha == "0000-00-00 00:00:00") {
                        $('#' + idBoton).html('<i class="bi bi-emoji-smile-fill ">')
                    } else {
                        $('#' + idBoton).html('<i class="bi bi-emoji-frown-fill "></i>')
                    }
                    $('#fechaDeshabilitado' + idUsuario).html(respuesta.fecha)
                } else {
                    $('#mensaje').removeClass("alert-success");
                    $('#mensaje').addClass("alert-danger");
                    $('#mensaje').addClass("rounded-5");
                    $('#mensaje').addClass("text-center");
                    $('#mensaje').addClass("d-flex align-items-center justify-content-center"); 
                    $('#mensaje').html('<i class="bi bi-exclamation-lg text-center">ERROR</i>');
                }
            }
        })
        //console.log(idBoton, idUsuario, usDeshabilitado)
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>


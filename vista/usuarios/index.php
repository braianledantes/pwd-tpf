<?php
include_once '../../configuracion.php';
$datos = data_submitted();
// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Cargados</title>
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

    <div class="contenedor">

        <h2 class="text-center mt-3">ABM de Usuarios</h2>
        <a href="./alta.php" class="btn btn-dark mt-3">+ Crear Usuario</a>
        <table class='table table-light table-striped table-borderless mt-4' >
                <thead>
                    <tr>
                        <th scope='col' class='text-center'>ID</th>
                        <th scope='col' class='text-center'>Nombre</th>
                        <th scope='col' class='text-center'>Mail</th>
                        <th scope='col' class='text-center'>Roles</th>
                        <th scope='col' class='text-center'>Deshabilitado</th>
                        <th scope='col' class='text-center'>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaUsuarios">
                    <!-- Aquí se cargan los usuarios -->
                </tbody>
            </table>
    </div>

    <?php include_once("../estructura/footer.php"); ?>

    <script>
        $(document).ready(function() {
            mostrarLista();
        });

        function mostrarLista() {
            $.ajax({
                type: "GET",
                url: "./accionListar.php",
                success: function(result) {
                    const data = result.data;
                    let contenido = '';
                    data.forEach(usuario => {
                        contenido += `
                        <tr>
                            <td class='text-center'>${usuario.idusuario}</td>
                            <td class='text-center'>${usuario.usnombre}</td>
                            <td class='text-center'>${usuario.usmail}</td>
                            <td class='text-center'>${usuario.roles.map(rol => rol.rodescripcion.toUpperCase()).join(', ')}</td>
                            <td class='text-center'>${usuario.usdeshabilitado === "0000-00-00 00:00:00" ? 'Habilitado' : usuario.usdeshabilitado}</td>
                            `
                            if (usuario.usdeshabilitado !== "0000-00-00 00:00:00") {
                                contenido += `
                                <td class='text-center'>
                                    <a href="#" onclick='habilitar(${usuario.idusuario})'><i class="bi bi-emoji-frown-fill"></i></a>`
                            } else {
                                contenido += `
                                <td class='text-center'>
                                    <a href="#" onclick='deshabilitar(${usuario.idusuario})'><i class="bi bi-emoji-smile-fill"></i></a>`
                            }

                        contenido +=`
                                <a href="./modificar.php?idusuario=${usuario.idusuario}" class='btn circle-icon rounded-circle'><i class="bi bi-pen "></i></a>
                            </td>
                        </tr>`;
                    });
                    $('#listaUsuarios').html(contenido);
                }
            });
        }

        function deshabilitar(id) {
            $.ajax({
                type: "POST",
                url: "./accionDeshabilitar.php",
                data: {
                    idusuario: id
                },
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarLista();
                    } else {
                        alert(result.data);
                    }
                }
            });
        }

        function habilitar(id) {
            $.ajax({
                type: "POST",
                url: "./accionHabilitar.php",
                data: {
                    idusuario: id
                },
                success: function(result) {
                    if (result.status === 'success') {
                        mostrarLista();
                    } else {
                        alert(result.data);
                    }
                }
            });
        }
    </script>
</body>

</html>
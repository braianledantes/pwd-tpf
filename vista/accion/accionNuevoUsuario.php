<?php
include_once '../../configuracion.php';

$datos = data_submitted();

// Verifica si ya existe un usuario con el mismo nombre de usuario
$abmUsuario = new abmusuario();
$usuarioExistente = $abmUsuario->buscar(['usnombre' => $datos['usnombre']]);

// Si el nombre de usuario ya existe, redirige con un mensaje de error
if (count($usuarioExistente) > 0) {
    header('Location: ../registro/index.php?messageErr=' . urlencode("El nombre de usuario ya existe."));
    exit;
}

$exito = $abmUsuario->alta($datos);
// Si hubo algún error al agregar el usuario, redirige con un mensaje de error
if (!$exito) {
    header('Location: ../registro/index.php?messageErr=' . urlencode('Error al registrar el usuario.'));
    exit;
}

// Obtiene el nuevo usuario recién insertado
$nuevoUsuario = $abmUsuario->buscar($datos);

// Asigna el rol al nuevo usuario
$datosUsRol = [
    'idusuario' => $nuevoUsuario[0]->getidusuario(),
    'idrol' => $datos['idrol'] // Asigna el rol según el valor recibido en el formulario
];

// Asigna el rol al nuevo usuario en la tabla de roles
$abmUsuarioRol = new ABMUsuarioRol();
$abmUsuarioRol->alta($datosUsRol);

// Si todo fue exitoso, redirige al administrador a la página principal
header('Location: ../index.php?messageOk=' . urlencode('Usuario registrado y rol asignado correctamente.'));
exit;

?>

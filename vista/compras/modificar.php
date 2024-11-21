<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

$data = data_submitted();

$compra = null;
// estados a los que se le puede agregar a la compra
$estadosDisponibles = [];
try {
    $idcompra = $data['idcompra'];
    if (!isset($idcompra)) {
        throw new Exception("Falta el id de compra");
    }

    $abmCompra = new ABMCompra();
    $listaCompras = $abmCompra->buscar(['idcompra' => $idcompra]);
    if (empty($listaCompras)) {
        throw new Exception("El id de compra no es válido");
    }
    $compra = $listaCompras[0];

    // trae el usuario de la compra
    $abmUsuario = new ABMUsuario();
    $usuario = $abmUsuario->buscar(['idusuario' => $compra->getObjusuario()->getIdusuario()])[0];

    // trae todos los estados de la compra
    $abmCompraEstado = new ABMCompraEstado();
    $listaEstadosCompra = $abmCompraEstado->buscar(['idcompra' => $compra->getIdcompra()]);

    // trae los items de la compra
    $abmCompraItem = new ABMCompraItem();
    $listaItems = $abmCompraItem->buscar(['idcompra' => $compra->getIdcompra()]);

    // trae todos los tipos de estado que puede tener una compra
    $abmCompraEstadoTipo = new ABMCompraEstadoTipo();
    $listaEstados = $abmCompraEstadoTipo->buscar(null);

    // carga los estados disponibles.
    // si la compra no tiene estados, se le puede agregar cualquier estado.
    // si la compra tiene el estado 1, agrega los estados 2, 3 y 4.
    // si la compra tiene el estado 2, agrega los estados 3 y 4.
    // si la compra tiene el estado 3, no agrega ningun estado.
    if (empty($listaEstadosCompra)) {
        $estadosDisponibles = $listaEstados;
    } else {
        // obtiene el ultimo estado de la compra
        $estadoCompra = $listaEstadosCompra[count($listaEstadosCompra) - 1];
        $estadoCompraTipo = $estadoCompra->getobjEstadoTipo();
        $idEstadoCompraTipo = $estadoCompraTipo->getIdcompraestadotipo();
        if ($idEstadoCompraTipo == 1) {
            $estadosDisponibles = array_filter($listaEstados, function ($estado) {
                return $estado->getIdcompraestadotipo() > 1;
            });
        } else if ($idEstadoCompraTipo == 2) {
            $estadosDisponibles = array_filter($listaEstados, function ($estado) {
                return $estado->getIdcompraestadotipo() > 2;
            });
        }
    }
} catch (Exception $e) {
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación de compra</title>
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
        <div class="w-75 mx-auto mt-3 mb-5">
            <div class="row">
                <h2>Modificación del Compra <?= $compra->getIdcompra() ?> </h2>
            </div>
            <div class="row">
                <!-- Muestra Datos de la compra (id, fecha, usuario) -->
                <h3>Datos de la compra</h3>
                <ul>
                    <li><strong>Id de compra: </strong><?= $compra->getidcompra() ?></li>
                    <li><strong>Fecha de compra: </strong><?= $compra->getCofecha() ?></li>
                    <li><strong>Usuario: </strong><?= $usuario->getusnombre() ?></li>
                </ul>

                <!-- Muestra Items de la compra -->
                <h3>Items de la compra</h3>
                <ul>
                    <?php foreach ($listaItems as $item) : ?>
                        <li>
                            <strong>Producto: </strong><?= $item->getObjProducto()->getusnombre() ?>
                            <strong>Cantidad: </strong><?= $item->getCicantidad() ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <ul>
                    <?php foreach ($listaEstadosCompra as $estadoCompra) : ?>
                        <li>
                            <strong>Estado: </strong><?= $estadoCompra->getobjEstadoTipo()->getCetDescripcion() ?>
                            <strong>Fecha: </strong><?= $estadoCompra->getcefechaini() ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Opcion de Agregar un estado a la compra si hay estados disponibles -->
                <?php if (!empty($estadosDisponibles)) : ?>
                    <?php foreach ($estadosDisponibles as $estado) : ?>
                        <form class="mt-2 formCambiarEstado">
                            <input type="hidden" name="idcompra" value="<?= $compra->getIdcompra() ?>">
                            <input type="hidden" name="idcompraestadotipo" value="<?= $estado->getIdcompraestadotipo() ?>">
                            <button type="submit" class="btn btn-primary">Cambiar a <?= $estado->getCetDescripcion() ?></button>
                        </form>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </main>
    <?php include_once("../estructura/footer.php"); ?>
    <script>
        $(document).ready(function() {
            // envia el formulario para cambiar el estado de la compra
            $(".formCambiarEstado").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                $.ajax({
                    url: "./accionModificar.php",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            // recarga la pagina
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    error: function() {
                        alert('Error al modificar el compra');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
</body>

</html>
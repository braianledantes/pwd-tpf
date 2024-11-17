<?php
$session = new Sesion();

$menus = $session->obtenerMenusDelUsuario();
?>
<header class="position-auto top-0 shadow mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000; padding: 30px 160px;">
        <div class="container-fluid">
            <a class="nav-link" href="/pwd-tpf/index.php">
                <div class="d-flex align-items-center">
                    <img class="ms-auto me-3" style="height: 80px; width: auto;" src="/pwd-tpf/vista/assets/imagenes/angelwings.png" alt="logo Angel Wings">
                    <h3 id="titulo" class="mb-0 text-white">Angel Wings Jewelry</h3>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php if ($session->estaActiva()) { ?>
                            <a class="nav-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cerrar Seaion" href="/pwd-tpf/Vista/login/accionLogout.php">Cerrar Sesión</a>
                        <?php } else { ?>
                            <div class="sesion">
                                <a href="/pwd-tpf/Vista/login"><i class="fas fa-user"></i></a>
                            </div>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Menu que se carga dinamicamente de acuerdo al tipo de usario-->
    <nav id="menuDinamico"class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mx-auto mb-2 mb-lg-0">
                <?php if (empty($menus)) { ?>
                    <li class="nav-item">
                        <span class="nav-link">¡Explora nuestros productos y encuentra el anillo perfecto para ti! ♡ </span>
                    </li>
                <?php } else { ?>
                    <?php foreach ($menus as $m) { ?>
                        <li class="nav-item mx-5">
                            <a class="nav-link" href="/pwd-tpf/vista<?= $m->getMedescripcion() ?>"><?= $m->getMenombre() ?></a>
                        </li>
                    <?php } ?>
                <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
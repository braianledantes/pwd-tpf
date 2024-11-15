<?php
$session = new Session();
$resp = $session->validar();

if (!$resp) {
    header("Location: $PROJECT_PATH/vista/login");
}

if (!$session->esAdministrador() && !$session->esCliente()) {
    header("Location: $PROJECT_PATH/vista");
}
?>

<header class="position-sticky top-0 shadow mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000; padding: 30px 160px;">
        <div class="container-fluid">
            <a class="nav-link" href="/pwd-tp-final/index.php">
                <div class="d-flex align-items-center">
                    <img class="ms-auto me-3" style="height: 80px; width: auto;" src="/pwd-tp-final/angelwings.png" alt="logo Angel Wings">
                    <h3 class="mb-0 text-white">Angel Wings Jewelry</h3>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/pwd-tp-final/Vista/home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pwd-tp-final/Vista/productos">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pwd-tp-final/Vista/carrito">Carrito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pwd-tp-final/Vista/accion/accionLogout.php">Cerrar Sesión</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
<?php
$session = new Sesion();
if (!$session->estaActiva()) {
    header("Location: $PROJECT_PATH/vista/login");
}

if (!$session->esAdministrador() && !$session->esCliente()) {
    header("Location: $PROJECT_PATH/vista");
}
?>

<header class="position-sticky top-0 shadow mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000; padding: 30px 160px;">
        <div class="container-fluid">
            <a class="nav-link" href="/pwd-tpf/index.php">
                <div class="d-flex align-items-center">
                    <img class="ms-auto me-3" style="height: 80px; width: auto;" src="/pwd-tpf/vista/assets/imagenes/angelwings.png" alt="logo Angel Wings">
                    <h3 class="mb-0 text-white">Angel Wings Jewelry</h3>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="icono">
                        <a href="/pwd-tpf/Vista/home"><i class="fa-solid fa-house"></i>Inicio</a>
                    </li>
                    <li class="icono">
                        <a href="/pwd-tpf/Vista/productos"><i class="fa-solid fa-tag"></i>Productos</a>
                    </li>
                    <li class="icono">
                        <a href="/pwd-tpf/Vista/carrito"><i class="fa-solid fa-cart-shopping"></i>Carrito </a>
                    </li>
                    <li class="icono">
                        <a href="/pwd-tpf/Vista/login/accionLogout.php"><i class="fa-solid fa-right-to-bracket"></i>Cerrar sesión </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
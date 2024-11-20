function actualizarContadorCarrito() {
    $.ajax({
        type: "GET",
        url: "/pwd-tpf/vista/carrito/accionContadorCarrito.php", // Este archivo PHP debería devolver el número total de productos en el carrito
        success: function(data) {
            console.log('Respuesta de AJAX:', data);  // Asegúrate de ver la respuesta del servidor

            if (data && data.totalProductos !== undefined) {
                // Actualizamos el contador en la interfaz
                $("#contador-carrito").text(data.totalProductos);  // Cambia el texto del contador en la cabecera
            } else {
                console.error('Respuesta del servidor no válida');
            }
        },
        error: function(error) {
            console.error("Error al actualizar el contador del carrito:", error);
        }
    });
}

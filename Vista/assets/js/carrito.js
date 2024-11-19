// actualiza el carrito
function actualizarCarrito() {
    const contenedor = document.getElementById("listaproductos");
    contenedor.innerHTML = "";
  
    fetch("../accion/accionCarrito.php?accion=mostrar")
      .then((response) => response.json())
      .then((data) => {
        if (data.estado && data.carrito.length > 0) {
          contenedor.innerHTML = `
            <div class="list-group">
              ${data.carrito
                .map(
                  (producto) => `
                  <div class="list-group-item d-flex align-items-center">
                  <div style="flex: 1;">
                    <h6 class="mb-1">${producto.nombre}</h6>
                  </div>
                  <div class="text-left m-3">
                    <small>Cantidad: ${producto.cantidad}</small>
                  </div>
                  <button 
                    class="btn btn-danger btn-sm"
                    onclick="eliminarProducto(${producto.id})"
                  >
                Eliminar
                </button>
            </div>
  
                `
                )
                .join("")}
            </div>`;
        } else {
          contenedor.innerHTML = `
            <div class="alert alert-secondary text-center" role="alert">
              El carrito está vacío.
            </div>`;
        }
      })
      .catch((error) => {
        console.error("Error al cargar el carrito:", error);
        contenedor.innerHTML = `
          <div class="alert alert-danger text-center" role="alert">
            Error al cargar el carrito.
          </div>`;
      });
  }
  
  // inicia la compra
  function enviarCompra() {
    fetch("../accion/accionCarrito.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        accion: "alta",
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error inesperado. Por favor, intenta de nuevo.");
      });
  }
  
  // vacia el carrito
  function vaciarCarrito() {
    fetch(`../accion/accionCarrito.php?accion=vaciarCarrito`, {
      method: "GET",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          document.getElementById("listaproductos").innerHTML =
            '<div class="alert alert-secondary text-center" role="alert">El carrito está vacío.</div>';
        } else {
          alert(
            data.message || "No se pudo vaciar el carrito. Intenta de nuevo."
          );
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error inesperado. Por favor, intenta de nuevo.");
      });
  }
  
  // eliminar un producto del carrito
  function eliminarProducto(idProducto) {
    fetch(
      `../accion/accionCarrito.php?accion=eliminarProducto&idproducto=${idProducto}`,
      {
        method: "GET",
      }
    )
      .then((response) => response.json())
      .then((data) => {
        console.log("Respuesta del servidor:", data);
        if (data.estado) {
          alert(data.mensaje || "Cantidad del producto actualizada.");
          actualizarCarrito();
        } else {
          alert(data.mensaje || "No se pudo actualizar el producto.");
        }
      })
      .catch((error) => {
        console.error("Error al intentar eliminar el producto:", error);
        alert("Ocurrió un error inesperado. Por favor, intenta de nuevo.");
      });
  }
  
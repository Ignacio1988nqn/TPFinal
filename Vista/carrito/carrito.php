<?php
require "../../configuracion.php";
include_once("../../estructura/header.php");

$session = new Session();
if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
}

?>

<body>
    <main class="container-fluid container tablas container text-center">
        <div class="container p-5" id="contcarritocomp">
            <div class="row d-flex justify-content-center my-4" id="cont-carrito">
                <div class="col-md-12">
                    <div class="card mb-4 border-secondary">
                        <div class="container mt-4">
                            <!-- Lista de productos dinamica -->
                            <h3 class="text-center">Productos en tu carrito</h3>
                            <div id="listaproductos" class="mt-3"></div>
                        </div>

                    </div>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-primary btn-block" onclick="enviarCompra()">
                        Comprar
                    </button>
                    <button type="button" class="btn btn-danger btn-block" id="vaciarCarrito" onclick="vaciarCarrito()">
                        Vaciar carrito
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            actualizarCarrito();
        });
    </script>
    <script src="../assets/js/carrito.js"></script>
</body>

</html>

<?php include_once("../../estructura/footer.php"); ?>
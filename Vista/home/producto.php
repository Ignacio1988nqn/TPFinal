<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
$datos = darDatosSubmitted();
$abmProducto = new AbmProducto();

$param['idproducto'] = $datos['idproducto'];
$prod = $abmProducto->buscar($param);
?>
<section class="home-section">
    <div id="container" style="margin:50px 200px;display:flex">
        <div id="leftcontainer" style="float:left;width:50%">
            <img src="../assets/image/<?php echo $prod[0]->getIdProducto(); ?>.jpg" class="d-block w-100" alt='...'>
        </div>
        <div class="vr" style="height: 50%;"></div>
        <div id="rightcontainer" style="float:right;width:50%;background-color:white">
            <div style="padding: 60px 60px 0 60px">
                <div class=" mb-3 row">
                    <div class="col-sm-10">
                        <h4><?php echo $prod[0]->getProNombre(); ?></h3>
                    </div>
                </div>
            </div>
            <div style=" padding: 5px 60px 0 60px">
                <div class=" mb-3 row">
                    <div class="col-sm-10">
                        <p><?php echo $prod[0]->getProDetalle(); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div style="padding:  5px 60px 0 60px">
                <div class=" mb-3 row">
                    <div class="col-sm-10">
                        <p>Stock: <?php echo $prod[0]->getProCantStock(); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-end" style="width: 35%;margin-top: 40px;margin-left: 15px;">
                <a type="button" class="btn btn-primary" onclick="agregar()">Agregar al carrito</a>
            </div>
        </div>
        <hr>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

<script src="../assets/js/carrito.js"></script>

</html>
<script>
    function agregar() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const productId = urlParams.get("idproducto");

        fetch(`../accion/accionCarrito.php?accion=mostrar`)
            .then((response) => response.json())
            .then((data) => {
                if (data.estado) {
                    // Buscar el producto en el carrito
                    const productoEnCarrito = data.carrito.find(
                        (producto) => producto.id === parseInt(productId)
                    );

                    if (productoEnCarrito) {
                        if (productoEnCarrito.cantidad >= productoEnCarrito.stock) {
                            alert("Límite de stock alcanzado para este producto.");
                            return;
                        }
                    }
                    realizarAgregarProducto(productId);
                } else {
                    realizarAgregarProducto(productId);
                }
            })
            .catch((error) => {
                console.error("Error al verificar el carrito:", error);
                alert("Ocurrió un error al verificar el carrito. Por favor, intenta de nuevo.");
            });
    }

    function realizarAgregarProducto(productId) {
        const obj = {
            id: productId,
        };

        $.ajax({
            url: "./productoAction.php",
            type: "post",
            dataType: "json",
            data: {
                json: JSON.stringify(obj),
            },
            success: function(data) {
                if (data.estado && data.insert) {
                    alert("Producto agregado al carrito.");
                } else if (!data.estado && data.mensaje === "Límite de stock.") {
                    alert("Límite de stock alcanzado para este producto.");
                } else if (!data.estado) {
                    window.location.href = "../login/login.php";
                } else {
                    alert("No se pudo agregar el producto al carrito.");
                }
            },
            error: function(request, status, error) {
                console.error("Error en la solicitud:", request.responseText);
                alert("Ocurrió un error al agregar el producto. Por favor, intenta de nuevo.");
            },
        });
    }
    
</script>
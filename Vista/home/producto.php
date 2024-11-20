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

</html>
<script>
    function agregar() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const product = urlParams.get('idproducto');

        var obj = {
            id: product
        };
        $.ajax({
            url: './productoAction.php',
            type: 'post',
            dataType: 'json',
            data: {
                json: JSON.stringify(obj)
            },
            success: function(data) {

                if (data['estado']) {
                    var diiv = document.getElementById("mensajeapp");
                    document.getElementById("mensajestr").innerHTML = "El producto fue agregado al carrito";
                    diiv.style.opacity = '100';

                    setTimeout(function() {
                        var AmountOfActions = 100;
                        diiv.style.opacity = '100';
                        var counte = 100;
                        setInterval(function() {
                                counte--;
                                if (counte > 0) {
                                    diiv.style.opacity = counte / AmountOfActions;
                                }
                            },
                            10);
                    }, 3000);
                } else {
                    window.location.href = "../login/login.php";
                }

            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>
<?php
require "../../configuracion.php";
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");

$session = new Session();
if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
}

$datos = darDatosSubmitted();
$id =  $session->getUsuario()->getIdUsuario();
$abmcompra = new AbmCompra();
$param['idusuario'] = $id;
$compras =  $abmcompra->buscar($param);
$abmcompraestado = new AbmCompraEstado();

$listacompras = array();

foreach ($compras as $item) {

    $param['idcompra'] = $item->getIdCompra();
    $param['cefechafin'] = "NULL";
    $itemcompra = $abmcompraestado->buscar($param);
    if ($itemcompra) {
        if ($itemcompra[0]->getIdCompraEstadoTipo()->getIdCompraEstadoTipo() == '5') {
            array_push($listacompras, $itemcompra[0]);
        }
    }
}
$abmcompraitem = new AbmCompraItem();
$abmproducto = new AbmProducto();
$abmestadotipo = new AbmCompraEstadoTipo();
$listatabla = array();

foreach ($listacompras as $item) {
    $idcompra = $item->getIdCompra()->getIdCompra();
    $param['idcompra'] = $idcompra;
    $param['idproducto'] = null;
    $compraitem = $abmcompraitem->buscar($param);
    $param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
    $producto = $abmproducto->buscar($param);
    $param['idcompraestadotipo'] = $item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
    $estado = $abmestadotipo->buscar($param);

    array_push($listatabla, [$producto[0]->getProNombre(), $estado[0]->getCetDescripcion(), $item->getCeFechaIni(), $estado[0]->getIdCompraEstadoTipo(), $idcompra,$compraitem[0]->getCiCantidad(),$producto[0]->getIdProducto()]);
}

?>

<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 100px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <h4>Carrito</h4>
                    <table id="pedidostbl" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Sacar del carrito</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listatabla as $listaitem) {
                                echo '<tr>';
                                echo  '<td>' . $listaitem[0] . '</td>';
                                echo  '<td>' . $listaitem[5] . '</td>';
                                echo  '<td><button type="button" class="btn btn-danger" onclick="cancelar(' . $listaitem[4] . ')">Cancelar</button></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
                <hr>
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-primary" type="button" onclick="comprar()">Confirmar compra</button>
                    <button class="btn btn-danger" type="button" onclick="vaciar()">Vaciar carrito</button>
                </div>
            </div>
        </div>
    </div>
</section>

</html>

<?php include_once("../../estructura/footer.php"); ?>


<script>
    function cancelar(id) {
        $.ajax({
            url: './cancelarCarrito.php',
            type: 'post',
            dataType: 'json',
            data: {
                idcompra: id
            },
            success: function(response) {
                if (response) {
                    location.reload();
                }
            },
            error: function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }

    function comprar() {

        var passedArray = <?php echo json_encode($listatabla); ?>;

        $.ajax({
            url: './comprarCarrito.php',
            type: 'post',
            dataType: 'json',
            data: {
                lista: passedArray
            },
            success: function(response) {
                if (response) {
                    location.reload();
                    var diiv = document.getElementById("mensajeapp");
                    document.getElementById("mensajestr").innerHTML = "La compra fue realizada con exito!";
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
                }
            },
            error: function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }

    function vaciar() {

        var passedArray = <?php echo json_encode($listatabla); ?>;

        $.ajax({
            url: './vaciarCarrito.php',
            type: 'post',
            dataType: 'json',
            data: {
                lista: passedArray
            },
            success: function(response) {
                if (response) {
                    location.reload();   
                }
            },
            error: function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }
</script>
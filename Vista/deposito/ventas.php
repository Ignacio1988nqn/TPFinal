<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
}

$abmcompraestado = new AbmCompraEstado();
$abmcompraitem = new AbmCompraItem();
$abmproducto = new AbmProducto();
$abmestadotipo = new AbmCompraEstadoTipo();

$listacompras = array();
$listatabla = array();

$param['cefechafin'] = "NULL";
$itemcompra = $abmcompraestado->buscar($param);
if ($itemcompra) {
    foreach ($itemcompra as $item) {
        if ($item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo() != '5') {
            array_push($listacompras, $item);
        }
    }
}

foreach ($listacompras as $item) {

    $idcompra = $item->getIdCompra()->getIdCompra();
    $param['idcompra'] = $idcompra;
    $param['idproducto'] = null;
    $compraitem = $abmcompraitem->buscar($param);
    $param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
    $producto = $abmproducto->buscar($param);
    $param['idcompraestadotipo'] = $item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
    $estado = $abmestadotipo->buscar($param);

    array_push($listatabla, [$producto[0]->getProNombre(), $estado[0]->getCetDescripcion(), $item->getCeFechaIni(), $estado[0]->getIdCompraEstadoTipo(), $idcompra,$compraitem[0]->getCiCantidad()]);
}

?>

<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 100px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <h4>Ventas</h4>
                    <table id="pedidostbl" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Fecha Estado</th>
                                <th>Estado</th>                                
                                <th>Actualizar Estado</th>
                                <th>Cancelar pedido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listatabla as $listaitem) {
                                echo '<tr>';
                                echo  '<td>' . $listaitem[0] . '</td>';
                                echo  '<td>' . $listaitem[5] . '</td>';
                                echo  '<td>' . $listaitem[2] . '</td>';
                                echo  '<td>' . $listaitem[1] . '</td>';
                                if ($listaitem[3] != 4 && $listaitem[3] != 6) {
                                    echo  '<td><button type="button" class="btn btn-primary" onclick="actualizar(' . $listaitem[4] . ')">Actualizar</button></td>';
                                    echo  '<td><button type="button" class="btn btn-danger" onclick="cancelar(' . $listaitem[4] . ')">Cancelar</button></td>';
                                } else {
                                    echo  '<td><button type="button" class="btn btn-primary" onclick="actualizar(' . $listaitem[4] . ')" disabled>Actualizar</button></td>';
                                    echo  '<td><button type="button" class="btn btn-danger" onclick="cancelar(' . $listaitem[4] . ')" disabled>Cancelar</button></td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

</html>
<script>
    function actualizar(id) {
        $.ajax({
            url: './actualizarVenta.php',
            type: 'post',
            dataType: 'json',
            data: {
                idcompra: id
            },
            success: function(response) {
                if (response['insert']) {
                    var mensaje = "Cambio de estado exitoso";
                } else {
                    var mensaje = "No hay stock para este producto, no se pudo actualizar la compra";
                }
                var diiv = document.getElementById("mensajeapp");
                document.getElementById("mensajestr").innerHTML = mensaje;
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
                }, 4000);
                if (response['insert']) {
                    location.reload();
                }
            },
            error: function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }

    function cancelar(id) {
        $.ajax({
            url: './cancelarVenta.php',
            type: 'post',
            dataType: 'json',
            data: {
                idcompra: id
            },
            success: function(response) {
                if (response) {
                    location.reload();
                    var diiv = document.getElementById("mensajeapp");
                    document.getElementById("mensajestr").innerHTML = "La compra fue cancelada";
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
</script>
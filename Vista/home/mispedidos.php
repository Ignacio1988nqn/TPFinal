<?php

include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");

if (!$session->validar()) {
    redirect('../login/login.php');
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
        if ($itemcompra[0]->getIdCompraEstadoTipo() != '5') {
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

    array_push($listatabla, [$producto[0]->getProNombre(), $estado[0]->getCetDescripcion(), $item->getCeFechaIni(), $estado[0]->getIdCompraEstadoTipo(),$idcompra]);
}


?>
<section class="home-section">
    <div id="container" style="margin:50px 75px;height: 87vh;">
        <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
            <div class="mb-3 row">
                <h4>Mis Pedidos</h4>
                <table id="pedidostbl" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Fecha Estado</th>
                            <th>Estado</th>
                            <th>cancelar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listatabla as $listaitem) {
                            if ($listaitem[3] != 5) {
                                echo '<tr>';
                                echo  '<td>' . $listaitem[0] . '</td>';
                                echo  '<td>' . $listaitem[2] . '</td>';
                                echo  '<td>' . $listaitem[1] . '</td>';
                                if ($listaitem[3] == 1) {
                                    echo  '<td><button type="button" class="btn btn-danger" onclick="cancelar(' . $listaitem[4] . ')">Cancelar</button></td>';
                                } else {
                                    echo  '<td><button type="button" class="btn btn-danger" onclick="cancelar(' . $listaitem[4] . ')" disabled>Cancelar</button></td>';
                                }

                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

</html>

<script>
    function cancelar(id) {
        $.ajax({
            url: '../deposito/cancelarVenta.php',
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
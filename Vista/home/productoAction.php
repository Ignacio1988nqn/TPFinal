<?php
include_once "../../configuracion.php";
$datos = darDatosSubmitted();
$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);
$idProducto = $decoded_json->id;

$session = new Session();
if (!$session->validar()) {
    $retorno['estado'] = false;
} else {
    $retorno['estado'] = true;
    $retorno['insert'] = false;

    $abmcompra = new AbmCompra();

    $param['idusuario'] = $session->getUsuario()->getIdUsuario();
    $param['cofecha'] = date('Y-m-d H:i:s');

    if ($abmcompra->alta($param)) {

        $idcompra = $abmcompra->getLastInsertedID();
        $abmcompraitem = new AbmCompraItem();
        $param['idproducto'] = $idProducto;
        $param['idcompra'] = $idcompra;
        $param['cicantidad'] = 1;

        if ($abmcompraitem->alta($param)) {

            $abmcompraestado = new AbmCompraEstado();
            $param['idcompraestadotipo'] = 5;
            $param['idcompra'] = $idcompra;
            $param['cefechaini'] = date('Y-m-d H:i:s');

            if ($abmcompraestado->alta($param)) {
                $retorno['insert'] = true;
            }
        }
    }
}

echo json_encode($retorno);

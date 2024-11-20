<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$abmcompraestado = new AbmCompraEstado();
$abmcompraitem = new AbmCompraItem();

$listacomprar = $datos['lista'];

foreach ($listacomprar as $item) {

    $param['cefechaini'] =null;
    $param['idcompraestadotipo'] =null;
    $param['idcompra'] =  $item[4];
    $param['cefechafin'] = "NULL";
    $compraestadoitem = $abmcompraestado->buscar($param);
    $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
    $compraestadoitem[0]->modificar();
    $param['idcompra'] = $item[4];
    $param['idcompraestadotipo'] = 1;
    $param['cefechaini'] = date('Y-m-d H:i:s');
    $abmcompraestado->alta($param);
}

echo json_encode(['success' => true]);
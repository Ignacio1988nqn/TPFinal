<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$abmcompraestado = new AbmCompraEstado();

$param['cefechafin'] = "NULL";
$idcompra = $datos['idcompra'];
$param['idcompra'] = $idcompra;

$compraestadoitem = $abmcompraestado->buscar($param);

$compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
$compraestadoitem[0]->modificar();


echo json_encode(['success' => true]);

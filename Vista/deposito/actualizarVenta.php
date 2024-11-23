<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$abmDeposito = new AbmDeposito();
$idcompra = $datos['idcompra'];

$result = $abmDeposito->actualizarVenta($idcompra);
$retorno['insert'] = $result;

echo json_encode($retorno);

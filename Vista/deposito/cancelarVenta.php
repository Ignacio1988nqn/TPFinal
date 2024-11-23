<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$abmDeposito = new AbmDeposito();
$idcompra = $datos['idcompra'];

$abmDeposito->cancelarVenta($idcompra);
echo json_encode(['success' => true]);

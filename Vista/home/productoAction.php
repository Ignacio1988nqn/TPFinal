<?php
include_once "../../configuracion.php";
$datos = darDatosSubmitted();
$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);
$idProducto = $decoded_json->id;
$cantidad = $decoded_json->cantidad;

$abmCarrito = new AbmCarrito();
$retorno = $abmCarrito->addProducto($idProducto,$cantidad);

echo json_encode($retorno);

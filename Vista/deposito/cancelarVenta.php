<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$abmcompraestado = new AbmCompraEstado();
$abmcompraitem = new AbmCompraItem();
$abmproducto = new AbmProducto();
$abmcompra = new AbmCompra();
$abmusuario = new ABMUsuario();

$param['cefechafin'] = "NULL";
$idcompra = $datos['idcompra'];
$param['idcompra'] = $idcompra;

$compra = $abmcompra->buscar($param);
$compraestadoitem = $abmcompraestado->buscar($param);

$param['idusuario'] = $compra[0]->getIdUsuario()->getIdUsuario();
$usuario = $abmusuario->buscar($param);

$compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
$compraestadoitem[0]->modificar();
$param['idcompra'] = $idcompra;
$param['idcompraestadotipo'] = 4;
$param['cefechaini'] = date('Y-m-d H:i:s');
$abmcompraestado->alta($param);

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
$from = "ignacio.araya@est.fi.uncoma.edu.ar";
$to = $usuario[0]->getUsMail();
$subject = "Su compra ha sido cancelada";
$message = "Hola, ".$usuario[0]->getUsNombre(). " tu pedido ha sido cancelado";
$headers = "From:" . $from;
mail($to,$subject,$message, $headers);

echo json_encode(['success' => true]); 

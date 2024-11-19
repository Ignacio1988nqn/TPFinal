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
$compraitem = $abmcompraitem->buscar($param);

$param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
$producto = $abmproducto->buscar($param);
$estado = $compraestadoitem[0]->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();

$param['idusuario'] = $compra[0]->getIdUsuario()->getIdUsuario();
$usuario = $abmusuario->buscar($param);

if ($estado == 1) {
    if ($producto[0]->getProCantStock() > 0) {
        $nuevoestado = 2;
        $subject = "Estamos preparando tu pedido!";
        $message = "Hola, ".$usuario[0]->getUsNombre(). " tu pedido ya esta siendo preparado!";
    } else {
        echo json_encode(['error' => 'No hay stock para el producto']);
    }
} elseif ($estado == 2) {
    $nuevoestado = 3;
    $subject = "Tu pedido ya esta en camino!";
    $message = "Hola, ".$usuario[0]->getUsNombre(). " tu pedido ya esta en camino!";
} elseif ($estado == 3) {
    $nuevoestado = 6;
    $subject = "Compra finalizada";
    $message = "Muchas gracias ".$usuario[0]->getUsNombre(). " por tu compra, te invitamos a seguir conociendo nuestras ofertas!";
}

$compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
$compraestadoitem[0]->modificar();
$param['idcompra'] = $idcompra;
$param['idcompraestadotipo'] = $nuevoestado;
$param['cefechaini'] = date('Y-m-d H:i:s');
$abmcompraestado->alta($param);

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
$from = "ignacio.araya@est.fi.uncoma.edu.ar";
$to = $usuario[0]->getUsMail();
$headers = "From:" . $from;
mail($to,$subject,$message, $headers);

echo json_encode(['success' => true]); 

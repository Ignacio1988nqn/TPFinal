<?php 

include_once "../../../configuracion.php";
$datos = darDatosSubmitted(); 

$param['idproducto'] = $datos['idProducto'] ; 
$abmProducto = new AbmProducto(); 
$producto = $abmProducto->buscar($param); 

$retorno = [
    'idProducto' => $producto[0]->getIdProducto(), 
    'proNombre' => $producto[0]->getProNombre(), 
    'proDetalle' => $producto[0]->getProDetalle(), 
    'proStock' => $producto[0]->getProCantStock()
]; 

echo json_encode($retorno);

?> 


<?php 

include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

if (isset($datos['idProducto'])){
    $param['idproducto'] = $datos['idProducto']; 
    $param['pronombre'] = $datos['nombre']; 
    $param['prodetalle'] = $datos['detalle']; 
    $param['procantstock'] = $datos['stock']; 
    $param['tipo'] = $datos['tipo'];


    $abmProducto = new AbmProducto(); 
    if ($abmProducto->modificacion($param)){
        echo json_encode(true);
    } else {
        echo json_encode(['error' => 'No se pudo modificar el producto']);
    }
} else {
    echo json_encode(['error' => 'Faltan datos para modificar']);
}
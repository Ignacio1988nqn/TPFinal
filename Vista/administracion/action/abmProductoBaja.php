<?php 

include_once "../../../configuracion.php";
$datos = darDatosSubmitted(); 
if (isset($datos['idProducto'])){
    $abmProducto = new AbmProducto(); 
    $param['idproducto'] = $datos['idProducto']; 
    if ($abmProducto->baja($param)){
        echo json_encode(['success' => true]); 
    } else {
        echo json_encode(['error' => true]);
    }
}  else {
    echo json_encode(['error' => true]);
}

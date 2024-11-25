<?php 
include_once "../../../configuracion.php"; 
$datos = darDatosSubmitted(); 
if(isset($datos['idmenu'])){
    $abmMenu = new AbmMenu(); 
    $param['idmenu'] = $datos['idmenu'];
    $abmMenuRol = new AbmMenuRol(); 
    $colRelRol = $abmMenuRol->buscar($param);        //buscamos y eliminanos las relaciones con los roles            
    if (count($colRelRol)>0){
        foreach ($colRelRol as $unaRelacion){
            $unaRelacion->eliminar();             //eliminamos las relaciones asi da la baja 
        }
    }
    if($abmMenu->baja($param)){ 
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => true]);
    }
} else {
    echo json_encode(['error' => true]);
}
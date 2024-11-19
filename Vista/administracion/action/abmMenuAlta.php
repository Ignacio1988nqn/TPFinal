<?php 

include_once "../../../configuracion.php";

$datos = darDatosSubmitted(); 
$abmMenu = new AbmMenu(); 
$abmMenuRol = new AbmMenuRol(); 
if (isset($datos['menombre']) && isset($datos['medescripcion'])){

    $idpadre = isset($datos['idpadre']) && $datos['idpadre'] !== "" ? $datos['idpadre'] : NULL;
    $param['menombre'] = $datos['menombre'];
    $param['medescripcion'] = $datos['medescripcion'];
    $param['idpadre'] = $idpadre ;
    $param['medeshabilitado'] = isset($datos['medeshabilitado']) ? $datos['medeshabilitado'] : 0;
    //var_dump($param);
    if ($abmMenu->alta($param)){
        //relacion con roles 
        $ultimoId = $abmMenu->buscar(['menombre' => $param['menombre']])[0]->getIdMenu();
        
        foreach ($datos['roles'] as $rolId) {
            $paramMR = ['idmenu' => $ultimoId, 'idrol' => $rolId];
            if (!$abmMenuRol->alta($paramMR)) {
                echo json_encode(['success' => false, 'message' => 'Error al asignar un rol al menú']);
                exit;
            }
        }
        echo json_encode(['success' => true]);
        exit; 
    }
}else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
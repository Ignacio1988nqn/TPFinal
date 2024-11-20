<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idmenu = $datos['idmenu']; 
$abmMenu = new AbmMenu();
$param['idmenu'] = $idmenu;
$menu = $abmMenu->buscar($param); 
if (count($menu)>0){
    $idpadre = isset($datos['idpadre']) && $datos['idpadre'] !== '' ? $datos['idpadre'] : null;
    //buscamos en el abm un padre si es que se asigna para modificar 
    if ($idpadre !=null){
        $paramPadre['idmenu'] = $idpadre; 
        $menuPadre = $abmMenu->buscar($paramPadre); 
        if(count($menuPadre)>0){
            $menu[0]->setIdPadre($menuPadre[0]); 
        } else {
            $menu[0]->setIdPadre(null); 
        }
    } else {
        $menu[0]->setIdPadre(null); 
    }

    //actualiza para modificar
    $menu[0]->setMeNombre($datos['menombre']);
    $menu[0]->setMeDescrpcion($datos['medescripcion']);
    if (isset($datos['medeshabilitado']) && $datos['medeshabilitado'] == 'on') {
        $menu[0]->setMeDeshabilitado(null); 
    } else {
        $menu[0]->setMeDeshabilitado(date('Y-m-d H:i:s'));  
    }   
    $menu[0]->modificar(); 

    // eliminanos todas las relaciones del menu asi ponemos las nuevas 
    $abmMenuRol = new AbmMenuRol();
    $rolesAsignadosAnteriores = $abmMenuRol->buscar(['idmenu' => $idmenu]); 
    foreach ($rolesAsignadosAnteriores as $menuRol) {
        $menuRol->eliminar();
    }
    if (isset($datos['roles'])) {
        foreach ($datos['roles'] as $idrol) {
            $paramRol['idrol'] = $idrol;
            $abmRol = new ABMRol();
            $rol = $abmRol->buscar($paramRol);
            $paramMenuRol['idmenu'] = $menu[0]->getIdMenu();
            $paramMenuRol['idrol'] = $rol[0]->getIdRol();
            $abmMenuRol->alta($paramMenuRol); 
        }
    }
    if (isset($datos['selectRol'])) {
        $paramRol['idrol'] = $datos['selectRol'];
        $rol = $abmRol->buscar($paramRol);
        if (count($rolesAsignadosAnteriores) > 0) {
            $menuRol = $rolesAsignadosAnteriores[0];
            $menuRol->setRol($rol[0]);
            $menuRol->modificar();
        }
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['sucess'=>false]);
}



?>

<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();
$idmenu = $datos['idmenu'];
$abmMenu = new AbmMenu();
$menus = $abmMenu->buscar(['idmenu' => $idmenu]);
if (count($menus) > 0) {
    $param = [
        'idmenu' => $idmenu,
        'menombre' => $datos['menombre'],
        'medescripcion' => $datos['medescripcion'],
        'idpadre' => isset($datos['idpadre']) && $datos['idpadre'] !== '' ? $datos['idpadre'] : null,
        'medeshabilitado' => isset($datos['medeshabilitado']) && $datos['medeshabilitado'] == 'on' ? null : date('Y-m-d H:i:s'),
    ];

    $abmMenu->modificacion($param);
    //se eliminan todas las relaciones de los roles con determinado menu 
    $abmMenuRol = new AbmMenuRol();
    $paramMR['idmenu'] = $idmenu;
    $rolesAsignadosAnteriores = $abmMenuRol->buscar($paramMR);
    foreach ($rolesAsignadosAnteriores as $menuRol) {
        $menuRol->eliminar();
    }

    //se asignan los nuevos roles  en las relaciones menu-rol 
    if (isset($datos['roles'])) {
        foreach ($datos['roles'] as $idrol) {
            $paramRol['idrol'] = $idrol;
            $abmRol = new ABMRol();
            $rol = $abmRol->buscar($paramRol);
            $paramMenuRol['idmenu'] = $menus[0]->getIdMenu();  
            $paramMenuRol['idrol'] = $rol[0]->getIdRol();
            $abmMenuRol->alta($paramMenuRol);
        }
    }

    //si hay un rol seleccionado 
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
    echo json_encode(['success' => false, 'message' => 'Menú no encontrado.']);
}


?>

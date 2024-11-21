<?php 

include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idMenu = $datos['idmenu']; 
$abmMenu = new AbmMenu(); 
$param['idmenu'] = $idMenu; 
$menu = $abmMenu->buscar($param); 
$retorno = []; 

if ($menu) {
    $menuObj = $menu[0];
    //devuelve los datos 
    $retorno['idmenu'] = $menuObj->getIdMenu();
    $retorno['menombre'] = $menuObj->getMeNombre();
    $retorno['medescripcion'] = $menuObj->getMeDescripcion();
    $medeshabilitado = $menuObj->getMeDeshabilitado();
    if ($medeshabilitado == '0000-00-00 00:00:00' || $medeshabilitado==null) {
        $retorno['medeshabilitado'] = null; 
    } else {
        $retorno['medeshabilitado'] = $medeshabilitado;
    }
    //roles asociados al menú
    $abmMenuRol = new AbmMenuRol();
    $rolesAsociados = $abmMenuRol->buscar(['idmenu' => $idMenu]);
    //colecciona los roles asociados para mostrarlos en el check 
    $retorno['roles'] = [];
    foreach ($rolesAsociados as $menuRol) {
    $retorno['roles'][] = $menuRol->getIdRol()->getIdRol(); 
    }
     
    //si hay id padre, lo muestra, si no lo deja vacio. 
    $menuPadre = $menuObj->getIdPadre();
    if ($menuPadre) {
        $retorno['idpadre'] = $menuPadre->getIdMenu();
    } else {
        $retorno['idpadre'] = null;
    }
} else {
    $retorno['error'] = 'Menú no encontrado';
}
echo json_encode($retorno);

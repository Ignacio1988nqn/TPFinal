<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idusuario = $datos['id'];

$abmusuario = new ABMUsuario();
$param['idusuario'] = $idusuario;
$usuario = $abmusuario->buscar($param);

if (isset($datos['habilitado'])) {
    $usuario[0]->setUsDeshabilitado(null);
} else {
    $usuario[0]->setUsDeshabilitado(date('Y-m-d H:i:s'));
}

$usuario[0]->modificar();

$abmusuariorol = new ABMUsuarioRol();
$userrol = $abmusuariorol->buscar($param);
//si tiene mas de un rol, en la tbala de usuariorol, esta designado do veces
// la primera con rol y la segunda con otro 
foreach ($userrol as $us){
    $us->eliminar();  //elima loos antiguos para volver a empezar
}

if (isset($datos['roles'])){
    foreach($datos['roles'] as $idrol){    //para cada id pasa 
        $param['idrol'] = $idrol; 
        $abmrol = new ABMRol();
        $rol = $abmrol->buscar($param);
        $paramUsuarioRol['idusuario'] = $usuario[0]->getIdUsuario();  
        $paramUsuarioRol['idrol'] = $rol[0]->getIdRol(); 
        $abmusuariorol->alta($paramUsuarioRol);             //sube dist roles en caso de mas un check
    }
}
if (isset($datos['selectRol'])) {                    //solo rol 
    $param['idrol'] = $datos['selectRol'];
    $rol = $abmrol->buscar($param);
    $userrol[0]->setRol($rol[0]);               //ya actualizado con los nuevos roles 
    $userrol[0]->modificar();
}

echo json_encode(true);
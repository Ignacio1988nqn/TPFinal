<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();
$idusuario = $datos['usuario'];
$abmusuario = new ABMUsuario();
$param['idusuario'] = $idusuario;
$usuario = $abmusuario->buscar($param);       //obtiene los datos de usuario 
$abmusuariorol = new ABMUsuarioRol();
$userrol = $abmusuariorol->buscar($param);    //obtiene las relaciones de un usario y un rol 
$abmrol = new ABMRol();
$todosRoles = $abmrol->buscar(null);      //obtiene los roles 
$retorno['usnombre'] = $usuario[0]->getUsNombre();
$retorno['usmail'] = $usuario[0]->getUsMail();
$retorno['id'] = $usuario[0]->getIdUsuario();
$retorno['usrol'] = [];                   //para manejar distintos roles 
foreach($userrol as $ur){
    $retorno['usrol'][] = $ur->getRol()->getIdRol(); 
}
$retorno['usdesabilitado'] = $usuario[0]->getUsDeshabilitado();
echo json_encode($retorno);

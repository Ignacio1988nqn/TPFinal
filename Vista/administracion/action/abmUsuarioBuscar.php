<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idusuario = $_POST['usuario'];

$abmusuario = new ABMUsuario();
$param['idusuario'] = $idusuario;
$usuario = $abmusuario->buscar($param);

$abmusuariorol = new ABMUsuarioRol();
$userrol = $abmusuariorol->buscar($param);

$abmrol = new ABMRol();
$todosRoles = $abmrol->buscar(null);

$retorno['usnombre'] = $usuario[0]->getUsNombre();
$retorno['usmail'] = $usuario[0]->getUsMail();
$retorno['id'] = $usuario[0]->getIdUsuario();
$retorno['usrol'] = $userrol[0]->getRol()->getIdRol();
$retorno['usdesabilitado'] = $usuario[0]->getUsDeshabilitado();

echo json_encode($retorno);

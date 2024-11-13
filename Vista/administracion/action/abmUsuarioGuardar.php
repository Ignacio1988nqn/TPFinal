<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idusuario = $_POST['id'];

$abmusuario = new ABMUsuario();
$param['idusuario'] = $idusuario;
$usuario = $abmusuario->buscar($param);

if (isset($_POST['habilitado'])) {
    $usuario[0]->setUsDeshabilitado(null);
} else {
    $usuario[0]->setUsDeshabilitado(date('Y-m-d H:i:s'));
}

$usuario[0]->modificar();

$abmusuariorol = new ABMUsuarioRol();
$userrol = $abmusuariorol->buscar($param);
$param['idrol'] = $_POST['selectRol'];

$abmrol = new ABMRol();
$rol = $abmrol->buscar($param);

$userrol[0]->setRol($rol[0]);
$userrol[0]->modificar();


echo json_encode(true);
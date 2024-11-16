<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$idRol = $datos['rol']; 
$abmRol = new ABMRol(); 

$param['idrol'] = $idRol; 
$rol = $abmRol->buscar($param);

$retorno = [
    'idrol' => $rol[0]->getIdRol(),
    'descripcion' => $rol[0]->getRoDescripcion()
] ; 

echo json_encode($retorno);

?> 


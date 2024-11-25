<?php 

include_once "../../../configuracion.php";

$datos = darDatosSubmitted();
$idMenu = $datos['idmenu']; 
$abmMenu = new AbmMenu(); 
$retorno = $abmMenu->buscarInfo($idMenu); //fun que busca y devuelve tdos los detalles 

echo json_encode($retorno);

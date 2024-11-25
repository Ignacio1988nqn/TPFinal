<?php 

include_once "../../../configuracion.php";

$datos = darDatosSubmitted(); 
$abmMenu = new AbmMenu();

$resp = $abmMenu->altaMenuYRol($datos);
echo json_encode($resp);
?>
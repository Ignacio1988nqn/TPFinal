<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();
$abmMenu = new AbmMenu();
$res = $abmMenu->modificarMenu($datos); 

echo json_encode($res); 

?>

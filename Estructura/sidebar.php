<?php
$session = new Session();
$val = 9;
if ($session->validar()) {
    $rolSelec = $session->getRolSelec(); 
    if ($rolSelec !== null){
        $val = $rolSelec; 
    } else {
        foreach ($session->getRol() as $rol) {
            $val = $rol->getIdRol();
        }
    }
   
}

$param['idrol'] = $val;
$menurol = new AbmMenuRol();
$menurolLista =  $menurol->buscar($param);
$menu = new AbmMenu();
?>
<div class="sidebar">
    <ul class="nav-links">
        <?php
        foreach ($menurolLista as $lis) {
            $param['idmenu'] = $lis->getIdMenu()->getIdMenu();
            $menuItem = $menu->buscar($param);
            $deshabilitado = $menuItem[0]->getMeDeshabilitado(); 
            if ($deshabilitado == null || $deshabilitado == '0000-00-00 00:00:00'){
                echo "<li>";
                echo " <a href='" . $menuItem[0]->getMeDescripcion() . "'>";
                echo "<i class='bx bx-collection'></i>";
                echo "<span class='link_name'>" . $menuItem[0]->getMeNombre() . "</span>";
                echo " </a>";
                echo " </li>";
           }
        }
        ?>
    </ul>
</div>
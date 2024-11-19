<?php
$session = new Session();
$val = 9;
if ($session->validar()) {
    foreach ($session->getRol() as $rol) {
        $val = $rol->getIdRol();
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
            if ($menuItem[0]->getIdPadre() == null) {
                echo "<li>";
                echo " <a href='" . $menuItem[0]->getMeDescripcion() . "'>";
                echo "<i class='bx bx-collection'></i>";
                echo "<span class='link_name'>" . $menuItem[0]->getMeNombre() . "</span>";
                echo " </a>";
            }

            foreach ($menurolLista as $submenu) {
                $param['idmenu'] = $submenu->getIdMenu()->getIdMenu();
                $submenuItem = $menu->buscar($param);
                if ($submenuItem[0]->getIdPadre() != null) {
                    if ($menuItem[0]->getIdMenu() == $submenuItem[0]->getIdPadre()->getIdMenu()) {
                        echo "<li class='showMenu'>";
                        echo "<ul class='sub-menu' style='margin-left: 15px;'>";
                        echo      "  <li><a class='link_name' href='#'>TP4 - PHP-MYSQL</a></li>";
                        echo      "  <li class='nav-item'>";
                        echo      "      <a class='nav-link' href='" . $submenuItem[0]->getMeDescripcion() . "'>" . $submenuItem[0]->getMeNombre() . "</a>";
                        echo      "  </li>";
                        echo     "</ul>";
                        echo " </li>";
                    }
                }
            }
            echo " </li>";
        }
        ?>
    </ul>
</div>
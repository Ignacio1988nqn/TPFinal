<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
}

$menus = new AbmMenu();
$listaMenus = $menus->buscar(null);
$comboMenu = '<select id="menu" name="menu" class="form-select" required>';
$comboMenu .= '<option value="">Seleccione Menú...</option>';
foreach ($listaMenus as $menu) {
    $comboMenu .= '<option value="' . $menu->getIdMenu() . '">' . htmlspecialchars($menu->getMenombre()) . '</option>';
}
$comboMenu .= '</select>';


//Rol dinamico checkbox para manejar distintos roles 
$roles = new ABMRol();
$listaRoles = $roles->buscar(null);

$comboRol = '';
foreach ($listaRoles as $rol) {
    $checked = '';
    $comboRol .= '<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="' . $rol->getIdRol() . '" id="rol_' . $rol->getIdRol() . '" name="roles[]">
                    <label class="form-check-label" for="rol_' . $rol->getIdRol() . '">' . htmlspecialchars($rol->getRoDescripcion()) . '</label>
                  </div>';
}
?>

<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin: 50px 20px; min-height: 87vh; width: 90%; overflow: auto;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <form id="selectForm">
                        <div class="mb-3 row">
                            <label for="rol" class="col-sm-2 col-form-label">Menús</label>
                            <div class="col-sm-3">
                                <?php
                                echo $comboMenu;
                                ?>
                                <button type="button" style="margin-top: 20px;" class="btn btn-primary" onclick="buscar()">Buscar</button>
                                <button type="button" style="margin-top: 20px;" class="btn btn-success" onclick="nuevo()">Nuevo Menú</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <form id="formMenu" name="formMenu">
                <div id="data" class="bd" style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4>Informacion del Menú</h4>

                    <input type="hidden" readonly="" class="form-control-plaintext" id="idmenu" name="idmenu" value="">
                    <input type="hidden" id="accion" name="accion" value="modificar">

                    <div class=" mb-3 row">
                        <label for="menombre" class="col-sm-2 col-form-label">Nombre: </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="menombre" name="menombre">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="medescripcion" class="col-sm-2 col-form-label">Descripción: </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="medescripcion" name="medescripcion">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="idpadre" class="col-sm-2 col-form-label"> Menu Padre: </label>
                        <div class="col-sm-4">
                            <select id="idpadre" name="idpadre" class="form-select">
                                <option value="">Ninguno</option>
                                <?php
                                foreach ($listaMenus as $menuPadre) {
                                    $selected = ($menuPadre->getIdMenu() == $menu->getIdPadre()) ? 'selected' : '';
                                    echo '<option value="' . $menuPadre->getIdMenu() . '" ' . $selected . '>' . htmlspecialchars($menuPadre->getMenombre()) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="medeshabilitado" class="col-sm-2 col-form-label">Habilitado: </label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" name="medeshabilitado" id="medeshabilitado">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="selectRol" class="col-sm-2 col-form-label">Rol con permiso</label>
                        <div class="col-sm-2">
                            <div class="selDiv">
                                <?php echo $comboRol; ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;margin-left: 220px;" onclick="guardar()">Guardar</button>
                    <button type="button" class="btn btn-danger" style="margin-top: 20px;" onclick="borrar()" id="botonEliminar">Eliminar</button>
            </form>

        </div>
    </div>
</section>
<?php
include_once("../../estructura/footer.php");
?>

<script>
    function buscar() {
        let idMenu = $('#menu').val() //tomo el menu seleccionado 
        $.ajax({
            url: './action/abmMenuBuscar.php',
            type: 'POST',
            dataType: 'json',
            data: {
                idmenu: idMenu
            },
            success: function(response) {
                $('#idmenu').val(response.idmenu);
                $('#menombre').val(response.menombre);
                $('#medescripcion').val(response.medescripcion);
                $('#idpadre').val(response.idpadre !== null ? response.idpadre : '');
                if (response.medeshabilitado === null || response.medeshabilitado === '0000-00-00 00:00:00') {
                    $('#medeshabilitado').prop('checked', true);
                } else {
                    $('#medeshabilitado').prop('checked', false);
                }
                
                var rolesAsignados = response['roles'];
                $('input[name="roles[]"]').each(function() {
                    var checkbox = $(this);
                    if (rolesAsignados.includes(parseInt(checkbox.val()))) {
                        checkbox.prop('checked', true); //si esta asignado, lo marca 
                    } else {
                        checkbox.prop('checked', false);
                    }
                });
                $('#accion').val('modificar');
                document.getElementById('data').style.display = "block";
                $('#selectRol option[value="' + data['roles'] + '"]').attr("selected", "selected");
            },
            error: function(request, status, error) {
                alert('Error al cargar el menú: ' + request.responseText);
            }
        });
    }

    function guardar() {
        let accion = $('#accion').val(); //dependendiendo de la accion lo mandaa a una url distinta 
        let url = (accion === 'crear') ? './action/abmMenuAlta.php' : './action/abmMenuModificar.php';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $('#formMenu').serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Menú guardado con éxito');
                    window.location.href = 'abmMenu.php';
                } else {
                    alert('No se pudo modificar: ' + response.error);
                }
            },
            error: function(request, status, error) {
                alert('Error al guardar el menú: ' + request.responseText);
            }
        });
    }

    function nuevo() {
        $('#accion').val('crear');
        $('#idmenu').val('');
        $('#menombre').val('');
        $('#medescripcion').val('');
        $('#idpadre').val('');
        $('#medeshabilitado').prop('checked',false);
        $('#selectRol input[type="checkbox"]').prop('checked',false);
        $('#botonEliminar').prop('disabled',true); 
        document.getElementById('data').style.display = "block";
    }

    function borrar() {
        let idMenu = $('#idmenu').val();
        $.ajax({
            url: './action/abmMenuBaja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                idmenu: idMenu
            },
            success: function(response) {
                alert('Menú eliminado con éxito');
                window.location.href = 'abmMenu.php';
            },
            error: function(request, status, error) {
                alert('Error al eliminar el menú: ' + request.responseText);
            }
        });
    }
</script>
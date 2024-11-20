<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
}

$usuarios = new ABMUsuario();
$usuariosLista = $usuarios->buscar(null);


$combo = '<select   id="usuario"  name="usuario" class="form-select" required>';
// <option value="">Seleccione... </option>';
foreach ($usuariosLista as $obj) {
    $combo .= '<option value="' . $obj->getIdUsuario() . '">' . $obj->getUsNombre() . '</option>';
}

$combo .= '</select>';


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
        <div id="container" style="margin:50px 75px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <form id="selectForm">
                        <div class="mb-3 row">
                            <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                            <div class="col-sm-2">
                                <?php
                                echo $combo;
                                ?>
                                <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                                    onclick="buscar()">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <form id="dataform">
                <div id="data" class="bd" style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <div class=" mb-3 row">
                        <label for="id" class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" id="id" name="id" value="">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" id="nombre" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" id="email"
                                value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="selectRol" class="col-sm-2 col-form-label">Rol</label>
                        <div class="col-sm-2">
                            <div class="selDiv">
                            <?php
                            echo $comboRol; 
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="habilitado" class="col-sm-2 col-form-label">Habilitado</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="habilitado" name="habilitado">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="guardar()"
                        style="margin-top: 20px;margin-left: 220px;">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarUsuario()" style="margin-top: 20px;">Eliminar Usuario</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</section>
<?php
include_once("../../estructura/footer.php");
?>

<script>
    function buscar() {
        $.ajax({
            url: './action/abmUsuarioBuscar.php',
            type: 'post',
            dataType: 'json',
            data: $('form#selectForm').serialize(),
            success: function(data) {
                document.getElementById('data').style.display = "block";
                document.getElementById('id').value = data['id'];
                document.getElementById('nombre').value = data['usnombre'];
                document.getElementById('email').value = data['usmail'];
                var rolesAsignados = data['usrol']; 
                $('input[name="roles[]"]').each(function() {
                    var checkbox = $(this);
                    if (rolesAsignados.includes(parseInt(checkbox.val()))) {
                        checkbox.prop('checked', true); //si esta asignado, lo marca 
                    } else {
                        checkbox.prop('checked', false);
                    }
                });
                if (data['usdesabilitado'] == null) {
                    document.getElementById("habilitado").checked = true;
                } else {
                    document.getElementById("habilitado").checked = false;
                }

                $('#selectRol option[value="' + data['usrol'] + '"]').attr("selected", "selected");
                
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function guardar() {
        var rolesSeleccionados = [];
        $('input[name="roles[]"]:checked').each(function() {
            rolesSeleccionados.push($(this).val());
        });
        var habilitado = $('#habilitado').prop('checked') ? 1 : 0;
        $.ajax({
            url: './action/abmUsuarioGuardar.php',
            type: 'post',
            dataType: 'json',
            data: {
                id: $('#id').val(),
                nombre: $('#nombre').val(),
                email: $('#email').val(),
                habilitado: habilitado,
                roles: rolesSeleccionados 
            }, 
            success: function(data) {
                alert("Los Cambios se Realizaron exitosamente");  
                window.location.href = 'abmUsuarios.php';
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function eliminarUsuario(){
        $.ajax({
            url: './action/abmUsuarioBaja.php', 
            type: 'post', 
            dataType: 'json', 
            data: { id: $('#id').val()} , 
            success: function(data){
                if (data.success){
                    alert("Usuario Eliminado"); 
                    window.location.href = 'abmUsuarios.php';
                } else {
                    alert("No se pudo eliminar el usuario");
                }
            }, 
            error: function(request, status, error){
                alert(request.responseText); 
            }
        }); 
    }

</script>
<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    redirect('../login/login.php');
}

$usuarios = new ABMUsuario();
$usuariosLista = $usuarios->buscar(null);


$combo = '<select   id="usuario"  name="usuario" class="form-select" required>';
// <option value="">Seleccione... </option>';
foreach ($usuariosLista as $obj) {
    $combo .= '<option value="' . $obj->getIdUsuario() . '">' . $obj->getUsNombre() . '</option>';
}

$combo .= '</select>';

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
                                <select id="selectRol" name="selectRol" class="form-select" aria-label="Default select example">
                                    <option selected>Seleccione...</option>
                                    <option value="1">Cliente</option>
                                    <option value="2">Administrador</option>
                                </select>
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
                document.getElementById('selectRol').value = true;
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
        $.ajax({
            url: './action/abmUsuarioGuardar.php',
            type: 'post',
            dataType: 'json',
            data: $('form#dataform').serialize(),
            success: function(data) {
                alert("Los Cambios se Realizaron exitosamente");  
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>
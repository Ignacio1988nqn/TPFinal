<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    redirect('../login/login.php');
}
?>
<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 75px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <label for="usuario" class="col-sm-2 col-form-label">Rol</label>
                    <div class="col-sm-2">
                        <div class="col-sm-12">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Seleccione...</option>
                                <option value="1">Cliente</option>
                                <option value="2">Administrador</option>
                            </select>

                        </div>
                        <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                            onclick="buscarMenu()">Buscar</button>
                    </div>
                </div>
                <div id="menus" style="display: none;">
                    <div class="mb-3 row">
                        <hr style="margin-top: 20px;">
                        <label for="usuario" class="col-sm-2 col-form-label">Menús</label>
                        <div class="col-sm-2">
                            <div class="col-sm-12">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Seleccione...</option>
                                    <option value="1">ABM Usuarios</option>
                                    <option value="2">ABM Roles</option>
                                    <option value="3">ABM Menu</option>
                                </select>
                                <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                                    onclick="buscar()">Buscar</button>
                                <button type="button" style="margin-top: 20px;" class="btn btn-success"
                                    onclick="nuevo()">Nuevo Rol</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div id="data" class="bd"
                style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                <h4>Modificar Menú</h4>
                <div class=" mb-3 row">
                    <label for="idmenu" class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" readonly="" class="form-control-plaintext" id="idmenu" value="12">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="ABM Test" id="descripcion">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="Un Test" id="descripcion">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="idpadre" class="col-sm-2 col-form-label">Id Padre</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" value="2" id="descripcion">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="habilitado" class="col-sm-2 col-form-label">Habilitado</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="margin-top: 20px;margin-left: 220px;">Modificar</button>
            </div>
            <div id="dataNuevo" class="bd"
                style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                <h4>Nuevo Menú</h4>
                <div class=" mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="ABM Test" id="descripcion">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="Un Test" id="descripcion">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="idpadre" class="col-sm-2 col-form-label">Id Padre</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" value="2" id="descripcion">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="margin-top: 20px;margin-left: 220px;">Agregar</button>
            </div>
        </div>
    </div>
    </div>
</section>
<?php
include_once("../../estructura/footer.php");
?>

<script>
    function buscarMenu() {
        document.getElementById('menus').style.display = "block";
        document.getElementById('data').style.display = "none";
        document.getElementById('dataNuevo').style.display = "none";

    }

    function buscar() {
        document.getElementById('data').style.display = "block";
        document.getElementById('dataNuevo').style.display = "none";

    }

    function nuevo() {
        document.getElementById('data').style.display = "none";
        document.getElementById('dataNuevo').style.display = "block";
    }
</script>
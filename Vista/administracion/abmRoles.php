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
                            onclick="buscar()">Buscar</button>
                        <button type="button" style="margin-top: 20px;" class="btn btn-success"
                            onclick="nuevo()">Nuevo Rol</button>
                    </div>
                </div>
            </div>
            <hr>
            <form>
                <div id="data" class="bd"
                    style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4>Modificar Rol</h4>
                    <div class=" mb-3 row">
                        <label for="nombre" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="descripcion" id="descripcion">
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
            </form>
            <div id="dataNuevo" class="bd"
                style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                <h4>Nuevo Rol</h4>
                <div class=" mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="descripcion">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="habilitado" class="col-sm-2 col-form-label">Habilitado</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="margin-top: 20px;margin-left: 220px;">Agregar</button>
            </div>
        </div>
    </div>
</section>
<?php
include_once("../../estructura/footer.php");
?>

<script>
    function buscar() {
        document.getElementById('data').style.display = "block";
        document.getElementById('dataNuevo').style.display = "none";

    }

    function nuevo() {
        document.getElementById('data').style.display = "none";
        document.getElementById('dataNuevo').style.display = "block";
    }
</script>
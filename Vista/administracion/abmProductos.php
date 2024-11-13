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
                    <label for="usuario" class="col-sm-2 col-form-label">Productos</label>
                    <div class="col-sm-2">
                        <div class="col-sm-12">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Seleccione...</option>
                                <option value="1">Producto1</option>
                                <option value="2">Producto2</option>
                            </select>
                        </div>
                        <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                            onclick="buscar()">Buscar</button>
                        <button type="button" style="margin-top: 20px;" class="btn btn-success"
                            onclick="nuevo()">Nuevo Producto</button>
                    </div>
                </div>
            </div>
            <hr>
            <form>
                <div id="data" class="bd"
                    style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4>Modificar Producto</h4>
                    <div class=" mb-3 row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="nombre" id="nombre">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="detalle" class="col-sm-2 col-form-label">Detalle</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="detalle" id="detalle">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="stock" class="col-sm-2 col-form-label">Cant. Stock</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" value="1" id="stock">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="margin-top: 20px;margin-left: 220px;">Modificar</button>
                </div>
            </form>
            <div id="dataNuevo" class="bd"
                style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                <h4>Nuevo Producto</h4>
                <div class=" mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="nombre" id="nombre">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="detalle" class="col-sm-2 col-form-label">Detalle</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="detalle" id="detalle">
                    </div>
                </div>
                <div class=" mb-3 row">
                    <label for="stock" class="col-sm-2 col-form-label">Cant. Stock</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" value="1" id="stock">
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
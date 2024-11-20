<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
}

$roles = new ABMRol(); 
$listaRoles = $roles->buscar(null);

$comboRol = '<select id="rol" name="rol" class="form-select" required>';
$comboRol .= '<option value="">Seleccione...</option>';
foreach ($listaRoles as $rol) {
    $comboRol .= '<option value="' . $rol->getIdRol() . '">' . htmlspecialchars($rol->getRoDescripcion()) . '</option>';

}

$comboRol .= '</select>';

?>
<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 75px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                <form id="selectForm">
                    <div class="mb-3 row">
                        <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                        <div class="col-sm-2">
                            <?php
                            echo $comboRol; 
                            ?>
                            <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                                onclick="buscar()">Buscar</button>
                            <button type="button" style="margin-top: 20px;" class="btn btn-success"
                                onclick="nuevo()">Nuevo Rol</button>
                        </div>
                    </div>
                </form>
            </div> 
            <form id="formModificar">
                <div id="data" class="bd"
                    style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4>Modificar Rol</h4>
                    <input type="hidden" id="idrol" name="idrol" value="">
                    <div class=" mb-3 row">
                        <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="" id="descripcion" name="descripcion">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary"  onclick="guardar()"
                        style="margin-top: 20px;margin-left: 220px;">Modificar</button>
                    <button type="button" class="btn btn-danger" onclick="borrado()"
                        style="margin-top: 20px;margin-left: 20px;">Borrar </button>
                </div>
            </form>
            <form id="formNuevoRol" onsubmit="event.preventDefault(); guardarNuevo();">
                <div id="dataNuevo" class="bd"
                    style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4>Nuevo Rol</h4>
                    <div class=" mb-3 row">
                        <label for="descripcionNuevo" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="descripcionNuevo" name="descripcionNuevo">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="margin-top: 20px;margin-left: 220px;">Agregar</button>
                </div>
            </form>
            
        </div>
    </div>
</sectio >
<?php
include_once("../../estructura/footer.php");
?>

<script>
    function buscar() {
        const selectedRol = $('#rol').val(); //valor del select
        if (!selectedRol) {
            alert("Por favor selecciona un rol.");
            return;
        }
        $.ajax({
            url: './action/abmRolBuscar.php',
            type: 'post', 
            dataType: 'json', 
            data: { rol: selectedRol },
            success: function(data){
                document.getElementById('data').style.display = "block";
                document.getElementById('dataNuevo').style.display = "none";
                console.log('Respuesta del servidor:', data);
                $('#descripcion').val(data.descripcion); 
                $('#idrol').val(data.idrol); 
            },
            error: function(request, status, error){
                alert('Error: ' + request.responseText);
            }
        });
    }

    function nuevo() {
        document.getElementById('data').style.display = "none";
        document.getElementById('dataNuevo').style.display = "block";
    }

    function guardar(){
        $.ajax({
            url: './action/abmRolModificar.php',
            type: 'post',
            dataType: 'json', 
            data: $('form#formModificar').serialize(),
            success: function(data){

                alert("Rol modificado con exito");
                window.location.href = 'abmRoles.php'; 
            },
            error: function(request,status,error){
                alert('Error: ' + request.responseText);
            }
        });
    }

    function guardarNuevo(){
        $.ajax({
            url: './action/abmRolNuevo.php',
            type: 'post', 
            dataType: 'json',
            data: { descripcion: $('#descripcionNuevo').val()}, 
            success: function(response){
                alert("Nuevo rol agregado con exito");
                window.location.href = 'abmRoles.php'; 
            }, 
            error: function(request, status, error){
                alert('Error: ' + request.responseText);
            }
        });
    }

    function borrado(){
        $.ajax({
            url: './action/abmRolBorrado.php',
            type: 'post', 
            dataType: 'json',
            data: { rol: $('#rol').val()},
            success: function(response){
                alert ("Rol Eliminado con exito"); 
                window.location.href = 'abmRoles.php'; 
            }, 
            error: function(request, status, error){
                alert ('Error: ' + request.responseText);
            }
        });
    }
</script>

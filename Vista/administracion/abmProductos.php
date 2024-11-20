<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    redirect('../login/login.php');
}

$objProucto = new AbmProducto(); 
$listaProductos = $objProucto->buscar(null); 
$comboProductos = '<select id="productoSelect" class="form-control" required>';
$comboProductos .= '<option value="">Seleccione...</option>';
foreach ($listaProductos as $producto) {
    $comboProductos .= '<option value="' . $producto->getIdProducto() . '">' . htmlspecialchars($producto->getProNombre()) . '</option>';
}
$comboProductos .= '</select>';

?>
<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 75px;height: 87vh;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <label for="usuario" class="col-sm-2 col-form-label">Productos</label>
                    <div class="col-sm-2">
                            <?php echo $comboProductos; ?>
                        <div class="col-sm-6">
                            <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                                onclick="buscar()">Buscar</button>
                            <button type="button" style="margin-top: 20px;" class="btn btn-success"
                                onclick="nuevoProducto()">Nuevo Producto</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div>
            <form id="formProducto" onsubmit="event.preventDefault(); guardarProducto();" enctype="multipart/form-data">
                <div id="data" class="bd"
                    style="background-color: white; padding: 60px;border-radius: 10px;display:none">
                    <h4 id="Titulo">Informacion Producto </h4>
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    <input type="hidden" id="accion" name="accion" value="modificar">
                    <div class=" mb-3 row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre: </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="detalle" class="col-sm-2 col-form-label">Detalle: </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="detalle" id="detalle" required>
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="stock" class="col-sm-2 col-form-label">Cant. Stock: </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="stock" id="stock" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="imagen" class="col-sm-2 col-form-label">Imagen: </label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*"
                                onchange="subirImagen(this)">
                        </div>
                        <div class="col-sm-4">
                            <img id="vistaPrevia" src="" alt="Sin imagen" style="max-width: 150px; display: none;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Guardar</button>
                    <button type="button" class="btn btn-danger" style="margin-top: 20px;" onclick="borrarProducto()" id="btnEliminar">Eliminar</button>
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
        let productoId = $('#productoSelect').val();  //tomo el producto seleccionado 
        $.ajax({
            url: './action/abmProductoBuscar.php',
            type: 'post', 
            dataType: 'json', 
            data: {idProducto: productoId},
            success: function(response){
                
                $('#idProducto').val(response.idProducto); 
                $('#nombre').val(response.proNombre);
                $('#detalle').val(response.proDetalle);
                $('#stock').val(response.proStock);
                $('#accion').val('modificar');   
                document.getElementById('data').style.display = "block";
                // document.getElementById('dataNuevo').style.display = "none";
            }, 
            error:function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }

    function nuevoProducto(){
        //al compratir dormulario, solo establezco el crear y limpio el form
        $('#accion').val('crear');  
        $('#nombre').val(''); 
        $('#detalle').val('');
        $('#stock').val('');
        document.getElementById('data').style.display = "block"; 
        // document.getElementById('dataNuevo').style.display = "none";
    }

    function guardarProducto(){
        let accion = $('#accion').val(); //toma la accion de modificar o crear producro 
        let url = (accion === 'crear') ? './action/abmProductoAlta.php' : './action/abmProductoModificar.php'; 
        //si es crear (como se establece en el nuevoProducto) pasa a Alta, 
        //pero si es modificar, solo toma el valor de la accion por defecto 
        $.ajax({
            url: url, 
            type: 'post',
            dataType: 'json',
            data: {
                nombre: $('#nombre').val(),
                detalle: $('#detalle').val(),
                stock: $('#stock').val(),
                idProducto: $('#idProducto').val(), 
            },
            success: function(response) {
                if (accion === 'crear') {
                    alert("Nuevo producto agregado con éxito");
                } else {
                    alert("Producto modificado con éxito");
                }
                window.location.href = 'abmProductos.php'; 
            },
            error: function(request, status, error) {
                alert('Error: ' + request.responseText);
            }
        });
    }

    function borrarProducto(){
        $.ajax({
            url: './action/abmProductoBaja.php',
            type: 'post', 
            dataType: 'json', 
            data: { idProducto: $('#idProducto').val()} , 
            success: function(response){
                alert('Producto Eliminado con Exito'); 
                window.location.href = 'abmProductos.php';
            }, 
            error: function (request, status, error) {
                alert('Error: ' + request.responseText); 
            }
        }); 
    }

    function nuevo() {
        document.getElementById('data').style.display = "none";
        // document.getElementById('dataNuevo').style.display = "block";
        $('#accion').val('crear'); 
    }

    
    function subirImagen(input){
        const formData = new FormData();                              //se prepara para agregar datos 
        formData.append('imagen', input.files[0]);                    // agrega 'imagen' al formdata 
        $.ajax({
            url: './action/subirImagen.php', 
            type: 'post', 
            data: formData, 
            processData: false, 
            contentType: false, 
            success: function(response){
                if(response.success){
                    $('#vistaPrevia').attr('src', '../../assets/image/' + response.nombre).show();
                    alert('La imagen se subio exitosamente');
                } 
            }, 
            error: function(request, status, error){
                alert('Error: ' + request.responseText);
            }
        });
}


</script>
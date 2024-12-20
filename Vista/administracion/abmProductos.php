<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
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
        <div id="container" style="margin:50px 75px; min-height: 87vh; width: 90%; overflow: auto;">
            <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
                <div class="mb-3 row">
                    <label for="usuario" class="col-sm-2 col-form-label">Productos</label>
                    <div class="col-sm-3">
                        <?php echo $comboProductos; ?>
                        <button type="button" style="margin-top: 20px;" class="btn btn-primary"
                            onclick="buscar()">Buscar</button>
                        <button type="button" style="margin-top: 20px;" class="btn btn-success"
                            onclick="nuevoProducto()">Nuevo Producto</button>
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
                        <div class=" mb-3 row">
                            <label for="tipo" class="col-sm-2 col-form-label">Categoria: </label>
                            <div class="col-sm-4">
                                <select id="tipo" name="tipo" class="form-select" required>
                                    <option value="1">Hogar</option>
                                    <option value="2">Celulares</option>
                                    <option value="3">Informática</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="imagen" class="col-sm-2 col-form-label">Imagen: </label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
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
        let productoId = $('#productoSelect').val(); //tomo el producto seleccionado 
        $.ajax({
            url: './action/abmProductoBuscar.php',
            type: 'post',
            dataType: 'json',
            data: {
                idProducto: productoId
            },
            success: function(response) {

                $('#idProducto').val(response.idProducto);
                $('#nombre').val(response.proNombre);
                $('#detalle').val(response.proDetalle);
                $('#stock').val(response.proStock);
                $('#accion').val('modificar');
                document.getElementById('data').style.display = "block";
                // document.getElementById('dataNuevo').style.display = "none";
            },
            error: function(request, status, error) {
                swal("No se pudo encontrar el producto");
            }
        });
    }

    function nuevoProducto() {
        //al compratir dormulario, solo establezco el crear y limpio el form
        $('#accion').val('crear');
        $('#nombre').val('');
        $('#detalle').val('');
        $('#stock').val('');
        document.getElementById('data').style.display = "block";
        // document.getElementById('dataNuevo').style.display = "none";
    }

    function guardarProducto() {
        let accion = $('#accion').val(); //toma la accion de modificar o crear producro 
        let url = (accion === 'crear') ? './action/abmProductoAlta.php' : './action/abmProductoModificar.php';
        //si es crear (como se establece en el nuevoProducto) pasa a Alta, 
        //pero si es modificar, solo toma el valor de la accion por defecto 

        const formData = new FormData(); //se prepara para agregar datos 
        var file_data = $('#imagen').prop('files')[0];
        formData.append('imagen', file_data); // agrega 'imagen' al formdata 
        formData.append('nombre', $('#nombre').val());
        formData.append('detalle', $('#detalle').val());
        formData.append('stock', $('#stock').val());
        formData.append('tipo', $('#tipo').val());

        formData.append('idProducto', $('#idProducto').val());
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (accion === 'crear') {
                    swal({
                        title: "Perfecto",
                        text: "Producto agregado con exito",
                        icon: "success",
                        button: "Recargar"
                    });
                } else {
                    swal({
                        title: "Perfecto",
                        text: "Producto modificado con exito",
                        icon: "success",
                        button: "Recargar"
                    });
                }
                setTimeout(function() {
                window.location.href = 'abmProductos.php';
            }, 3000)
            },
            error: function(request, status, error) {
                swal({
                title: "Error.",
                text: "No se pudo guardar el cambio",
                icon: "error",
                button: "Cerrar"
                });
            }
        });
    }

    function borrarProducto() {
        $.ajax({
            url: './action/abmProductoBaja.php',
            type: 'post',
            dataType: 'json',
            data: {
                idProducto: $('#idProducto').val()
            },
            success: function(response) {
                swal({
                    title: "Perfecto",
                    text: "Producto eliminado con exito",
                    icon: "success",
                    button: "Recargar"
                });
                setTimeout(function() {
                window.location.href = 'abmProductos.php';
            }, 3000)
            },
            error: function(request, status, error) {
                swal({
                title: "Error.",
                text: "No se logro eliminar el producto",
                icon: "error",
                button: "Intentar nuevamente"
                });
            }
        });
    }

    function nuevo() {
        document.getElementById('data').style.display = "none";
        // document.getElementById('dataNuevo').style.display = "block";
        $('#accion').val('crear');
    }


    function subirImagen(input) {
        const formData = new FormData(); //se prepara para agregar datos 
        formData.append('imagen', input.files[0]); // agrega 'imagen' al formdata 
        $.ajax({
            url: './action/subirImagen.php',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#vistaPrevia').attr('src', '../../assets/image/' + response.nombre).show();
                    swal("Imagen subida con exito");
                    setTimeout(function() {
                    window.location.href = 'abmUsuarios.php';
                }, 3000)
                }
            },
            error: function(request, status, error) {
                swal("La imagen no se pudo subir");
            }
        });
    }
</script>
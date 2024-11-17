<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    redirect('../login/login.php');
}

$datos = darDatosSubmitted();
$id =  $session->getUsuario()->getIdUsuario();

?>
<section class="home-section">
    <div id="container" style="margin:50px 75px;height: 87vh;">
        <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
            <div class="mb-3 row">
                <h4>Mi Cuenta</h4>
                <form id="selectForm">
                    <div class=" mb-3 row">
                        <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" id="usuario" name="usuario"
                                value=<?php echo $session->getUsuario()->getUsNombre() ?>>
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email"
                                value=<?php echo $session->getUsuario()->getUsMail() ?>>
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="psw" class="col-sm-2 col-form-label">Nueva Contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="psw">
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="psw" class="col-sm-2 col-form-label">Repetir Nueva Contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="psw">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="guardar()"
                        style="margin-top: 20px;margin-left: 220px;">Guardar Cambios</button>

                </form>
            </div>
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

</html>
<script>
    function agregar() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const product = urlParams.get('idproducto');

        var obj = {
            id: product
        };
        $.ajax({
            url: './productoAction.php',
            type: 'post',
            dataType: 'json',
            data: {
                json: JSON.stringify(obj)
            },
            success: function(data) {

                if (data['estado']) {
                    var diiv = document.getElementById("mensajeapp");
                    document.getElementById("mensajestr").innerHTML = "El producto fue agregado al carrito";
                    diiv.style.opacity = '100';

                    setTimeout(function() {
                        var AmountOfActions = 100;
                        diiv.style.opacity = '100';
                        var counte = 100;
                        setInterval(function() {
                                counte--;
                                if (counte > 0) {
                                    diiv.style.opacity = counte / AmountOfActions;
                                }
                            },
                            10);
                    }, 3000);
                } else {
                    window.location.href = "../login/login.php";
                }

            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>
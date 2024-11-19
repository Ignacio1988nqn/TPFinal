<?php
include_once "../../configuracion.php";

$session = new Session(); 
$roles = $session->getRol(); 
if (!$roles || count($roles) == 0) {
    echo "No se han encontrado roles para este usuario.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="d-flex justify-content-center align-items-center mt-4">
    <div class="container">
        <div class="row justify-content-center">
            <h4 >Tiene mas de un rol, escoga con cual ingresar</h4>
            <br> 
            <br>
            <br>
            <br>
            <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">
                
                <form method="POST" action="./procesarRol.php">
                    <div class="form-group mb-3">
                        <label for="rol">Seleccione el rol:</label>
                        <br>
                        <select class="form-control" id="rol" name="rol">
                            <option value="" >Seleccione...</option>
                            <?php
                            foreach ($roles as $rol){ ?>
                                <option value="<?php echo $rol->getIdRol(); ?>"><?php echo $rol->getRoDescripcion(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>

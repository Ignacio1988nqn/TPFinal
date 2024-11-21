<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");

$abmProducto = new AbmProducto();
$param['tipo'] = 1;
$hogar = $abmProducto->buscar($param);

?>
<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 200px;">
            <img src="../assets/image/hogarbanner.jpg" class="d-block w-100" alt="...">
            <h4 style="padding: 50px 0 20px;">Los mejores precios para el hogar </h4>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <?php
                    foreach ($hogar as $item) {
                        if ($item->getProCantStock()) {
                            echo "<div class='col'> <img src='../assets/image/" . $item->getIdProducto() . ".jpg' class='d-block w-100' alt='...'
                         onclick='verProducto(" . $item->getIdProducto() . ")' style='cursor: pointer;'>";
                            echo "<p>" . $item->getProNombre() . "</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

</html>
<script>
    function verProducto(id) {
        window.location.href = "./producto.php?idproducto=" + id;
    }
</script>
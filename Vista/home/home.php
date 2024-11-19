<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");

$abmProducto = new AbmProducto();
$param['tipo'] = 1;
$hogar = $abmProducto->buscar($param);
$param['tipo'] = 2;
$celulares = $abmProducto->buscar($param);
$param['tipo'] = 3;
$pc = $abmProducto->buscar($param);

?>
<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 200px;">

            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../assets/image/pcbanner.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/image/hogarbanner.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/image/celbanner.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <hr>
            <h2 class="dynamic__carousel-title">Los mejores precios para el hogar </h2>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <?php
                    if ($hogar) {
                        for ($x = 0; $x < (count($hogar) < 4 ? count($hogar) : 4); $x++) {

                            echo "<div class='col'> <img src='../assets/image/" . $hogar[$x]->getIdProducto() . ".jpg' class='d-block w-100' alt='...'
                            onclick='verProducto(" . $hogar[$x]->getIdProducto() . ")' style='cursor: pointer;'>";
                            echo "<p>" . $hogar[$x]->getProNombre() . "</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <hr>
            <h2 class="dynamic__carousel-title">Las mejores ofertas en celulares </h2>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <?php
                    if ($celulares) {
                        for ($x = 0; $x < (count($celulares) < 4 ? count($celulares) : 4); $x++) {
                            echo "<div class='col'> <img src='../assets/image/" . $celulares[$x]->getIdProducto() . ".jpg' class='d-block w-100' alt='...'
                         onclick='verProducto(" . $celulares[$x]->getIdProducto() . ")' style='cursor: pointer;'>";
                            echo "<p>" . $celulares[$x]->getProNombre() . "</p>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <hr>
            <h2 class="dynamic__carousel-title">Arma tu PC con los mejores precios</h2>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <?php
                    if ($pc) {
                        for ($x = 0; $x < (count($pc) < 4 ? count($pc) : 4); $x++) {
                            echo "<div class='col'> <img src='../assets/image/" . $pc[$x]->getIdProducto() . ".jpg' class='d-block w-100' alt='...'
                         onclick='verProducto(" . $pc[$x]->getIdProducto() . ")' style='cursor: pointer;'>";
                            echo "<p>" . $pc[$x]->getProNombre() . $pc[$x]->getIdProducto() . "</p>";
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
    var myCarousel = document.querySelector('#myCarousel')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 2000,
        wrap: false
    })

    function verProducto(id) {
        window.location.href = "./producto.php?idproducto=" + id;
    }
</script>
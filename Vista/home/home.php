<?php
// require "../configuracion.php";
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
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
                    <div class="col"> <img src="../assets/image/h1.jpg" class="d-block w-100" alt="...">
                        <p>HELADERA DREAN 364 LTRS BLANCA</p>
                    </div>
                    <div class="col"><img src="../assets/image/h2.jpg" class="d-block w-100" alt="...">
                        <p>Heladera Cíclica Drean 277Lts</p>
                    </div>
                    <div class="col"><img src="../assets/image/t1.jpg" class="d-block w-100" alt="...">
                        <p>Televisor Samsung Smart Tv 32 HD Smart TV T4300</p>
                    </div>
                    <div class="col"><img src="../assets/image/l1.jpg" class="d-block w-100" alt="...">
                        <p>Lavarropas Carga Frontal 6Kg 800 RPM Drean Next 6.08 ECO</p>
                    </div>
                </div>
            </div>
            <hr>
            <h2 class="dynamic__carousel-title">Las mejores ofertas en celulares </h2>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <div class="col"> <img src="../assets/image/cel5.jfif" class="d-block w-100" alt="...">
                        <p>Celular Samsung Galaxy A15 128/4GB Amarillo</p>
                    </div>
                    <div class="col"><img src="../assets/image/cel2.jfif" class="d-block w-100" alt="...">
                        <p>Celular Motorola G24 128GB Pink Lavender</p>
                    </div>
                    <div class="col"><img src="../assets/image/cel6.jfif" class="d-block w-100" alt="...">
                        <p>Celular Motorola Moto G14 Rosa 4+128Gb</p>
                    </div>
                    <div class="col"><img src="../assets/image/cel4.jfif" class="d-block w-100" alt="...">
                        <p>Celular Motorola E22 6,5" 64GB Azul</p>
                    </div>
                </div>
            </div>
            <hr>
            <h2 class="dynamic__carousel-title">Arma tu PC con los mejores precios</h2>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <div class="col"> <img src="../assets/image/placa1.jfif" class="d-block w-100" alt="...">
                        <p>HELADERA DREAN 364 LTRS BLANCA</p>
                    </div>
                    <div class="col"><img src="../assets/image/monitor1.jfif" class="d-block w-100" alt="...">
                        <p>Heladera Cíclica Drean 277Lts</p>
                    </div>
                    <div class="col"><img src="../assets/image/placa2.jfif" class="d-block w-100" alt="...">
                        <p>Televisor Samsung Smart Tv 32 HD Smart TV T4300</p>
                    </div>
                    <div class="col"><img src="../assets/image/gabinete1.jfif" class="d-block w-100" alt="...">
                        <p>Lavarropas Carga Frontal 6Kg 800 RPM Drean Next 6.08 ECO</p>
                    </div>
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
</script>
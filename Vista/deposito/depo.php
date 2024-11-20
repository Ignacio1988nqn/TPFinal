<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");
if (!$session->validar()) {
    header('Location: ../login/login.php');
}

?>

<section class="home-section">
    <div class="right-container">
        <div id="container" style="margin:50px 200px;height: 87vh;">
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>
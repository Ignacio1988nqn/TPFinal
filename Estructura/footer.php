<?php
require "../../configuracion.php";

$session = new Session();
$val = 0;
if ($session->validar()) {
    foreach ($session->getRol() as $rol) {
        $val = $rol->getIdRol();
    }
}

echo "</div>";
if ($val != 2) {
    include_once("../../estructura/footerPublic.php");
}
?>

<script src="../assets/js/script.js"></script>

</body>

</html>
<script>
    $(document).ajaxStart(function() {
        document.getElementById("spinner").style.display="block";
    });
    $(document).ajaxStop(function() {
        document.getElementById("spinner").style.display="none";
    });
</script>
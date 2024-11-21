document.addEventListener("DOMContentLoaded", () => {
  const formLogin = document.getElementById("form-login");

  formLogin.addEventListener("submit", function (e) {
    e.preventDefault();

    const nombreUsuario = document.getElementById("usnombre").value;
    const password = document.getElementById("uspass").value;

    let valid = true;

    // reseteo de clases
    $("#usnombre, #uspass").removeClass("is-invalid is-valid");

    // usuario
    if (!nombreUsuario.trim()) {
      $("#usnombre").addClass("is-invalid");
      $("#usnombre").siblings(".invalid-feedback").show();
      valid = false;
    } else {
      $("#usnombre").addClass("is-valid");
    }

    // contraseña
    if (!password.trim()) {
      $("#uspass").addClass("is-invalid");
      $("#uspass").siblings(".invalid-feedback").show();
      valid = false;
    } else {
      $("#uspass").addClass("is-valid");
    }

    if (!valid) {
      return;
    }

    // hash de la contraseña con md5
    const nuevaPassHash = CryptoJS.MD5(password).toString();

    // datos a enviar
    const loginData = {
      usnombre: nombreUsuario,
      uspass: nuevaPassHash,
    };

    $.ajax({
      type: "POST",
      url: "../accion/verificarLogin.php",
      data: JSON.stringify(loginData),
      contentType: "application/json",
      success: function (response) {
        const res = JSON.parse(response);

        if (res.success) {
          Swal.fire({
            title: "Inicio de sesion exitoso.",
            text: response.message,
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          }).then(() => {
            if (res.redirect) {
              window.location.href = res.redirect;
            }
          });
        } else {
          $("#mensajeError").html(`
                <div class="alert alert-danger" role="alert">${res.message}</div>
            `);
        }
      },
      error: function () {
        $("#mensajeError").html(`
            <div class="alert alert-danger" role="alert">
              Ocurrió un error. Intente nuevamente.
            </div>
          `);
      },
    });
  });
});

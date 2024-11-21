$(document).ready(function () {
  $("#form-registro").on("submit", function (event) {
    event.preventDefault();

    // borrar mensajes de error previos
    $(".invalid-feedback").hide();
    $(".is-invalid").removeClass("is-invalid");
    $(".is-valid").removeClass("is-valid");

    // validacion manual
    const nombreUsuario = $("#usnombre").val();
    const password = $("#uspass").val();
    const email = $("#usmail").val();
    const codigo = $("#codigo").val();
    let valid = true;

    // expresiones regulares
    const regexLetrasNumeros = /^[a-zA-Z0-9]+$/; // Solo letras y números
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Formato básico de email

    // nombre de usuario
    if (
      !nombreUsuario.trim() ||
      !regexLetrasNumeros.test(nombreUsuario) ||
      nombreUsuario.length < 5
    ) {
      $("#usnombre").addClass("is-invalid");
      $("#usnombre")
        .siblings(".invalid-feedback")
        .text(
          "El nombre de usuario debe tener al menos 5 caracteres y solo puede contener letras y números."
        )
        .show();
      valid = false;
    } else {
      $("#usnombre").addClass("is-valid");
    }

    // contraseña
    if (
      !password.trim() ||
      password.length < 8 ||
      !regexLetrasNumeros.test(password)
    ) {
      $("#uspass").addClass("is-invalid");
      $("#uspass")
        .siblings(".invalid-feedback")
        .text(
          "La contraseña debe tener al menos 8 caracteres y contener solo letras y números."
        )
        .show();
      valid = false;
    } else {
      $("#uspass").addClass("is-valid");
    }

    // email
    if (!email.trim() || !regexEmail.test(email)) {
      $("#usmail").addClass("is-invalid");
      $("#usmail")
        .siblings(".invalid-feedback")
        .text("Por favor, ingrese un correo electrónico válido.")
        .show();
      valid = false;
    } else {
      $("#usmail").addClass("is-valid");
    }

    // codigo de verificación
    if (!codigo.trim()) {
      $("#codigo").addClass("is-invalid");
      $("#error-codigo")
        .text("El código de verificación no puede estar vacío.")
        .show();
      valid = false;
    } else {
      $("#codigo").addClass("is-valid");
    }

    if (!valid) {
      return;
    }

    // hashear la contraseña
    const passhash = CryptoJS.MD5(password).toString();
    $("#uspass").val(passhash);

    // enviar el formulario con AJAX
    $.ajax({
      type: "POST",
      url: "../accion/verificarRegistro.php",
      dataType: "json",
      data: $("#form-registro").serialize(),
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: "Registro exitoso",
            text: response.mensaje,
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = response.redirect;
        });
        } else {
          $("#mensajeError").html(`
                  <div class="alert alert-danger" role="alert">${response.mensaje}</div>
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

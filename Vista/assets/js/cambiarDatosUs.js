function guardarCambios() {
    // resetear campos
    $(".invalid-feedback").hide();
    $(".is-invalid").removeClass("is-invalid");
  
    const email = $("#email").val().trim();
    const nuevaPsw = $("#nuevaPsw").val().trim();
    const repetirPsw = $("#repetirPsw").val().trim();
    let valid = true;
  
    const regexLetrasNumeros = /^[a-zA-Z0-9]+$/; // Solo letras y números
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Formato básico de email
  
    // email
    if (!email || !regexEmail.test(email)) {
      $("#email").addClass("is-invalid").siblings(".invalid-feedback").show();
      valid = false;
    }
  
    // nueva contraseña
    if (!nuevaPsw || nuevaPsw.length < 8 || !regexLetrasNumeros.test(nuevaPsw)) {
      $("#nuevaPsw").addClass("is-invalid").siblings(".invalid-feedback").show();
      valid = false;
    }
  
    // coincidencia de contraseñas
    if (!repetirPsw || nuevaPsw !== repetirPsw) {
      $("#repetirPsw")
        .addClass("is-invalid")
        .siblings(".invalid-feedback")
        .show();
      valid = false;
    }
  
    if (!valid) {
      return;
    }
  
    // se hashea la contraseña antes de enviar al servidor
    const nuevaPasshash = CryptoJS.MD5(nuevaPsw).toString();
  
    // enviar los datos con AJAX
    const data = {
      email: email,
      password: nuevaPasshash,
      repetirPassword: CryptoJS.MD5(repetirPsw).toString(), // solo para verificar en el servidor
    };
  
    $.ajax({
      type: "POST",
      url: "../accion/accionMiCuenta.php",
      data: JSON.stringify(data),
      contentType: "application/json",
      success: function (response) {
        console.log(response); // debug
        if (response && response.success) {
          Swal.fire({
            title: "Cambio exitoso",
            text: response.message,
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
        } else {
          alert("Error: " + (response.message || "Ocurrió un problema."));
        }
      },
      error: function (error) {
        console.error(error); // debug
        alert("Error en la solicitud. Por favor, intenta nuevamente.");
      },
    });
  }
  
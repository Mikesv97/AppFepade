(function ($) {
  "use strict"

  var form = $("#step-form-horizontal");
  form.children('div').steps({
    headerTag: "h4",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true,
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex) {
      //plugings valited, que solamente comprueba que sean digitos en el input codProyectos para poder pasar a la siguiente pagina del formulario
      $("#step-form-horizontal").validate({
        rules: {
          codProyectos: {
            digits: true
          }
        }
      });

      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      var formData = new FormData($('#step-form-horizontal')[0]);
      formData.append("key", "imagen");
      formData.append("tipoActivo", $('#tipoactivo').val());
      $.ajax({
        type: 'POST',
        url: "../Controladores/activoFijoControlador.php",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (r) {
          console.log(r);
          switch (r) {
            case true:
              Swal.fire({
                title: 'Ingresar activo al sistema',
                text: "Porfavor confirma para ingresar el activo al sistema",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ingresasr'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    'Activo ingresado!',
                    'El activo a sido ingresado al sistema',
                    'success'
                  ).then(function () {
                    $(location).attr('href', "../vistas/activo_fijo.php");
                  })
                }
              })
              break;
          }
        },
        error: function (data) {
          console.log(data);
        }
      });
    },
  });

})(jQuery);
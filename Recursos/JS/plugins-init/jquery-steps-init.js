(function($) {
    "use strict"

    var form = $("#step-form-horizontal");
    form.children('div').steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true, 
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            //plugings valited, que solamente comprueba que sean digitos en el input codProyectos para poder pasar a la siguiente pagina del formulario
            $( "#step-form-horizontal" ).validate({
                rules: {
                    codProyectos: {
                    digits: true
                  }
                }
              });

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinished: function(event, currentIndex)
        {
            var data = $(form).serialize();
            var tipoactivo = $('#tipoactivo').val();
            $.ajax({
                url: '../Controladores/activoFijoControlador.php',
                method: "post",
                dataType: "json",
                data: { "key": "insertar", "data": data, "tipoActivo": tipoactivo },
                success: function (r) {
                    console.log(r);
                    if(r){
                        
                        // $(location).attr('href',"../vistas/activo_fijo.php");
                    }
                },
                error: function (r) {
                    console.log(r);
                }
            });
        }
    });

})(jQuery);
$(document).ready(function () {
    mensajeLoad();
    $("#labelError").hide();
    $("#labelError2").hide();
    
    //cuando hace click en el botón para cambiar usuario
    $("#cambiarUsuario").on("click",function(e){
      e.preventDefault();
      var dato = $("#usuarioId").val();
        $.ajax({
          url: "../Controladores/loginControlador.php",
          method: "post",
          dataType: "json",
          data: { "key": "cerrarSesion", "nombre": dato},
          success: function (r) {
              if(r){
                  $(location).attr('href',"../index.php");
              }
          },
          error: function (r) {
            console.log(r);
          }
        });
    });

    //cuando se envía el formulario para cambio de contraseña en primer login
    $("#frmPrimerLogin").submit(function(e){
      e.preventDefault();
      var pass1= $("#passNew1").val();
      var pass2= $("#passNew2").val();
      var passOld =  $("#passOld").val();
      var user =$("#usuarioId").val();

      if(pass1 != pass2){
        $("#labelError2").show();
        $("#labelError2").text("Las contraseñas no coinciden.");
        $("#passNew1").focus();

      }else if(pass1 == passOld || pass2 == passOld){

        $("#labelError2").show();
        $("#labelError2").text("Debes ingresar una contraseña diferente a la actual.");
        $("#passNew1").val("");
        $("#passNew2").val("");
        $("#passNew1").focus();

      }else{

        $.ajax({
          url: "../Controladores/loginControlador.php",
          method: "post",
          data: { "key": "primerCambioPass","usuario":user, "contraseña": pass2},
          success: function (r) {
            var resp = r;
            console.log(resp);
            switch(resp){
              case "FailChangFirtPass":
                Swal.fire({
                  title: '!Woops!',
                  text: 'No pudimos conectarnos al servidor, por favor intenta de nuevo, si el problema persiste'
                  +'informa a tu administrador o personal de IT.\n'
                  +'Proceso: primerCambioContraseña',
                  icon: 'error',
                  confirmButtonText: 'Aceptar'
                })
                break;
                case "1":
                  Swal.fire({
                    title: '!Contraseña cambiada!',
                    text: 'Tu contraseña se cambió con éxito, ahora ya puedes ingresar con tus datos al sistema'
                    +' gracias por preocuparte por la seguridad de tu información.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                  }).then((result) => {
                      $(location).attr('href',"../index.php?s=true");
                    })
                break;
            }

          },
          error: function (r) {
            console.log(r.responseText);
            Swal.fire({
              title: '!Woops!',
              text: 'No pudimos conectarnos al servidor, por favor intenta de nuevo, si el problema persiste'
              +'informa a tu administrador o personal de IT.\n'
              +'Proceso: ValidarPassActual',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            })
          }
        });
      }
    });


    //cuando se cambia el input, se valida que la contraseña sea la actual del usuario
    $("#passOld").change(function(){
      var user = $("#usuarioId").val();
      var passOld = $("#passOld").val();
        $.ajax({
          url: "../Controladores/loginControlador.php",
          method: "post",
          data: { "key": "validarPassOld","usuario":user, "passOld": passOld},
          success: function (r) {
            var resp = r;
            switch(resp){
              case "invalidPassOld":
                $("#labelError").show();
                $("#labelError").text("Contraseña incorrecta, ingresa tu contraseña actual.");
                $("#passOld").focus();
                break;
                default:
                  $("#labelError").hide();
                  $("#labelError").text("");
                  $("#passOld").blur();
                break;
            }

          },
          error: function (r) {
            //console.log(r.responseText);
            Swal.fire({
              title: '!Woops!',
              text: 'No pudimos conectarnos al servidor, por favor intenta de nuevo, si el problema persiste'
              +'informa a tu administrador o personal de IT.\n'
              +'Proceso: ValidarPassActual',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            })
          }
        });
    });

});

//muestra el mensaje cada que se carga la página.
function mensajeLoad(){
    Swal.fire({
        title: 'Primer inicio de sesión',
        text: "¡Hola!, este es tu primer inicio de sesión, por seguridad debes cambiar tu contraseña actual "
        +'de lo contrario no podrás entrar al sistema hasta que hagas el cambio. Si crees que se trata '
        +'de algún problema contacta a tu administrador o personal de TI.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Comprendo!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            '¡Gracias por comprender!',
            'Completa la información solicitada a continuación.',
            'success'
          )
        }else{
            $(location).attr('href',"../index.php");
        }
      });
 } 
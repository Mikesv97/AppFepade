$(document).ready(function () {
    mensajeLoad();

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

    $("#passOld").change(function(){
      var user = $("#usuarioId").val();
      var passOld = $("#passOld").val();
        $.ajax({
          url: "../Controladores/loginControlador.php",
          method: "post",
          dataType: "json",
          data: { "key": "validarPassOld","usuario":user, "passOld": passOld},
          success: function (r) {
            console.log(r);
          },
          error: function (r) {
            console.log(r);
          }
        });
    });

});

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
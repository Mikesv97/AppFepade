$(document).ready(function () {
      mensajeLoad();
  

    $("#cambiarUsuario").on("click",function(e){
      e.preventDefault();
      $(location).attr('href',"../index.php?s=true");
    });

});

function mensajeLoad(){
    Swal.fire({
        title: 'Primer inicio de sesión',
        text: "¡Hola!, este es tu primer inicio de sesión, por seguridad debes cambiar tu contraseña actual "
        +'de lo contrario no podrás iniciar sesión hasta que hagas el cambio. Si crees que se trata '
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
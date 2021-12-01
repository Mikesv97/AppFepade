$(document).ready(function(){
    $("#codeContent").hide();
    $("#labelError").hide();

    //cuando hace click en btnLogin 
    $("#btnLogin").on("click", function(e){
        //se evita el envio del form
        e.preventDefault();
        //obtenemos los datos del form
        var data = $("#frmLogin").serialize();
        //se envia la información mediante ajax
        $.ajax({
            url: "Controladores/usuarioControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "validarUser","data": data },
            success: function (r) {
                //en caso de comunicación exitosa, comprobamos valor booleano de respuesta
                //que viene del servidor
                if(r){
                    //si todo esta correcto, redireccionamos al inicio
                    $(location).attr('href',"vistas/home.php");
                }else{
                    //caso contrario mandamos un mensaje de error
                    $("#btnLogin").blur();
                    $("#labelError").show();
                    $("#labelError").text("Datos Incorrectos, Intenta De Nuevo");

                    //limpiamos campos
                    $('input[name="txtUsuario"]').val("");
                    $('input[name="txtContraseña"]').val("");

                    //hacemos focus y al digitar en el usuario ocultamos error
                    $('input[name="txtUsuario"]').focus();
                    $('input[name="txtUsuario"]').keypress(function(){
                        $("#labelError").hide();
                    });
                }
            },
            error: function (r) {
               console.log(r);
            }
        });
    });


});

/*
$.ajax({
                    url: ,
                    method: "post",
                    dataType: "json",
                    data: { "cod": cod },
                    success: function (r) {
                        
                    },
                    error: function () {
                       
                    }
                });


*/
$(document).ready(function(){
    var rem= 0;
    $("#codeContent").hide();
    $("#labelError").hide();

    comprobarCokieRememberme();
    $('#customCheck').change(function(){
        if(!$('#customCheck').is(":checked")){
            $('#customCheck').attr("checked",false);
            rem=0;
        }

    });
    //cuando hace click en btnLogin 
    $("#btnLogin").on("click", function(e){
        //se evita el evento envio del form
        e.preventDefault();

        //obtenemos los datos del form
        var data = $("#frmLogin").serialize();
        
        //obtenemos el valor del ckeckbox recordarme
        
        if ($('#customCheck').is(":checked"))
        {
            rem= 1;
        }

        //se envia la información mediante ajax
        $.ajax({
            url: "Controladores/usuarioControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "validarUser","data": data,"valor": rem },
            success: function (r) {
                console.log(r);
                //en caso de comunicación exitosa, comprobamos valor booleano de respuesta
                //que viene del servidor
         /*      if(r){
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
                }*/
            },
            error: function (r) {
                //si falla algo se muestra error de conexión en el servidor
               console.log(r);

            }
            
        });
    });

    /*Esta funcion se ejecuta cada que carga el login, manda solicitud al servidor mediante ajax
    para pedir ver si hay cookies que se generan cuando el usuario se loguea con recuerdame,
    si hay cookies correctas devuelve un arreglo con datos para cargar controles, si no hay cookies,
    o si no son validos los datos de la cookie retorna falso*/
    function comprobarCokieRememberme(){
        $.ajax({
            url:"Controladores/usuarioControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "validarRemember"},
            success: function (r) {
                        //si hay cookies, y si son correctos los datos
                        if(r){
                           //seteamos controles
                           $("input[name='txtUsuario']").val(r["nombre"]);
                           $("input[name='txtContraseña']").val(r["token"]);
                           $('#customCheck').attr("checked",true);
                                                    
                        }else{
                            $('#customCheck').attr("checked",false);
                        }

            },
            error: function () {
                console.log("No se pudo conectar al servidor");
               
            }
        });
    }
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
$(document).ready(function(){
    var rem;
    var uschange;
    
    //ocultamos label del error, y el input de codigo de
    //cambio de contraseña
    $("#codeContent").hide();
    $("#labelError").hide();
    $("#labelErrorEmail").hide();

    comprobarCokieRememberme();
    
    //cuando se clickea en el check box variamos valor
    //para manejar desde el servidor si esta seleccionado o no
    $('#customCheck').on("click",function(){
        if(rem==1){
            rem =0;
        }else{
            rem=1;
        }
    });

    //cuando escribe otro usuario diferente al que esta cargado por el
    //recuerdame
    $("input[name='txtUsuario']").keypress(function(){
        //si es 1 esta seleccionado recuerdame
        if(rem ==1){
            //lo pasamos a 0 para que no este seleccionado
            rem=0;
        }
        //activamos que hubo cambio de usuario
        uschange=true;
        //limpiamos controles
        $("input[name='txtContraseña']").val("");
        $('#customCheck').attr("checked",false);
    });

    //cuando hace click en btnLogin 
    $("#btnLogin").on("click", function(e){
        //se evita el evento envio del form
        e.preventDefault();

        //obtenemos los datos del form
        var data = $("#frmLogin").serialize();
        var us = null;
        //evaluamos si se cambio el usuario que estaba seteado
        if(uschange){
            us="conCambio";
        }else{
            us="sinCambio";
        }
        //se envia la información mediante ajax
        $.ajax({
            url: "Controladores/usuarioControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "validarUser","data": data,"valor": rem,"userChange": us},
            success: function (r) {
                switch(r){
                    case "datosLogNull":
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
                    break;
                    case "falloToken":
                        alert("hubo un problema al comunicarse con el servidor, intenta de nuevo");
                    break;
                    case true:
                        $(location).attr('href',"vistas/activo_fijo.php");
                    break;
                }
            },
            error: function () {
                //si falla algo se muestra error de conexión en el servidor
               console.log("Hubo problemas al intentar comunicarse con el servidor, intenta de nuevo");

            }
            
        });
    });

    $("#btnCodigo").on("click",function(e){
        var correo = $("#txtCorreo").val();
        if(correo != ""){
            e.preventDefault();
            $.ajax({
                url: "Controladores/usuarioControlador.php" ,
                method: "post",
                dataType: "json",
                data: { "key": "validarCorreo","correo": correo },
                success: function (r) {
                    console.log(r)
                    switch(r){
                        case "invalidMail":
                            //si el correo es invalido mostramos error
                            $("#labelErrorEmail").text("Correo No Encontrado, Intenta De Nuevo");
                            $("#labelErrorEmail").show();
                            //hacemos focus en el inut y lo limpiamos
                            $("#txtCorreo").focus();
                            $("#txtCorreo").val("");
                            //al digitar que se oculte el error
                            $("#txtCorreo").keypress(function(){
                                $("#labelErrorEmail").text("");
                                $("#labelErrorEmail").hide();
                            });
                        break;
                        case true:
                            //si el correo existe ocultamos el error del correo invalido si estuviera mostrado
                            $("#labelErrorEmail").hide();
                            //desabilitamos el input con el correo
                            $("#txtCorreo").attr("disabled",true);
                            //mostramo mensaje que el codigo fue enviado
                            $("#labelInfoEmail").attr("class","text-muted");
                            $("#labelInfoEmail").text("Enviamos un código a tu correo, por favor verifica e ingresalo");
                            //mostramos el campo para el codigo
                            $("#codeContent").show();
                        break;
                    }
                },
                error: function (r) {
                    console.log(r);
                }
            });
        }
    });

    /*funcion que solicita comprobacion  de datos de las cookies para ver si son validos y cargar los 
    controles*/
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
                    rem=1;
                    uschange=false;
                    $('#customCheck').attr("checked",true);
                }else{
                    rem=0;
                    $('#customCheck').attr("checked",false);
                }
             },
            error: function (r) {
                console.log("No se pudo conectar al servidor");
                console.log(r);

               
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
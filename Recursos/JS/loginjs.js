$(document).ready(function(){
    var rem;
    var uschange;
    var codigo;
    var error =parseInt(0);;
    
    //ocultamos controles que no deben ser visibles al cargar pag
    $("#codeContent").hide();
    $("#labelError").hide();
    $("#labelErrorEmail").hide();
    $("#newPasContent").hide();
    $("#lbFailNewPass").hide();


    comprobarCokieRememberme();
    $("#txtNewPas1").keypress(function(){
        $("#lbFailNewPass").val("");
        $("#lbFailNewPass").hide();
    });

    $("#txtNewPas2").keypress(function(){
        $("#lbFailNewPass").val("");
        $("#lbFailNewPass").hide();
    });


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
                        Swal.fire({
                            title: 'WOOPS!',
                            text: 'Hubo un problema al comunicarse con el servidor, intenta de nuevo, ErrorCod: 0-ToKnSET',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                          })
                        
                    break;
                    case true:
                        $(location).attr('href',"vistas/activo_fijo.php");
                    break;
                }
            },
            error: function () {
                //si falla algo se muestra error de conexión en el servidor
                Swal.fire({
                    title: 'WOOPS!',
                    text: 'Hubo problemas al intentar comunicarse con el servidor, intenta de nuevo',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                  })
            }
            
        });
    });

    //cuando hace click en solicitar código
    $("#btnCodigo").on("click",function(e){
        var correo = $("#txtCorreo").val();
        if(correo != ""){
            e.preventDefault();
            $.ajax({
                url: "Controladores/usuarioControlador.php" ,
                method: "post",
                dataType: "json",
                data: { "key": "validarCorreo","correo": correo},
                success: function (r) {

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
                            //enviamos cod al correo
                            enviarCodigo();   
                            //si el correo existe ocultamos el error del correo invalido si estuviera mostrado
                            $("#labelErrorEmail").hide();
                            //desabilitamos el input con el correo
                            $("#txtCorreo").attr("disabled",true);
                            $("#btnCodigo").attr("disabled",true);
                            //mostramo mensaje que el codigo fue enviado
                            $("#labelInfoEmail").attr("class","text-muted");
                            $("#labelInfoEmail").text("Enviamos un código a tu correo, por favor verifica e ingresalo");
                            Swal.fire({
                                title: 'CÓDIGO ENVIADO!',
                                text: 'Se envio correctamente el código de validación al correo proporcionado',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                              })
                            //mostramos el campo para el codigo
                            $("#codeContent").show();
                        break;
                        case "failSendMail":
                            alert("Vaya! Parece que tenemos dificultades tecnicas para enviar el correo, intenta más tarde")
                        break;
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Woops!',
                        text: 'Tenemos problema al enviar el código a tu correo, intenta de nuevo, si el problema persiste'
                        +'informa a tu administrador o personal de IT',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                      })
                }
            });
        }
    });

    //cuando hace click en validar código
    $("#btnValidCodigo").on("click",function(){
    
        var codIng= $("#txtCodCorreo").val();
        if(codigo == codIng){
            $("#btnValidCodigo").attr("disabled",true);
            $("#txtCodCorreo").attr("disabled",true);
            $("#lbCoderror").val("");
            $("#lbCoderror").hide();
            $("#newPasContent").show();
        }else{
            $("#lbCoderror").text("El código ingresado es incorrecto");
            $("#lbCoderror").show();
            error += parseInt(1);
            if(error==3){
                error = parseInt(0);
                Swal.fire({
                    title: 'Código Invalido!',
                    text: 'Has ingresado un código incorrecto varias veces, por seguridad solicita uno nuevo',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                  })
                  codigo=0;
                  ocultarCamposModal();
                 
            }

            $("#txtCodCorreo").keypress(function(){
   
                    $("#lbCoderror").text("");
                    $("#lbCoderror").hide();
        
            });
       }
    });

    //cuando hace click en btn cambiar contraseña
    $("#btnChangPass").on("click",function(e){
        $("#lbFailNewPass").hide();
        var pass1 = $("#txtNewPas1").val();
        var pass2 =  $("#txtNewPas2").val();
        var mail = $("#txtCorreo").val();
        if(pass1=="" || pass2==""){
            $("#lbFailNewPass").text("No puedes dejar ninguno de los campos vacios");
            $("#lbFailNewPass").show();
            $("#txtNewPas1").focus();
        }else{
            if(pass1 != pass2){
                $("#lbFailNewPass").text("Las contraseñas no coinciden");
                $("#lbFailNewPass").show();
            }else{
                $.ajax({
                    url: "Controladores/usuarioControlador.php",
                    method: "post",
                    dataType: "json",
                    data: { "key": "cambiarPass","pass": pass1,"correo": mail },
                    success: function (r) {
                        Swal.fire({
                            title: 'CONTRASEÑA CAMBIADA!',
                            text: 'Se ha cambiado correctamente tu contraseña!',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                          })

                          ocultarCamposModal();
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Woops!',
                            text: 'No pudimos actualizar la contraseña, por favor intenta de nuevo, si el problema persiste'
                            +'informa a tu administrador o personal de IT',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                          })
                    }
                });
            }
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
        error: function () {
            Swal.fire({
                title: 'Woops!',
                text: 'No pudimos conectarnos al servidor, por favor intenta de nuevo, si el problema persiste'
                +'informa a tu administrador o personal de IT',
                icon: 'error',
                confirmButtonText: 'Aceptar'
              })
        }
    });
    }

    function enviarCodigo(){
        var correo = $("#txtCorreo").val();
        $.ajax({
            url: "Controladores/usuarioControlador.php",
            method: "post",
            //dataType: "json",
            data: { "key":"enviarCodigo","correo": correo},
            success: function (r) {
                   codigo = r;
            
            },
            error: function (r) {
                Swal.fire({
                    title: 'Woops!',
                    text: 'Parece tenemos problemas técnicos para enviar el correo, por favor intenta de nuevo, si el problema persiste'
                    +'informa a tu administrador o personal de IT',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                  })
            }
        });
    }

    function ocultarCamposModal(){
                                //ocultamos errores y campo codigo
                                $("#codeContent").hide();
                                $("#labelError").hide();
                                $("#labelErrorEmail").hide();
                                $("#lbCoderror").hide();
        
                                //limpiamos inputs y errores
                                $("#lbCoderror").val("");
                                $("#txtCodCorreo").val("");
                                $("#txtCorreo").val("");
        
                                //habilitamos el input con el correo
                                $("#txtCorreo").attr("disabled",false);
                                $("#btnCodigo").attr("disabled",false);
                                
                                //cerramos modal
                                $("#staticBackdrop").modal("hide");
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
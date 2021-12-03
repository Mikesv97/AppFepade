$(document).ready(function(){
    var rem;
    var uschange;

    $("#codeContent").hide();
    $("#labelError").hide();

    comprobarCokieRememberme();

    $('#customCheck').on("click",function(){
        if(rem==1){
            rem =0;
        }else{
            rem=1;
        }
    });

    $("input[name='txtUsuario']").keypress(function(){

        if(rem ==1){

            rem=0;
        }

        uschange=true;
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
                console.log("cookies existen: "+r);
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
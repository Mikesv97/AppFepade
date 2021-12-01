$(document).ready(function(){
    $("#codeContent").hide();

    //AL HACER CLICK EN GENERAR CODIGO, SE ENVIA CODIGO AL CORREO Y SE DESPLIEGA EL CAMPO PARA INGRESARLO
    $("#frmRecPass").on("submit",function(e){
        e.preventDefault();
        var correo = $("#txtCorreo").val();


    });


});


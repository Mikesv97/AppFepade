$(document).ready(function(){
    //cuando carga la pag solicitamos menú según Rol del usuario
    solicitarMenuRol(idRol);
    //cuando hace click en cerrar sesión
    $("#cerrarLog").on("click",function(e){
        var dato = $("#nombreUser").text();
        e.preventDefault();
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
            error: function () {
               console.log("Hubo Un Error Al Intentar Comunicarse Al Servidor, Intenta De Nuevo");
            }
        });
    });

    function solicitarMenuRol(idRol){
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "solicitarMenu","idRol": idRol},
            success: function (r) {
                for(let i=0; i<r.length; i++){
                    console.log(r[i]["nombre_menu"]);
                }
                
            },
            error: function (r) {
                console.log(r.responseText);
            }
            
        });
    }
});
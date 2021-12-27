$(document).ready(function(){
    $("#listaReportes").hide();
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
                    switch(r[i]["id_menu"]){
                        case "1":
                            var lista ='<li><a href="infor_activo_fijo.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuActivos").append(lista);
                        break;
                        case "2":
                            var lista ='<li><a href="#">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuActivos").append(lista);
                        break;
                        case "3":
                            var lista ='<li><a href="nuevoUsuario.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuUsuarioRol").append(lista);
                        break;
                        case "4":
                            var lista ='<li><a href="#">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuUsuarioRol").append(lista);
                        break;
                        case "5":
                            var lista ='<li><a href="ActivoResponsable.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuResp").append(lista);
                        break;
                        case "6":
                            $("#listaReportes").show();
                        break;
                    }
                   
                }
                
            },
            error: function (r) {
                console.log(r.responseText);
            }
            
        });
    }
});
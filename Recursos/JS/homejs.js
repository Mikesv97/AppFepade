$(document).ready(function(){
    //ocultamos menú para mostrarlo según rol
    ocultarMenu();
    ocultarBtnsRol(rol);

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


    
    //función que oculta el menú para mostrarlo mediante
    //la función solicitarMenuRol() según el rol
    function ocultarMenu(){
        $("#listaActivos").hide();
        $("#listaUsuarioRoles").hide();
        $("#listaResponsable").hide();
        $("#listaReportes").hide();
    }

    //función que oculta los btns según el rol
    function ocultarBtnsRol(rol){

        switch(rol){
            case "Admin":
                //botones de activo fijo
                $("#btnIngresar").show();
                $("#btnModificar").show();
                $("#btnEliminar").show();
                $("#btnModificarHostorico").show();
                $("#btnEliminarHistorico").show();

                //botones de tipo activo


                //botones de usuario nuevo

                //botones de responsable

            break;
            case "Secretaria":
                //botones de activo fijo
                $("#btnModificar").hide();
                $("#btnEliminar").hide();
                //botones de hitorico activo
                $("#btnModificarHostorico").hide();
                //botones de tipo activo
                $("#btnModificar").hide();
            break;
            case "Visitante":
                //botones de activo fijo
                $("#btnIngresar").hide();
                $("#btnModificar").hide();
                $("#btnEliminar").hide();
                $("#btnCancelar").hide();
                //botones de hitorico activo
                $("#btnModificarHostorico").hide();
                $("#btnNuevoHistorico").hide();
                $("#btnInsertarHistorico").hide();
                
                //botones de tipo activo
                $("#btnInsertar").hide();
                $("#btnModificar").hide();
                $("#btnCancelar").hide();

                //botones de usuario nuevo
                $("#btnNewUser").hide();

                //botones de responsable
            break;
        }
    }
});
//función que solicita el menú de la BD en base al rol logueado
    function  solicitarMenuRol(idRol){
        $("#subMenuActivos li").remove();
        $("#subMenuUsuarioRol li").remove();
        $("#subMenuResp li").remove();
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "solicitarMenu","idRol": idRol},
            success: function (r) {
                for(let i=0; i<r.length; i++){
                    switch(r[i]["menu_padre"]){
                        case "activos":
                            var lista ='<li><a href="'+r[i]["direccion_web"]+'">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuActivos").append(lista);
                            $("#listaActivos").show();
                        break;
                        case "usuarios y roles":
                            var lista ='<li><a href="'+r[i]["direccion_web"]+'">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuUsuarioRol").append(lista);
                            $("#listaUsuarioRoles").show();
                        break;
                        case "responsables":
                            var lista ='<li><a href="'+r[i]["direccion_web"]+'">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuResp").append(lista);
                            $("#listaResponsable").show();
                        break;
                        case "reportes":
                            $("#listaReportes").show();
                        break;
                    }
                   
                }
                
            },
            error: function (r) {
                console.log(r.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece que tenemos problemas para comunicarnos con los servidores y cargar los checkbox del menú'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
            
        });
    }
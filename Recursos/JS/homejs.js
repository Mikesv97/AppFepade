$(document).ready(function(){
    //ocultamos menú para mostrarlo según rol
    ocultarMenu();
    ocultarBtnsRol(rol);

    //cuando carga la pag solicitamos menú según Rol del usuario
    solicitarMenuRol(idRol);

    //cuando carga la pag solicitamos acciones según Rol del usuario
    bloquearBtnRol(idRol);

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

    //función que solicita el menú de la BD en base al rol logueado
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
                            $("#listaActivos").show();
                        break;
                        case "2":
                            var lista ='<li><a href="tipoActivo.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuActivos").append(lista);
                            $("#listaActivos").show();
                        break;
                        case "3":
                            var lista ='<li><a href="nuevoUsuario.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuUsuarioRol").append(lista);
                            $("#listaUsuariosRoles").show();
                        break;
                        case "4":
                            var lista ='<li><a href="#">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuUsuarioRol").append(lista);
                            $("#listaUsuarioRoles").show();
                        break;
                        case "5":
                            var lista ='<li><a href="ActivoResponsable.php">';
                            lista += r[i]["nombre_menu"]+'</a></li>';
                            $("#subMenuResp").append(lista);
                            $("#listaResponsable").show();
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
    
    //función que solicita las acciones (CRUD) de la BD en base al rol logueado
    function bloquearBtnRol(){
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "soliAccRol","idRol": idRol},
            success: function (r) {
                for(let i=0; i<r.length; i++){
                    switch(r[i]["nombre_accion"]){
                        case "Ingresar":
                            //puede ingresar datos al sistema
                        break;
                        case "Editar":
                            //puede editar los datos del sistema
                        break;
                        case "Eliminar":
                            //puede eliminar datos del sistema
                        break;
                        case "Ninguna":
                            //no puede realizar ninguna acción, es visitante
                            //$("#verFormulario").attr("disabled",true);
                            $("#btnModificar").attr("disabled",true);
                        break;
                    }
                   
                }
                
            },
            error: function (r) {
                console.log(r.responseText);
            }
            
        });
    }

    function ocultarMenu(){
        $("#listaActivos").hide();
        $("#listaUsuarioRoles").hide();
        $("#listaResponsable").hide();
        $("#listaReportes").hide();
    }

    function ocultarBtnsRol(rol){

        switch(rol){
            case "Admin":
                $("#btnIngresar").show();
                $("#btnModificar").show();
                $("#btnEliminar").show();
                $("#btnModificarHostorico").show();
                $("#btnEliminarHistorico").show();
            break;
            case "Secretaria":
                $("#btnIngresar").show();
                $("#btnModificar").hide();
                $("#btnEliminar").hide();
                $("#btnModificarHostorico").hide();
                $("#btnEliminarHistorico").hide();
            break;
            case "Visitante":
                $("#btnIngresar").hide();
                $("#btnModificar").hide();
                $("#btnEliminar").hide();
                $("#btnModificarHostorico").hide();
                $("#btnEliminarHistorico").hide();
            break;
        }
    }
});
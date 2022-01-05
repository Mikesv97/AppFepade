$(document).ready(function(){
    ocultarBtnsRol();

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

   //función que oculta los btns según el rol
    function ocultarBtnsRol(){
        //ocultamos todos los botones
        $("#btnIngresar").hide();
        $("#btnInsertar").hide();
        $("#btnNuevoHistorico").hide();
        $("#btnInsertarHistorico").hide();
        $("#btnIngresarMenu").hide();
        $("#btnNewUser").hide();
        $("#btnModificar").hide();
        $("#btnModificarHostorico").hide();
        $("#btnGuardar").hide();
        $("#btnGuardarMenu").hide();
        $("#btnEliminar").hide();
        $("#btnCancelar").hide();

        //validamos mediante ajax la acciones permitadas para el rol del usuario
        //que inicio sesión
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "soliAccRol","idRol": idRol},
            success: function (r) {
                //validamos cada acción y vamos mostrando sus respectivos btns.
                for(let i=0; i<r.length; i++){
                    switch(r[i]["nombre_accion"].toLowerCase()){
                        case "ingresar":
                            $("#btnIngresar").show();
                            $("#btnInsertar").show();
                            $("#btnNuevoHistorico").show();
                            $("#btnInsertarHistorico").show();
                            $("#btnIngresarMenu").show();
                            $("#btnNewUser").show();  
                            $("#btnCancelar").show();          
                        break;
                        case "editar":
                            $("#btnModificar").show();
                            $("#btnModificarHostorico").show();
                            $("#btnGuardar").show();
                            $("#btnGuardarMenu").show();
                            $("#btnCancelar").show();
                        break;
                        case "eliminar":
                            $("#btnEliminar").show();
                        break;
                    }
                   
                }
                
            },
            error: function (r) {
                console.log(r.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece que tenemos problemas para comunicarnos con los servidores y validar las acciones permitidas para el rol del usuario'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
            
        });
       
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
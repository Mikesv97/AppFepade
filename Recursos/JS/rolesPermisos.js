$.noConflict();
jQuery(document).ready(function ($){
    //variables globales
    var error = null;
    var editarOn = false;
    var rolEdit= null;
    var menuEdit= null;
 
    $("#labelError").hide();
    $("#labelErrorMenu").hide();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardarMenu").prop("disabled", true);

    cargarRoles();
    cargarAcciones();
    cargarMenus();
    cargarTblMenu();
  
    //cuando se genere click en el último elemento de la lista
    //desmarcamos los demás chekbox de la misma lista (más detalles dentro de la función, al final.)
    $("body").on("click","#grupoCkbAcciones li:last", function(){

        /*como se hace clic en el último elemento de la lista que pertenece a ninguno obtenemos su valor */
        var valNinguno = $(this).find(".ckbAcciones").val();
         //evaluamos si el chekbox ninguno esta seleccionado
        if($(this).find(".ckbAcciones").is(":checked")){
            //si está seleccionado, recorremos todos los chekbox con clase .ckbAcciones 
            $(".ckbAcciones:checkbox").each(function(index, elemento){
            //preguntamos si el elemento actual del recorrido (0,1,2,etc)
            //está seleccionado
            if($(elemento).is(":checked")){
                //si esta seleccionado, evaluamos que su valor no sea igual al del último elemento("ninguno")
                if($(elemento).val() != valNinguno){
                    //si su valor es difetente, quiere decir que el chekbox seleccionado
                    //es diferente a ninguno, procedemos a desmarcarlo
                    $(elemento).prop('checked',false);
                }
            }
        });
        }

        /* -----DETALLE DE LA LÓGICA DE LA FUNCIÓN */
        /*Cuando se genere clic en el último elemento de la lista de ID grupoCkbAcciones
        desmarcamos los demás checkbox seleccionados, ya que el último elemento de la lista pertenece
        a "Ninguna" lo que significa que el rol no podrá hacer ninguna acción en el sistema, porque así 
        lo definimos en la tabla acciones en la BD, si esto se cambia, y la acción "ninguna" deja de ser
        el último elemento, se debe ajustar al elemento que sea, ejm: first, second, etc. O en caso no la
        agreguen es de comentar/eliminar esta función */
    });

    /*lo contrario a lo del evento click del último elemento de la lista de ID grupoCkbAcciones*/
    $("body").on("click","#grupoCkbAcciones li", function(){
        //obtenemos el número total de elementos inputs tipo chekbox con clase .ckbAcciones
        var totalCkbAcc =  $(".ckbAcciones:checkbox").length;
        //preguntamos si el index donde se hizo click es el mismo del total (que viene siendo el último)
        if($(this).index() != totalCkbAcc){
            //en caso sea diferente, quiere decir que hizo click en otro chekbox
            //diferente a "Ninguna", procedemos a desmarcar el chekbox "Ninguna"
            $(".ckbAcciones:checkbox:last").prop('checked',false);
        }

    });

    /*al envento change del input nombre rol, validamos que no esté ingresado el rol*/
    $("#txtNombreRol").change(function(){
        //obtenemos el valor ingresado, convirtiendo a mayusculas el primer caracter
        //para evitar que admin (ingresado por el usuario) != Admin (valor en BD)
        //y mantener siempre la primer letra mayuscula.
        var rolIngresado = convertirPrimerLetraMayus($(this).val());
        if(rolIngresado == rolEdit){
            $("#labelError").hide();
        }

        if(editarOn == true){
            if(rolIngresado != rolEdit){
                //llamamos a la función que envia ajax pidiendo roles
                //llamamos a la función y su parametro (el arreglo) que viene siendo el parametro callbalck 
                //definido cuando creamos la función
                validarRolNoRegistrado(function(roles){
                    //recorremos el arreglo y buscamos si el valor ingresado ya existe
                    for(let i=0; i<roles.length; i++){
                        if(roles[i]==rolIngresado){
                            //si existe, lanzamos error
                            $("#labelError").show();
                            $("#labelError").text("Rol puta ingresado en el sistema, por favor ingresa otro.");
                            $("#txtNombreRol").focus();
                            i=roles.length;
                            error = rolIngresado;
                        }else{
                            //sino, ocultamos el error por si está visible
                            $("#labelError").hide();
                        }
                    }
                });
            }
        }else{
            //llamamos a la función que envia ajax pidiendo roles
            //llamamos a la función y su parametro (el arreglo) que viene siendo el parametro callbalck 
            //definido cuando creamos la función
            validarRolNoRegistrado( function(roles){
                //recorremos el arreglo y buscamos si el valor ingresado ya existe
                for(let i=0; i<roles.length; i++){
                    if(roles[i]==rolIngresado){
                        //si existe, lanzamos error
                        $("#labelError").show();
                        $("#labelError").text("Rol ya ingresado en el sistema, por favor ingresa otro.");
                        $("#txtNombreRol").focus();
                        i=roles.length;
                        error = rolIngresado;
                    }else{
                        //sino, ocultamos el error por si está visible
                        $("#labelError").hide();
                    }
                }
            });
        }
        
    });


    /*al envento change del input nombre menu, validamos que no esté ingresado el menu*/
    $("#txtNombreMenu").change(function(){
        //obtenemos el valor ingresado, convirtiendo a mayusculas el primer caracter
        //para evitar que menu (ingresado por el usuario) != Menu (valor en BD)
        //y mantener siempre la primer letra mayuscula.
        var menuIngresado = convertirPrimerLetraMayus($(this).val());
        if(menuIngresado == menuEdit){
            $("#labelErrorMenu").hide();
        }
        if(editarOn == true){
            if(menuIngresado != menuEdit){
                //llamamos a la función que envia ajax pidiendo roles
                //llamamos a la función y su parametro (el arreglo) que viene siendo el parametro callbalck 
                //definido cuando creamos la función
                validarMenuNoRegistrado(function(menu){
                    //recorremos el arreglo y buscamos si el valor ingresado ya existe
                    for(let i=0; i<menu.length; i++){
                        if(menu[i]==menuIngresado){
                            //si existe, lanzamos error
                            $("#labelErrorMenu").show();
                            $("#labelErrorMenu").text("Menú ya ingresado en el sistema, por favor ingresa otro.");
                            $("#txtNombreMenu").focus();
                            i=menu.length;
                            error = menuIngresado;
                        }else{
                            //sino, ocultamos el error por si está visible
                            $("#labelError").hide();
                        }
                    }
                });
            }
        }else{
            //llamamos a la función que envia ajax pidiendo menu
            //llamamos a la función y su parametro (el arreglo) que viene siendo el parametro callbalck 
            //definido cuando creamos la función
            validarMenuNoRegistrado( function(menu){
                //recorremos el arreglo y buscamos si el valor ingresado ya existe
                for(let i=0; i<menu.length; i++){
                    if(menu[i]==menuIngresado){
                        //si existe, lanzamos error
                        $("#labelErrorMenu").show();
                        $("#labelErrorMenu").text("Menú ya ingresado en el sistema, por favor ingresa otro.");
                        $("#txtNombreMenú").focus();
                        i=menu.length;
                        error = menuIngresado;
                    }else{
                        //sino, ocultamos el error por si está visible
                        $("#labelErrorMenu").hide();
                    }
                }
            });
        }
        
    });

    /*cuando presiona tecla en el input nombre rol ocultamos el error si está visible*/
    $("#txtNombreRol").keypress(function(){
        
        if($("#labelError").is(":visible")){
            
            if($(this).val() != error){
                $("#labelError").hide();
            }
        }


    });

    /*cuando presiona tecla en el input nombre menu ocultamos el error si está visible*/
    $("#txtNombreMenu").keypress(function(){
        
        if($("#labelError").is(":visible")){
                
            if($(this).val() != error){
                $("#labelError").hide();
            }
        }
    
    
    });

    //cuando se ejecuta el submit del form roles
    $("#frmRoles").submit(function(e){
   
        //evitamos el evento
        e.preventDefault();

        if($("#labelError").is(":visible")){
            Swal.fire(
                'Errores Detectados',
                'Verifica que la información ingresada sea correcta y no tenga errores.',
                'info'
              )
              
        }else{
            //obtenemos el array con las acciones seleccionadas para el rol
            var accionesArray = generarArrayAcciones();

            //obtenemos el array con el menú seleccionado para el rol
            var menuArray = generarArrayMenu();

            if(accionesArray ==0){
                Swal.fire(
                    '¿Acciones para este rol?',
                    'Debes seleccionar al menos una acción para este rol',
                    'question'
                )
                $("#btnIngresar").blur();
            }else if(menuArray ==0){
                Swal.fire(
                    '¿Menú para este rol?',
                    'Debes seleccionar al menos un menú al que podrá acceder este rol',
                    'question'
                )
                $("#btnIngresar").blur();
            }else{
                    var nombreRol = $("#txtNombreRol").val();
                    var descRol =  $("#txtDescRol").val();

                    //se envia ajax
                    $.ajax({
                        url:"../controladores/rolesPermisosControlador.php",
                        method: "post",
                        dataType: "json",
                        data: { "key": "insertarRol",
                        "nombreRol": nombreRol,
                        "descRol": descRol, 
                        "accionesArray": accionesArray,
                        "menuArray": menuArray},
                        success: function (r) {
                            if(r == true){
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'success',
                                    title: 'Rol insertado con éxtio',
                                    showConfirmButton: false,
                                    timer: 1500
                                  })
                                $("#frmRoles")[0].reset();
                                $('#tblRoles').DataTable().ajax.reload();
                            }
                        },
                        error: function (r) {
                            console.log(r.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: "Problemas de comunicación",
                                text: 'Parece tenemos problemas para comunicarnos con los servidores e insertar el rol'
                                +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                showConfirmButton: true
                            })
                        }
                    });   
            }
        }
       

    });

    //cuando se ejecuta el submit del form roles
    $("#frmMenu").submit(function(e){
   
        //evitamos el evento
        e.preventDefault();
    
        if($("#labelErrorMenu").is(":visible")){
             Swal.fire(
                'Errores Detectados',
                'Verifica que la información ingresada sea correcta y no tenga errores.',
                'info'
                )
                  
        }else{
            var menu = $("#txtNombreMenu").val();
            var nombreMenu = convertirPrimerLetraMayus(menu);
            var direccionWeb = $("#txtDireccionWeb").val();
            var menuPadre = $("#txtMenuPadre").val();

            //se envia ajax
            $.ajax({
                url:"../controladores/rolesPermisosControlador.php",
                method: "post",
                dataType: "json",
                data: { "key": "insertarMenu",
                "nombreMenu": nombreMenu,
                "direccionWeb": direccionWeb,
                "menuPadre": menuPadre.toLowerCase()},
                success: function (r) {
                    if(r == true){
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Menú insertado con éxtio',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        $("#frmMenu")[0].reset();
                        $("#grupoCkbMenu li").remove();
                        cargarMenus();
                        $('#tblMenus').DataTable().ajax.reload();

                    }
                },
                error: function (r) {
                    console.log(r.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: "Problemas de comunicación",
                        text: 'Parece tenemos problemas para comunicarnos con los servidores e insertar el menú'
                         +' por favor verifica tu conexión de internet e intenta de nuevo.',
                        showConfirmButton: true
                    })
                }
            });   
                
        }
           
    
    });

    //al click del ojo es para ver toda la información del rol
    $("#tblRoles tbody").on("click","#btnMostrar", function(){
       //deshabilitamos controles y mandamos al inicio del form al usuario
       $(location).attr('href', '#inicioForm');
       //deshabilitamos los controles
       disabledControles(true);
       $("#btnIngresar").prop("disabled", true);
       $("#btnGuardar").prop("disabled", true);
      
       
       //cargamos información de la tabla donde se hizo click
       var table = $('#tblRoles').DataTable();
       var data = table.row(this).data();
       
       //pasamos el campo ID de la fila a la función que se encarga de poner cheque
       //a los checkbox de menu según tenga asignado el rol seleccionado 
       cargarCheckBoxMenuRol(data["id_rol"]);
       cargarChekBoxAccionesRol(data["id_rol"]);
       
       $("#txtNombreRol").val(data["rol_nombre"]);
       $("#txtDescRol").val(data["rol_descripcion"]);
       
    });

    //al click del ojo es para ver toda la información del menú
    $("#tblMenus tbody").on("click","#btnMostrar", function(){
         //deshabilitamos controles y mandamos al inicio del form al usuario
        $(location).attr('href', '#inicioForm');
        //deshabilitamos los controles
        disabledControlesMenu(true);
        $("#btnIngresarMenu").prop("disabled", true);
        $("#btnGuardarMenu").prop("disabled", true);
           
            
        //cargamos información de la tabla donde se hizo click
        var table = $('#tblMenus').DataTable();
        var data = table.row(this).data();
            
        $("#txtNombreMenu").val(data["nombre_menu"]);
        $("#txtDireccionWeb").val(data["direccion_web"]);
        $("#txtMenuPadre").val(data["menu_padre"]);
            
    });

    //al click del btn editar información de la fila en la tabla roles
    $("#tblRoles tbody").on("click", "#btnEditar", function(){
        $("#labelError").hide();
        //activamos bandera de que se quiere modificar para lo de el evento change del input nombre rol
        editarOn = true;

        //habilitamos controles y mandamos al inicio del form al usuario
       $(location).attr('href', '#inicioForm');
       //habilitamos los controles
       disabledControles(false);
       $("#btnIngresar").prop("disabled", true);
       $("#btnGuardar").prop("disabled", false);
      
       
       //cargamos información de la tabla donde se hizo click
       var table = $('#tblRoles').DataTable();
       var data = table.row(this).data();
       
       //pasamos el campo ID de la fila a la función que se encarga de poner cheque
       //a los checkbox de menu según tenga asignado el rol seleccionado 
       cargarCheckBoxMenuRol(data["id_rol"]);
       cargarChekBoxAccionesRol(data["id_rol"]);
       
       $("#txtNombreRol").val(data["rol_nombre"]);
       rolEdit = data["rol_nombre"];
       $("#txtDescRol").val(data["rol_descripcion"]);
       $("#txtId").val(data["id_rol"]);
    });

    //al click del btn editar es para editar la info del menú
    $("#tblMenus tbody").on("click","#btnEditar", function(){
        $("#labelErrorMenu").hide();
        editarOn = true;
        //habilitamos controles y mandamos al inicio del form al usuario
        $(location).attr('href', '#inicioForm');
        //habilitamos los controles
        disabledControlesMenu(false);
        $("#btnIngresarMenu").prop("disabled", true);
        $("#btnGuardarMenu").prop("disabled", false);
 
        //cargamos información de la tabla donde se hizo click
        var table = $('#tblMenus').DataTable();
        var data = table.row(this).data();
               
        $("#txtNombreMenu").val(data["nombre_menu"]);
        $("#txtDireccionWeb").val(data["direccion_web"]);
        $("#txtMenuPadre").val(data["menu_padre"]);
        $("#txtIdMenu").val(data["id_menu"]);

        menuEdit = data["nombre_menu"];
               
    });

    //al click del btnGuardar enviamos información al controlador para actualizar en la BD
    $("#btnGuardar").on("click", function(){
        //preguntamos si está seguro de la acción a realizar
        Swal.fire({
            title: '¿Actualizar la información?',
            text: "¿Seguro/a de ingresar esta información al sistema?, los cambios no serán reversibles"
            +" una vez ingresados, por favor confirma la acción.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Actualizarla!'
          }).then((result) => {
              ///si está seguro de hacerlo evaluamos la información
            if (result.isConfirmed) {
                if($("#labelError").is(":visible")){
                    //si hay errores lanzamos alerta
                    Swal.fire(
                        'Errores Detectados',
                        'Verifica que la información ingresada sea correcta y no tenga errores.',
                        'info'
                      )
                      
                }else{
                    //obtenemos el array con las acciones seleccionadas para el rol
                    var accionesArray = generarArrayAcciones();
        
                    //obtenemos el array con el menú seleccionado para el rol
                    var menuArray = generarArrayMenu();
        
                    if(accionesArray ==0){
                        Swal.fire(
                            '¿Acciones para este rol?',
                            'Debes seleccionar al menos una acción para este rol',
                            'question'
                        )
                        $("#btnIngresar").blur();
                    }else if(menuArray ==0){
                        Swal.fire(
                            '¿Menú para este rol?',
                            'Debes seleccionar al menos un menú al que podrá acceder este rol',
                            'question'
                        )
                        $("#btnIngresar").blur();
                    }else{
                            var nombreRol = $("#txtNombreRol").val();
                            var descRol =  $("#txtDescRol").val();
                            var idRolTbl = $("#txtId").val();
                            //se envia ajax
                            $.ajax({
                                url:"../controladores/rolesPermisosControlador.php",
                                method: "post",
                                dataType: "json",
                                data: { "key": "editarRol",
                                "idRolTbl": idRolTbl,
                                "nombreRol": nombreRol,
                                "descRol": descRol, 
                                "accionesArray": accionesArray,
                                "menuArray": menuArray},
                                success: function (r) {
                                    console.log(r);
                                    if(r == true){
                                        Swal.fire({
                                            position: 'bottom-end',
                                            icon: 'success',
                                            title: 'Rol editado con éxtio',
                                            showConfirmButton: false,
                                            timer: 1500
                                          })
                                        $("#frmRoles")[0].reset();
                                        $('#tblRoles').DataTable().ajax.reload();
                                        editarOn = false;
                                        rolEdit = null;
                                    }
                                },
                                error: function (r) {
                                    console.log(r.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Problemas de comunicación",
                                        text: 'Parece tenemos problemas para comunicarnos con los servidores y editar el rol'
                                        +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                        showConfirmButton: true
                                    })
                            }
                        });   
                    }
                }

            }
          })
    });

    //al click del btnGuardar enviamos información al controlador para actualizar en la BD
    $("#btnGuardarMenu").on("click", function(){
        //preguntamos si está seguro de la acción a realizar
        Swal.fire({
            title: '¿Actualizar la información?',
                text: "¿Seguro/a de ingresar esta información al sistema?, los cambios no serán reversibles"
                +" una vez ingresados, por favor confirma la acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Actualizarla!'
            }).then((result) => {
                ///si está seguro de hacerlo evaluamos la información
                if (result.isConfirmed) {
                    if($("#labelError").is(":visible")){
                        //si hay errores lanzamos alerta
                        Swal.fire(
                            'Errores Detectados',
                            'Verifica que la información ingresada sea correcta y no tenga errores.',
                            'info'
                        )      
                    }else{
                        var idMenu = $("#txtIdMenu").val();
                        var menu = $("#txtNombreMenu").val();
                        var nombreMenu = convertirPrimerLetraMayus(menu);
                        var direccionWeb = $("#txtDireccionWeb").val();
                        var menuPadre = $("#txtMenuPadre").val();
                        //se envia ajax
                        $.ajax({
                            url:"../controladores/rolesPermisosControlador.php",
                            method: "post",
                            dataType: "json",
                            data: { "key": "editarMenu",
                            "idMenu": idMenu,
                            "nombreMenu": nombreMenu,
                            "direccionWeb": direccionWeb,
                            "menuPadre": menuPadre},
                            success: function (r) {
                                console.log(r);
                                if(r == true){
                                    Swal.fire({
                                        position: 'bottom-end',
                                        icon: 'success',
                                        title: 'Rol editado con éxtio',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $("#frmMenu")[0].reset();
                                    $("#grupoCkbMenu li").remove();
                                    cargarMenus();
                                    $('#tblMenus').DataTable().ajax.reload();
                                    editarOn = false;
                                }
                            },
                            error: function (r) {
                                console.log(r.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: "Problemas de comunicación",
                                    text: 'Parece tenemos problemas para comunicarnos con los servidores y editar el menú'
                                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                    showConfirmButton: true
                                })
                            }
                        });   
                        
                    }
                }
              })
    });

    //al click del btn eliminar información de la fila en la tabla roles
    $("#tblRoles tbody").on("click", "#btnEliminar", function(){
        //preguntamos si está seguro
        Swal.fire({
            title: '¿Eliminar el registro?',
            text: "¿Seguro/a de eliminar el registro?, la acción no será reversible, por facor"
            +"confirma la acción.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminarlo!'
          }).then((result) => {
            if (result.isConfirmed) {
                //cargamos información  de la tabla donde se hizo click
                var table = $('#tblRoles').DataTable();
                var data = table.row(this).data();
                var idRolTbl = data["id_rol"];
                //enviamos ajax
                $.ajax({
                    url:"../controladores/rolesPermisosControlador.php",
                    method: "post",
                    dataType: "json",
                    data: { "key": "eliminarRol",
                    "idRolTbl": idRolTbl},
                    success: function (r) {
                        console.log(r);
                        if(r == true){
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: 'Rol eliminado con éxtio',
                                showConfirmButton: false,
                                timer: 1500
                              })
                            $("#frmRoles")[0].reset();
                            $('#tblRoles').DataTable().ajax.reload();
                        }else if(r="rolAsignado"){
                            Swal.fire({
                                icon: 'error',
                                title: "Rol ya asignado",
                                text: 'No se puede eliminar un rol el cual ya fue asignado a uno o más usuarios, por favor'
                                +' elimina el/los usuarios con este rol primero para poder eliminarlo, si crees que se trata de un error'
                                +' contacta con tu administrado o personal de TI.',
                                showConfirmButton: true
                            })
                        }
                    },
                    error: function (r) {
                        console.log(r.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: "Problemas de comunicación",
                            text: 'Parece tenemos problemas para comunicarnos con los servidores y eliminar el rol'
                            +' por favor verifica tu conexión de internet e intenta de nuevo.',
                            showConfirmButton: true
                        })
                    }
                });  
            }
          })


    });

    //al click del btn eliminar información de la fila en la tabla roles
    $("#tblMenus tbody").on("click", "#btnEliminar", function(){
        //preguntamos si está seguro
        Swal.fire({
                title: '¿Eliminar el registro?',
                text: "¿Seguro/a de eliminar el registro?, la acción no será reversible, por facor"
                +"confirma la acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                //cargamos información  de la tabla donde se hizo click
                var table = $('#tblMenus').DataTable();
                var data = table.row(this).data();
                var idMenuTbl = data["id_menu"];
                //enviamos ajax
                $.ajax({
                    url:"../controladores/rolesPermisosControlador.php",
                    method: "post",
                    dataType: "json",
                    data: { "key": "eliminarMenu",
                    "idMenuTbl": idMenuTbl},
                    success: function (r) {
                        console.log(r);
                        if(r == true){
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: 'Rol eliminado con éxtio',
                                showConfirmButton: false,
                                timer: 1500
                                })
                                $("#frmMenu")[0].reset();
                                $("#grupoCkbMenu li").remove();
                                cargarMenus();
                                $('#tblMenus').DataTable().ajax.reload();
                        }else if(r="menuAsignado"){
                            Swal.fire({
                                icon: 'error',
                                title: "Menú ya asignado",
                                text: 'No se puede eliminar un menú el cual ya fue asignado a uno o más roles'
                                +' primero debes quitar la asignación de este menú de los roles que lo tienen asignado Ya para poder eliminarlo, si crees que se trata de un error'
                                +' contacta con tu administrado o personal de TI.',
                                showConfirmButton: true
                            })
                        }
                    },
                    error: function (r) {
                        console.log(r.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: "Problemas de comunicación",
                            text: 'Parece tenemos problemas para comunicarnos con los servidores y eliminar el menú'
                            +' por favor verifica tu conexión de internet e intenta de nuevo.',
                            showConfirmButton: true
                        })
                    }
                });  
            }
        })
    });
    

    function disabledControles(boolean){

        $("#txtNombreRol").prop("disabled", boolean);
        $("#txtDescRol").prop("disabled", boolean);
        $(".ckbAcciones:checkbox").prop("disabled",boolean);
        $(".ckbMenu:checkbox").prop("disabled",boolean);
    }

    function disabledControlesMenu(boolean){

        $("#txtNombreMenu").prop("disabled", boolean);
        $("#txtDireccionWeb").prop("disabled", boolean);
        $("#txtMenuPadre").prop("disabled", boolean);

    }


    //función que solicita por ajax el menú según el idRol pasado como parametro
    //que sería el ID del rol seleccionado en la tabla
    //se comunica con homeControlador para reutilizar código.
    //y carga los chekbox según la información obtenido de la BD para el rol seleccionado
    function cargarCheckBoxMenuRol(idRolTbl){
        $(".ckbMenu:checkbox").prop("checked", false);
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "solicitarMenu","idRol": idRolTbl},
            success: function (r) {
                if(r == "ID Rol No Definido"){
                    Swal.fire({
                        icon: 'error',
                        title: "Problemas Encontrados",
                        text: 'Parece tenemos problemas, el ID del rol seleccionado no es encontrado en el sistema'
                        +' por favor verifica que seleccionas un ID valido, si el problema persiste informa a tu administrador '
                        +'o personal de TI.',
                        showConfirmButton: true
                    })
                }else{
                    $(".ckbMenu:checkbox").each(function(index, elemento){                    
                        for(let i=0; i<r.length; i++){
                           if($(elemento).val() == r[i]["id_menu"]){
                               $(elemento).prop("checked", true);
                           }
                       }
                   });
                }
            },
            error: function (r) {
                //console.log(r.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar el menú asignado para este rol'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
            
        });
    }

    //función que solicita las acciones del rol seleccionado
    //para cargar los chekbox corrrespondiente
    //se comunica con homecontrolador para reutilizar código
    function cargarChekBoxAccionesRol(idRolTbl){
        $(".ckbAcciones:checkbox").prop("checked", false);
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "soliAccRol","idRol": idRolTbl},
            success: function (r) {
                if(r == "ID Rol No Definido"){
                    Swal.fire({
                        icon: 'error',
                        title: "Problemas Encontrados",
                        text: 'Parece tenemos problemas, el ID del rol seleccionado no es encontrado en el sistema'
                        +' por favor verifica que seleccionas un ID valido, si el problema persiste informa a tu administrador '
                        +'o personal de TI.',
                        showConfirmButton: true
                    })
                }else{
                    $(".ckbAcciones:checkbox").each(function(index, elemento){
                        for(let i=0; i<r.length; i++){
                            if($(elemento).val() == r[i]["id_accion"]){
                                $(elemento).prop("checked", true);
                            } 
                        } 
                    });
                }
            },
            error: function (r) {
                console.log(r.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar las acciones asignadas a este rol'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
            
        });
    }

    //función que solicita por ajax la carga de roles
    //y carga la tabla automáticamente con Ajax- DataTable
    function  cargarRoles() {
        $.noConflict();
        $('#tblRoles').DataTable({
                "ajax":{
                    "url": "../controladores/rolesPermisosControlador.php",
                    "method": "post",
                    "dataType": "json",
                    "data": { "key": "obtenerRoles" },
                    "dataSrc": ""
                },
                "columns": [
                    {
                        data: "id_rol",
                        className: "idRol"
                    },
                    {
                        data: "rol_nombre",
                        className: "nombreRol"
                    },
                    {
                        data: "rol_descripcion",
                        className: "rolDescripcion"
                    },
                    {
               
                        data: null,
                        className: "center",
                        defaultContent: '<button type="button" class="btn btn-spotify" id="btnMostrar"><i class="fa fa-eye"></i></button>'
                            
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: 
                        '<button id="btnEditar" class="btn btn-warning noHover">Editar</button>'
                        +'<button id="btnEliminar" class="mx-2 btn btn-danger noHover">Eliminar</button>'
                    }
                ],
                responsive: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado datos - intente nuevamente",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "infoFiltered": "(Filtrado de _MAX_ activos totales)",
                    "search": "Buscar",
                    "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                    }
                }
            });
    }

    //función que solicita por ajax la carga de menu
    //y carga la tabla automáticamente con Ajax- DataTable
    function  cargarTblMenu() {
        $.noConflict();
        $('#tblMenus').DataTable({
                "ajax":{
                    "url": "../controladores/rolesPermisosControlador.php",
                    "method": "post",
                    "dataType": "json",
                    "data": { "key": "obtenerMenu" },
                    "dataSrc": ""
                },
                "columns": [
                    {
                        data: "id_menu",
                        className: "idMenu"
                    },
                    {
                        data: "nombre_menu",
                        className: "nombreMenu"
                    },
                    {
                        data: "direccion_web",
                        className: "direccionWeb"
                    },
                    {
                        data: "menu_padre",
                        className: "menuPadre"
                    },
                    {
               
                        data: null,
                        className: "center",
                        defaultContent: '<button type="button" class="btn btn-spotify" id="btnMostrar"><i class="fa fa-eye"></i></button>'
                            
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: 
                        '<button id="btnEditar" class="btn btn-warning noHover">Editar</button>'
                        +'<button id="btnEliminar" class="mx-2 btn btn-danger noHover">Eliminar</button>'
                    }
                ],
                responsive: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se han encontrado datos - intente nuevamente",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "infoFiltered": "(Filtrado de _MAX_ activos totales)",
                    "search": "Buscar",
                    "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                    }
                }
            });
    }



    //función que solicita las acciones (CRUD) de la BD para cargar los
    //chekbox en la vista roles y permisos
    function cargarAcciones(){
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerAcciones"},
            success: function (r) {
                var count = parseInt(0);

               for(let i=0; i<r.length; i++){
                    var div =
                        '<li><input type="checkbox" value="'+r[i]["id_accion"]+'" class=" form-check-input checkContent ckbAcciones" id="accionItem'+count+'">'
                        +'<label class="form-check-label checkContent" for="accionItem'+count+'">'+r[i]["nombre_accion"]+'</label></li>';
                    count++;
                    $("#grupoCkbAcciones").append(div);
               }
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar las acciones para el rol'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }

    //función que solicita el menu de la BD para cargar los
    //chekbox en la vista roles y permisos
    function cargarMenus(){
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerMenu"},
            success: function (r) {
                var count = parseInt(0);

               for(let i=0; i<r.length; i++){
                    var div =
                        '<li><input type="checkbox" value="'+r[i]["id_menu"]+'" class="form-check-input ckbMenu" id="menuItem'+count+'">'
                        +'<label class="form-check-label" for="menuItem'+count+'">'+r[i]["nombre_menu"]+'</label></li>';
                    count++;
                    $("#grupoCkbMenu").append(div);
               }
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar el menú'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }

    /* esta función recorre todos los chekbox con clase .ckbAcciones
       crea un array con cada valor seleccionado y lo retorna  */
    function generarArrayAcciones(){
        //obtenemos el total de elementos inputs tipo chekbox con clase ckbAcciones
        var totalCkbAcc = $(".ckbAcciones:checkbox").length;
        //creamos el array
        var accionesArray = [];
        //creamos contador para ir manejando el número de elementos seleccionados
        var count = parseInt(0);
        //creamos una variable para controlar que se seleccione almenos un chekbox
        var countSelectCkbx = parseInt(0);
        //recorremos y verificamos si almenos un ckbx de acción está seleccionado
        $(".ckbAcciones:checkbox").each(function(index, elemento){
            if($(elemento).is(":checked")){
                //si está seleccionado el elemento actual del recorrido
                //evaluamos si es el último o no
                if(index != (totalCkbAcc-1)){
                    // si no es el último, asignamos la posicion de count con el valor del elemento actual
                    accionesArray[count] = $(elemento).val();
                    //incrementamos en 1 count
                    count++;
                    //incrementamos en 1 la cantidad de ckbx seleccionados
                    countSelectCkbx++;
                }else{
                    //en caso sea el último simplemente se crea el array
                    //con posición 0 (será 0 ya que si el último está seleccionado, los demás se desmarcan)
                    accionesArray[0] = $(elemento).val();
                    //incrementamos en 1 la cantidad de ckbx seleccionados
                    countSelectCkbx++;
                }
            
            }
        });

        if(countSelectCkbx ==0){
            //si no se ha incrementado la cantidad de ckbx seleccionado
            //retornamos 0 para pedir que seleccione almenos 1 opción
            return 0;
        }else{
            //retornamos el arreglo
            return accionesArray;
        }

    }

    /* esta función recorre todos los chekbox con clase .ckbMenu
    crea un array con cada valor seleccionado y lo retorna  */
    function generarArrayMenu(){
        //creamos el array
        var menuArray = [];
        //creamos contador para ir manejando el número de elementos seleccionados
        var count = parseInt(0);
        //creamos una variable para controlar que se seleccione almenos un chekbox
        var countSelectCkbx = parseInt(0);
        //recorremos y verificamos si almenos un ckbx de menu está seleccionado
        $(".ckbMenu:checkbox").each(function(index, elemento){
            if($(elemento).is(":checked")){
                //si está seleccionado el elemento actual del recorrido, lo anexamos al array
                menuArray[count] = $(elemento).val();
                //incrementamos count y cantidad de chekbox seleccionados
                count++;
                countSelectCkbx++;
            }
        });

        if(countSelectCkbx==0){
            return 0;
        }else{
            //retornamos el arreglo
            return menuArray;
        }

    }

    /*esta función solicita la carga de roles de BD, crea array y lo retorna por función
    callback de ajax  para validar que no se ingrese un rol repetido */
    function validarRolNoRegistrado(callback){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerRoles"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var roles = [];
                for(let i =0; i<r.length; i++){
                    //llenamos arreglo con los datos
                    roles[i] = r[i]["rol_nombre"];
     
                }
                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
                callback(roles);
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y validar los roles ingresados en el sistema'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
        
      
    }

    function validarMenuNoRegistrado(callback){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerMenu"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var menu = [];
                for(let i =0; i<r.length; i++){
                    //llenamos arreglo con los datos
                    menu[i] = r[i]["nombre_menu"];
     
                }
                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
                callback(menu);
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y validar los roles ingresados en el sistema'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
        
      
    }

    //esta función obtiene una cadena string, convierte su primer letra a mayuscula
    //y retorna el nuevo valor
    function convertirPrimerLetraMayus(valor){
        var valorLower = valor.toLowerCase();
        var primerCaracter = valorLower.charAt().toUpperCase();
        var restoDeLaCadena = valorLower.substring(1, valor.length);
        var nuevoValor = primerCaracter.concat(restoDeLaCadena);

        return nuevoValor;
    }
});
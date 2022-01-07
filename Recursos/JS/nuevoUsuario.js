
$(document).ready(function(){
    var editUser = false;
    var correoEdit = null;
    var typingTimer;                //identificador del tiempo
    var doneTypingIntervalCorreo = 3000;  //tiemp en ms (3 seconds)
    var doneTypingIntervalUser = 1000;  //tiemp en ms (3 seconds)
    //llamamos las funciones que deben ejecutarse en la carga de la pag.
    cargarRoles();
    esconderControles();
    cargarUsuario();
    $("#btnGuardar").prop("disabled", true);

    $("body").on("click","#btnEliminar",function(){

        $("#btnEliminar").blur();
        Swal.fire({
            title: '¿Estás seguro de eliminar este usuario?',
            text: "¡No podrás deshacer los cambios!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
          }).then((result) => {
            if (result.isConfirmed) {

                var table = $('#usuarios').DataTable();
                var data = table.row(this).data();
                var id =data["usuario_id"];
                eliminarUsuario(id);
            }
          })
    });

    $("body").on("click","#btnEditar",function(){
        $(location).attr('href', '#inicioForm');
        //instanciamos la tabla
        var table = $("#usuarios").DataTable();
        //obtenemos la info de la linea donde se hizo click
        var data = table.row(this).data();

        //cargamos datos
        $("#txtNombreUser").val(data["usuario_nombre"]);
        $("#txtCorreoUsuario").val(data["correo_electronico"]);
        $('select[name=selectRol]').find('option:contains('+data["rol_nombre"]+')').prop('selected', true);
        $("#txtIdUser").val(data["usuario_id"]);

        //deshabilitamos controles que no deben poder ser editados
        $("#txtIdUser").prop("disabled", true);
        $("#txtPassword1").prop("disabled", true);
        $("#txtPassword2").prop("disabled", true);
        $("#btnNewUser").prop("disabled", true);
        $("#btnGuardar").prop("disabled", false);

        //quitamos el required de contraseñas ya que no pueden ser editadas
        //por ende no pueden ser requeridas si se va a editar la información
        //así mantener el submit del form y validar correo.

        $("#txtPassword1").prop("required", false);
        $("#txtPassword2").prop("requried", false);

        //focus en el nombre del usuario
        $("#txtNombreUser").focus();

        editUser = true;
        correoEdit = data["correo_electronico"].trim().toLowerCase();
    });

    //ocultamos columnas en base al rol
    ocultarColumTableUsuario();

    //al cambio del select rol ocultamos error si está visible
    //y si el valor es diferente a 0 ("default");
    $("#selectRol").change(function(){
        if($("#lbError").is(":visible")){
            if($("#selectRol").val() != 0){
                $("#lbError").hide();
            }
        }
    });

    //cuando deje de escribir el usuario, 0.3 segundos despues validamos 
    //que el valor del correo no se repita
    $("#txtCorreoUsuario").keyup(function(){
        var correoIngresado = $(this).val().trim().toLowerCase();
        
        if($(this).val().trim().toLowerCase() == correoEdit){
            $("#lbError").hide();
        }else{
            clearTimeout(typingTimer);
            if ($('#txtCorreoUsuario').val()) {
                typingTimer = setTimeout( validarCorreoNoRegistrado(function(correos){
                    //recorremos el arreglo y buscamos si el valor ingresado ya existe
                    for(let i=0; i<correos.length; i++){
                        if(correos[i].toLowerCase()==correoIngresado){
                            //si existe, lanzamos error
                            $("#lbError").show();
                            $("#lbError").text("Correo ya ingresado en el sistema, por favor ingresa otro.");
                            $("#txtCorreoUsuario").val("");
                            $("#txtCorreoUsuario").focus();
                            i=correos.length;
                        }else{
                            //sino, ocultamos el error por si está visible
                            $("#lbError").hide();
                        }
                    }
                }), doneTypingIntervalCorreo);
            }
        }

    });

    //cuando deje de escribir el usuario, 0.3 segundos despues validamos 
    //que el valor del usuario id no se repita
    $("#txtIdUser").keyup(function(){
        clearTimeout(typingTimer);
        if ($('#txtIdUser').val()) {
            typingTimer = setTimeout(validarUserIdNoRegistrado, doneTypingIntervalUser);
        }
    });

    //al cambio del password 2 verificamos que sea iguales tanto el 1 como el 2
    $("#txtPassword2").change(function(){
        if($("#txtPassword1").val() != $("#txtPassword2").val()){
            $("#lbError").show();
            $("#lbError").text("Las contraseñas no coinciden.");
            $("#txtPassword1").val("");
            $("#txtPassword1").focus();
            $("#txtPassword2").val("");
           
        }else{
            $("#lbError").hide();
        }
    });
    
    //cuando le da cancelar 
    $("#btnCancelar").on("click", function(){
        $("#lbError").hide();
        //limpiamos form
        $("#frmNuevoUsuario")[0].reset();
        //habilitamos los campos
        $("#txtPassword1").prop("disabled", false);
        $("#txtPassword2").prop("disabled", false);
        $("#txtIdUser").prop("disabled", false);
        $("#btnNewUser").prop("disabled", false);
        
        //deshabilitamos el de guardar
        $("#btnGuardar").prop("disabled", true);
        
        //regresamos el required a los campos password
        $("#txtPassword1").prop("required", true);
        $("#txtPassword2").prop("requried", true);
        
        //limpiamos variables
        editUser = false;
        correoEdit=null;
       
    });
    //cuando hace clic en el btn nuevo usuario
    $("#frmNuevoUsuario").submit(function(e){
        //cancelamos el envio de form
        e.preventDefault();
        //si esta visible el error lanzamos alerta
        if($("#lbError").is(":visible")){
            Swal.fire({
                title: 'Errores detectados',
                text: "Asegurate que la información ingresada no contenga errores.",
                icon: 'warning',
                showConfirmButton: true,
            })
        }else{
            //si se ha hecho click en editar
            if(editUser){
                //preguntamos si quiere editarlo
                Swal.fire({
                    title: '¿Estás seguro de editar este usuario?',
                    text: "¡No podrás deshacer los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, Editar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //en caso confirme, verificamos que este un rol seleccionado
                        if($("#selectRol").val() =="0"){
                            //si no está marcamos error
                            $("#lbError").text("Debes escoger un rol para el usuario");
                            $("#lbError").show();
                        }else{
                            //si selecciono un rol obtenemos valores
                            var nombreUser= $("#txtNombreUser").val();
                            var correoUser = $("#txtCorreoUsuario").val();
                            var idUser = $("#txtIdUser").val();
                            var selectRol = $("#selectRol").val();
                            //enviamos por ajax
                            $.ajax({
                                url:"../controladores/controladorNuevoUsuario.php",
                                method: "post",
                                dataType: "json",
                                data: { "key": "editarUsuario",
                                "nombreUser": nombreUser,
                                "correoUser": correoUser,
                                "idRolUser": selectRol,
                                "idUser": idUser },
                                success: function (r) {
                                    if(r){
                                        Swal.fire({
                                            position: 'bottom-end',
                                            icon: 'success',
                                            title: 'Usuario editado con éxtio',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                        //limpiamos form y recargamos tabla
                                        $("#frmNuevoUsuario")[0].reset();
                                        $('#usuarios').DataTable().ajax.reload();
                                        //habilitamos los campos
                                        $("#txtPassword1").prop("disabled", false);
                                        $("#txtPassword2").prop("disabled", false);
                                        $("#txtIdUser").prop("disabled", false);
                                        $("#btnNewUser").prop("disabled", false);

                                        //deshabilitamos el de guardar
                                        $("#btnGuardar").prop("disabled", true);

                                        //regresamos el required a los campos password
                                        $("#txtPassword1").prop("required", true);
                                        $("#txtPassword2").prop("requried", true);
                                        //limpiamos variables
                                        editUser = false;
                                        correoEdit=null;
                                    }else{
                                        // console.log(r);
                                        Swal.fire({
                                            position: 'bottom-end',
                                            icon: 'error',
                                            title: 'Usuario no editado',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                    
                                },
                                error: function (r) {
                                    console.log(r.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Problemas de comunicación",
                                        text: 'Parece tenemos problemas para comunicarnos con los servidores y editar el usuario'
                                        +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                        showConfirmButton: true
                                    })
                                }
                            });
                        }       
                    }
                })
            }else{
                //si no se ha hecho click en editar evaluamos que el rol haya sido seleccionado
                if($("#selectRol").val() =="0"){
                    //si no ha cambiado valor al default mandamos error
                    $("#lbError").text("Debes escoger un rol para el usuario");
                    $("#lbError").show();
                }else{
                    //obtenemos los datos del form
                    var data = $("#frmNuevoUsuario").serialize();
                    //mandamos por ajax
                    $.ajax({
                        url:"../controladores/controladorNuevoUsuario.php",
                        method: "post",
                        dataType: "json",
                        data: { "key": "insertarUsuario","data": data },
                        success: function (r) {
                            if(r){
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'success',
                                    title: 'Usuario creado con éxtio',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                //limpiamos y recargamos tabla
                                $("#frmNuevoUsuario")[0].reset();
                                $('#usuarios').DataTable().ajax.reload();
                            }else{
                               // console.log(r);
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'error',
                                    title: 'Usuario no insertado',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                            
                        },
                        error: function (r) {
                            Swal.fire({
                                icon: 'error',
                                title: "Problemas de comunicación",
                                text: 'Parece tenemos problemas para comunicarnos con los servidores e insertar el usuario'
                                +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                showConfirmButton: true
                            })
                        }
                    });
                }
            }
        }
        
    });

    //función que solicita la carga de roles y setea el select en la vista
    function cargarRoles(){
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "getRoles" },
            success: function (r) {
                for(let i=0; i<r.length; i++){
                    var option = '<option value="'+r[i]["id_rol"]+'">'+r[i]["rol_nombre"]+'</option>';
                    $("#selectRol").append(option);
                }
            },
            error: function (r) {
                console.log(r);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar los roles en el menú despegable'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
    }
    //función que esconde controles que no deben ser visibles en la carga de la pag.
    function esconderControles(){
        $("#lbError").hide();
    }

    //función que solicita por ajax la carga de usuarios
    //y carga la tabla automáticamente con DataTable
    function  cargarUsuario() {
        $.noConflict(true);
        $('#usuarios').DataTable({
                "ajax":{
                    "url": "../controladores/controladorNuevoUsuario.php",
                    "method": "post",
                    "dataType": "json",
                    "data": { "key": "getUsuarios" },
                    "dataSrc": ""
                },
                "columns": [
                    {
                        data: "usuario_id",
                        className: "usuarioId"
                    },
                    {
                        data: "usuario_nombre",
                        className: "nombreUsuario"
                    },
                    {
                        data: "usuario_fecha",
                        className: "usuarioFecha"
                    },
                    {
                        data:"correo_electronico",
                        className: "usuarioCorreo"
                    },
                    {
                        data: "rol_nombre",
                        className: "usuarioRol"
                    },
                    {
                        data: "usuario_responsable",
                        className: "usuarioResponsable"
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: '<button id="btnEditar" class="btn btn-warning noHover">Editar</button>'
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: '<button id="btnEliminar" class="btn btn-danger noHover">Eliminar</button>'
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

    //función que envía ID para eliminar el registro
    function eliminarUsuario(id){
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "eliminarUsuario","id": id },
            success: function (r) {
                switch(r){
                    case "nullId":
                        Swal.fire({
                            icon: 'error',
                            title: "Usuario no encontrado",
                            text: 'El id del usuario no se encuentra en la base de datos'+
                            ' asegúrate de que su id sea correcto e intenta de nuevo, si el problema'+
                            ' persiste contacta con tu administrador o personal de TI.',
                            showConfirmButton: true
                        })
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    case "userSesOn":
                        Swal.fire({
                            icon: 'error',
                            title: "Usuario con sesión activa",
                            text: 'No se puede eliminar el usuario debido a que tiene una sesión activa en estos momentos, por favor'
                            +' intenta cuando no este on-line, sí crees que se trata de algún problema por favor contacta a tu administrador o personal de TI.',
                            showConfirmButton: true
                        })
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    case true:
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Usuario eliminado con éxtio',
                            showConfirmButton: false,
                            timer: 1500
                          })
                        $("#frmNuevoUsuario")[0].reset();
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y eliminar el usuario'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }
    
    //función que oculta columnas de DataTable según el rol que inicia sesión
    function ocultarColumTableUsuario(){
        //creamos instancia a las tablas para acceder a sus columnas
        var dt= $('#usuarios').DataTable();

        //ocultamos columnas de inicio para mostrarlas según sus permisos
        dt.columns(6).visible(false);
        dt.columns(7).visible(false);
 
        //solicitamos acciones del rol del usuario que inicio sesión
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "soliAccRol","idRol": idRol},
            success: function (r) {
                //validamos cada acción y vamos mostrando sus columnas.
                for(let i=0; i<r.length; i++){
                    switch(r[i]["nombre_accion"].toLowerCase()){
                        case "eliminar":
                            dt.columns(7).visible(true);
                        break;
                        case "editar":
                            dt.columns(6).visible(true);
                        break;
                    }
                   
                }
                
            },
            error: function (r) {
                //console.log(r.responseText);
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

    //función que valida que el correo no este repetido
    function validarCorreoNoRegistrado(callback){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "getUsuarios"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var correos = [];
                for(let i =0; i<r.length; i++){
                    //llenamos arreglo con los datos
                    correos[i] = r[i]["correo_electronico"];
     
                }
                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
                callback(correos);
            },
            error: function (r) {
                //console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y validar que el correo ingresado no se encuentre en el sistema'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
        
      
    }

    //función que valida que el id del usuario no esté registrado
    function validarUserIdNoRegistrado(){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "getUsuarios"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var userId = $("#txtIdUser").val().toLowerCase();
                for(let i =0; i<r.length; i++){
                   if(userId.trim()== r[i]["usuario_id"].trim().toLowerCase()){
                    //si existe, lanzamos error
                    $("#lbError").show();
                    $("#lbError").text("Usuario ya ingresado en el sistema, por favor ingresa otro.");
                    $("#txtIdUser").val("");
                    $("#txtIdUser").focus();
                    i=r.length;
                   }else{
                    //si no existe ocultamos error
                    $("#lbError").hide();
                   }
                }
    
            },
            error: function (r) {
                //console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y validar que el usuario ID ingresado no se encuentre en el sistema'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
        
      
    }


});

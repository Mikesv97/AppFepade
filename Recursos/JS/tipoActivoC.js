$.noConflict();
jQuery(document).ready(function ($) {
    var error = null;
    var editTipAct = false;
    var nameEditTipAct = null;
    //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
    $('#btnInsertar').attr('disabled', false);
    $('#btnModificar').attr('disabled', true);
    //QUITANDO READONLY AL INPUT DEL ID PARA QUE SE PUEDE ESCRIBIR
    $('#tipoActivoId').attr('readonly', false);
    $("#tblTipoActivo tr td.cargarEliminar").hide();
    $("#usuarioId").prop("readonly", true);
    $("#lbError").hide();
    
    //MOSTRAR TABLA DE TIPO ACTIVO
    $('#tblTipoActivo').DataTable({
        "ajax": {
            "url": "../Controladores/tipoActivoControlador.php",
            "method": "post",
            "dataType": "json",
            "data": { "key": "mostrar" },
            "dataSrc": ""
        },
        "columns": [
            {
                data: "tipo_activo_id",
                className: "tipo_activo_id"
            },
            {
                data: "tipo_activo_nombre",
                className: "tipo_activo_nombre"
            },
            {
                data: "usuario_id",
                className: "usuario_id"
            },
            {
                data: "fecha",
                className: "fecha"
            },
            {
                data: null,
                className: "center cargarModificar",
                defaultContent: '<button id="btnEditar" type="button" class="btn btn-facebook btnEditarResp"><i class="fa fa-pencil-square-o"></i></button>'
            },
            {
                data: null,
                className: "center cargarEliminar",
                defaultContent: '<button type="button" class="btn btn-pinterest btnEliminar" id="btnEliminarResp"><i class="fa fa-trash-o"></i></button>'
            },
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

    //al cambio de input id tipo activo evaluamos que no se repita 
    $("#tipoActivoId").change(function(){
        //si se ingresa otro ID, se oculta el error
        if(error != $(this).val()){
            $("#lbError").hide();
             error=null;
        }
        validarIdTipoActNoRegistrado();
    });

    //al cambio de input id tipo activo evaluamos que no se repita
    $("#tipoActivoNombre").change(function(){
        if(editTipAct){
            if($(this).val() == nameEditTipAct){
                $("#lbError").hide();
                error=null;
            }else{
                validarNombreTipoActNoRegistrado();
            }
        }else{

            validarNombreTipoActNoRegistrado();
        } 

        //si se ingresa otro nombre, se oculta el error
        if(error != $(this).val().toLowerCase()){
            $("#lbError").hide();
            error=null;
        }
        

    });

    $("#tipoActivoNombre").on("click", function(){
        $("#lbError").hide();
    })

    //ocultamos columnas según rol
    ocultarColumTableTipoAct();

    //CUANDO SE INSERTA UN NUEVO TIPO ACTIVO
    $('#frmTipoActivo').submit(function (e) {

        e.preventDefault();
        if($("#lbError").is(":visible")){
            Swal.fire({
                title: 'Errores detectados',
                text: "Asegurate que la información ingresada no contenga errores.",
                icon: 'warning',
                showConfirmButton: true,
            })
        }else{
            Swal.fire({
                title: 'Ingresar tipo de activo al sistema',
                text: "Porfavor confirma para ingresar el tipo de activo al sistema",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
    
                    var formData = new FormData($('#frmTipoActivo')[0]);
                    formData.append("key", "insertar");
                    $.ajax({
                        type: 'POST',
                        url: "../Controladores/tipoActivoControlador.php",
                        dataType: "json",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (r) {
                            console.log(r);
                            switch (r) {
                                case "InsertadoTipoActivo":
                                    Swal.fire(
                                        'Tipo de activo ingresado!',
                                        'El tipo de activo ha sido ingresado al sistema',
                                        'success'
                                    )
                                    $("#frmTipoActivo")[0].reset();
                                    $('#tblTipoActivo').DataTable().ajax.reload();
                                    error=null;
                                    break;
                                case "FailTipoActivo":
                                    Swal.fire({
                                        title: '¡Problemas técnicos!',
                                        text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta el tipo de activo'
                                            + ' si el problema persiste contacta a tu administrador o soporte IT.',
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar',
                                    })
                                    break;
                            }
                        },
                        error: function (r) {
                            console.log(r);
                        }
                    });
    
                }
            })
        }
        
    });

    //CUANDO SE ELIMINA UN TIPO DE ACTIVO
    $('#tblTipoActivo tbody').on('click', '.cargarEliminar', function () {
        $("#tipoActivoId").prop("readonly", true);
        //GUARDANDO LA INFORMACION DE LA TABLA EN LA VARIABLE DATA
        var table = $('#tblTipoActivo').DataTable();
        var data = table.row(this).data();

        //LLENANDO LOS INPUT CON LA INFORMACION DEL TIPO ACTIVO QUE SE QUIERE ELIMINAR
        cargarTipoActivo(
            data['tipo_activo_id'],
            data['tipo_activo_nombre'],
            data['usuario_id'],
        );

        Swal.fire({
            title: '¿Estás seguro de eliminar este tipo de activo?',
            text: "¡No podrás deshacer los cambios!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#frmTipoActivo')[0]);
                formData.append("key", "eliminar");
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/tipoActivoControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "DeleteTipoActivo":
                                Swal.fire(
                                    'Tipo de activo eliminado!',
                                    'El tipo de activo ha sido eliminado del sistema',
                                    'success'
                                )
                                $("#frmTipoActivo")[0].reset();
                                $('#tblTipoActivo').DataTable().ajax.reload();
                                $("#tipoActivoId").prop("readonly", false);
                                break;
                            case "FailTipoActivo":
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para eliminar el tipo de activo del sistema'
                                        + ' si el problema persiste contacta a tu administrador o soporte IT.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar',
                                })
                                break;
                        }
                    },
                    error: function (r) {
                        console.log(r);
                        Swal.fire({
                            title: '¡Problemas técnicos!',
                            text: '¡Vaya! Parece que tenemos dificultades técnicas para eliminar el tipo de activo del sistema'
                                + ' si el problema persiste contacta a tu administrador o soporte IT.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                        })
                    }
                });

            } else if (result.isDismissed) {
                //SI EL USUARIO PRESIONA EL BOTON CANCELAR SE LIMPIA EL FORMULARIO
                $("#frmTipoActivo")[0].reset();
                //QUITANDO READONLY AL INPUT DEL ID PARA QUE SE PUEDE ESCRIBIR
                $('#tipoActivoId').attr('readonly', false);
                $("#tipoActivoId").prop("readonly", false);
            }
        })
    });

    //CUANDO LE DAL AL ICONO DE EDITAR CARGA LOS INPUT CON LOS DATOS DEL RESPONSABLE SELECIONADO
    $('#tblTipoActivo tbody').on('click', '.cargarModificar', function () {
        $("#tipoActivoId").prop("readonly", true);
        $("#lbError").hide();
        //GUARDANDO LA INFORMACION DE LA TABLA EN LA VARIABLE DATA
        var table = $('#tblTipoActivo').DataTable();
        var data = table.row(this).data();

        //LLENANDO LOS INPUT CON LA INFORMACION DEL TIPO ACTIVO QUE SE QUIERE ELIMINAR
        cargarTipoActivo(
            data['tipo_activo_id'].trim(),
            data['tipo_activo_nombre'].trim(),
            data['usuario_id'].trim(),
        );

        //ENVIANDO AL INICIO DEL FORMULARIO CUANDO EL USUARIO DE CLICK EN EDITAR
        $(location).attr('href', '#inicioFormTipoAct');

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', false);
        //AGRENGADO READONLY AL INPUT DEL ID PARA QUE NO PUEDAN MODIFICARLO
        $('#tipoActivoId').attr('readonly', true);
        editTipAct=true;
        nameEditTipAct =data["tipo_activo_nombre"].trim();

    });

    //CUANDO LE DAN AL BOTON MODIFICAR DEL FORMULARIO SE MODIFICAN LOS DATOS EN LA BASE DE DATOS
    $('#btnModificar').on('click', function () {


            if($("#lbError").is(":visible")){
                Swal.fire({
                    title: 'Errores detectados',
                    text: "Asegurate que la información ingresada no contenga errores.",
                    icon: 'warning',
                    showConfirmButton: true,
                })
            }else{
                Swal.fire({
                    title: 'Modificar tipo de activo en el sistema',
                    text: "Porfavor confirma para modificar el tipo de activo en el sistema",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
        
                        var formData = new FormData($('#frmTipoActivo')[0]);
                        formData.append("key", "modificar");
                        $.ajax({
                            type: 'POST',
                            url: "../Controladores/tipoActivoControlador.php",
                            dataType: "json",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (r) {
                                console.log(r);
                                switch (r) {
                                    case "ModificadoTipoActivo":
                                        Swal.fire(
                                            'Tipo de activo modificado!',
                                            'El tipo de activo ha sido modificado en el sistema',
                                            'success'
                                        )
                                        $("#frmTipoActivo")[0].reset();
                                        $('#tblTipoActivo').DataTable().ajax.reload();
        
                                        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
                                        $('#btnInsertar').attr('disabled', false);
                                        $('#btnModificar').attr('disabled', true);
                                        $("#tipoActivoId").prop("readonly", false);
                                        error=null;
                                        editTipAct=false;
                                        nameEditTipAct=null;
        
                                        break;
                                    case "FailTipoActivo":
                                        Swal.fire({
                                            title: '¡Problemas técnicos!',
                                            text: '¡Vaya! Parece que tenemos dificultades técnicas para modificar el tipo de activo'
                                                + ' si el problema persiste contacta a tu administrador o soporte IT.',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar',
                                        })
                                        break;
                                }
                            },
                            error: function (r) {
                                console.log(r);
                            }
                        });
        
                    }
                })
            }
        
        
        
    });

    //CUANDO LE DAN CENCELAR SE LIMPIA EL FORMULARIO Y SE HABILITAN O DESABILITAN LOS BOTONES
    $('#btnCancelar').on('click', function () {

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', false);
        $('#btnModificar').attr('disabled', true);
        //QUITANDO READONLY AL INPUT DEL ID PARA QUE SE PUEDE ESCRIBIR
        $('#tipoActivoId').attr('readonly', false);
        //LIMPIADO EL FORMULARIO
        $("#frmTipoActivo")[0].reset();
    });

    //FUNCION PARA CARGAR LOS INPUT DEL DESPONSABLE SELECIONADO
    function cargarTipoActivo(tipoActivoId, tipoActivoNombre, usuarioId) {
        $('input[name=tipoActivoId]').val(tipoActivoId);
        $('input[name=tipoActivoNombre]').val(tipoActivoNombre);
        $('input[name=usuarioId]').val(usuarioId);
    }

    
    //función que oculta columnas de DataTable según el rol que inicia sesión
    function ocultarColumTableTipoAct(){
        //creamos instancia a las tablas para acceder a sus columnas
        var dt= $('#tblTipoActivo').DataTable();
        

        //ocultamos columnas de inicio para mostrarlas según sus permisos
        dt.columns(4).visible(false);
        dt.columns(5).visible(false);
 
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
                        case "editar":
                            dt.columns(4).visible(true);
                        break;
                        case "eliminar":
                            dt.columns(5).visible(true);
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

    //función que valida que el id del usuario no esté registrado
    function validarIdTipoActNoRegistrado(){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/tipoActivoControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "mostrar"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var tipoActId = $("#tipoActivoId").val();
                for(let i =0; i<r.length; i++){
                    if(tipoActId== r[i]["tipo_activo_id"]){
                                               //si existe, lanzamos error
                    $("#lbError").show();
                    $("#lbError").text("El id ingresado para este activo ya está registrado, intenta con otro.");
                    $("#tipoActivoId").val("");
                    $("#tipoActivoId").focus();
                    i=r.length;
                    error = tipoActId;
                    }
                }
                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
        
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

    //función que valida que el id del usuario no esté registrado
    function validarNombreTipoActNoRegistrado(){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/tipoActivoControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "mostrar"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var tipoActNombre = $("#tipoActivoNombre").val().toLowerCase().trim();
                //en caso no este editar activo solo vemos que el valor no se repita
                for(let i =0; i<r.length; i++){
                    if(tipoActNombre== r[i]["tipo_activo_nombre"].trim().toLowerCase()){
                    //si existe, lanzamos error
                    $("#lbError").show();
                    $("#lbError").text("El nombre del activo ingresado ya está registrado, intenta con otro.");
                    $("#tipoActivoNombre").val("");
                    $("#tipoActivoNombre").focus();
                    i=r.length;
                    error = tipoActNombre;
                    }
                }

                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
        
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
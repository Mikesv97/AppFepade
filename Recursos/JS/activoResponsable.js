$.noConflict();
jQuery(document).ready(function ($) {
    var codRespEdit = null;
    var typingTimer;                //identificador del tiempo
    var doneTypingInterval = 600;  //tiemp en ms (0.6 seconds)
    //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
    $('#btnInsertar').attr('disabled', false);
    $('#btnModificar').attr('disabled', true);

    //MOSTRAR TABLA DE RESPONSABLESS
    $('#tblResponsables').DataTable({
        "ajax": {
            "url": "../Controladores/activoResponControlador.php",
            "method": "post",
            "dataType": "json",
            "data": { "key": "mostrar" },
            "dataSrc": ""
        },
        "columns": [
            {
                data: "Responsable_codigo",
                className: "Responsable_codigo"
            },
            {
                data: "Codigo_responsable",
                className: "Codigo_responsable"
            },
            {
                data: "Nombre_Responsable",
                className: "Nombre_Responsable"
            },
            {
                data: "Estado",
                className: "Estado"
            },
            {
                data: null,
                className: "center cargarModificar",
                defaultContent: '<button id="btnEditar" type="button" class="btn btn-facebook btnEditar"><i class="fa fa-pencil-square-o"></i></button>'
            },
            {
                data: null,
                className: "center cargarEliminar",
                defaultContent: '<button type="button" class="btn btn-pinterest btnEliminar" id="btnEliminar"><i class="fa fa-trash-o"></i></button>'
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

    //ocultamos columnas en base al rol
    ocultarColumTableActResp();
    //CUANDO SE INSERTA UN NUEVO RESPONSABLE
    $('#frmResponsable').submit(function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Ingresar responsable al sistema',
            text: "Porfavor confirma para ingresar el nuevo responsable al sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#frmResponsable')[0]);
                formData.append("key", "insertar");
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/activoResponControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "InsertadoResponsable":
                                Swal.fire(
                                    'Responsable ingresado!',
                                    'El reponsable ha sido ingresado al sistema',
                                    'success'
                                )
                                $("#frmResponsable")[0].reset();
                                $('#tblResponsables').DataTable().ajax.reload();
                                break;
                            case "FailResponsable":
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta al nuevo responsable'
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
    });

    //cuando deje de escribir el usuario esperamo x segundos
    //validamos que el valor no este repetido
    $("#CodigoResponsable").keyup(function(){
        var codIngresado = $(this).val().trim().toLowerCase();

        if(codIngresado==codRespEdit){
            $("#lbError").hide();
        }else{
            clearTimeout(typingTimer);
            if ($('#CodigoResponsable').val()) {
                typingTimer = setTimeout(validarCodResptNoRegistrado, doneTypingInterval);
            }    
        }
 
    });

    //CUANDO SE ELIMINA UN RESPONSABLE
    $('#tblResponsables tbody').on('click', '.cargarEliminar', function () {

        //GUARDANDO LA INFORMACION DE LA TABLA EN LA VARIABLE DATA
        var table = $('#tblResponsables').DataTable();
        var data = table.row(this).data();

        //LLENANDO LOS INPUT CON LA INFORMACION DEL RESPONSABLE QUE SE QUIERE ELIMINAR
        cargarResponsable(
            data['Responsable_codigo'],
            data['Codigo_responsable'],
            data['Nombre_Responsable'],
            data['Estado']
        );

        Swal.fire({
            title: '¿Estás seguro de eliminar este responsable?',
            text: "¡No podrás deshacer los cambios!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#frmResponsable')[0]);
                formData.append("key", "eliminar");
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/activoResponControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "DeleteResponsable":
                                Swal.fire(
                                    'Responsable eliminado!',
                                    'El responsable ha sido eliminado del sistema',
                                    'success'
                                )
                                $("#frmResponsable")[0].reset();
                                $('#tblResponsables').DataTable().ajax.reload();
                                break;
                            case "FailResponsable":
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para eliminar el responsable del sistema'
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

            } else if (result.isDismissed) {
                //SI EL USUARIO PRESIONA EL BOTON CANCELAR SE LIMPIA EL FORMULARIO
                $("#frmResponsable")[0].reset();
            }
        })
    });

    //CUANDO LE DAL AL ICONO DE EDITAR CARGA LOS INPUT CON LOS DATOS DEL RESPONSABLE SELECIONADO
    $('#tblResponsables tbody').on('click', '.cargarModificar', function () {
        //GUARDANDO LA INFORMACION DE LA TABLA EN LA VARIABLE DATA
        var table = $('#tblResponsables').DataTable();
        var data = table.row(this).data();

        //LLENANDO LOS INPUT CON LA INFORMACION DEL RESPONSABLE QUE SE QUIERE ELIMINAR
        cargarResponsable(
            data['Responsable_codigo'],
            data['Codigo_responsable'],
            data['Nombre_Responsable'],
            data['Estado']
        );

        //ENVIANDO AL INICIO DEL FORMULARIO CUANDO EL USUARIO DE CLICK EN EDITAR
        $(location).attr('href', '#inicioFormRespon');

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', false);
        $("#CodigoResponsable").prop("readonly",true);
        codRespEdit = data["Codigo_responsable"].trim().toLowerCase();

    });

    //CUANDO LE DAN CENCELAR SE LIMPIA EL FORMULARIO Y SE HABILITAN O DESABILITAN LOS BOTONES
    $('#btnCancelar').on('click', function () {

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', false);
        $('#btnModificar').attr('disabled', true);

        $("#frmResponsable")[0].reset();
    });

    //CUANDO LE DAN AL BOTON MODIFICAR DEL FORMULARIO SE MODIFICAN LOS DATOS EN LA BASE DE DATOS
    $('#btnModificar').on('click', function () {
        Swal.fire({
            title: 'Modificar responsable en el sistema',
            text: "Porfavor confirma para modificar al responsable en el sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#frmResponsable')[0]);
                formData.append("key", "modificar");
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/activoResponControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "ModificadoResponsable":
                                Swal.fire(
                                    'Responsable modificado!',
                                    'El reponsable ha sido modificado en el sistema',
                                    'success'
                                )
                                $("#frmResponsable")[0].reset();
                                $('#tblResponsables').DataTable().ajax.reload();

                                //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
                                $('#btnInsertar').attr('disabled', false);
                                $('#btnModificar').attr('disabled', true);
                                $("#CodigoResponsable").prop("readonly",false);
                                codRespEdit=null;
                                

                                break;
                            case "FailResponsable":
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para modificar al responsable'
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
    });

    //FUNCION PARA CARGAR LOS INPUT DEL DESPONSABLE SELECIONADO
    function cargarResponsable(ResponsableCodigo, CodigoResponsable, NombreResponsable, Estado) {
        $('input[name=ResponsableCodigo]').val(ResponsableCodigo);
        $('input[name=CodigoResponsable]').val(CodigoResponsable);
        $('input[name=NombreResponsable]').val(NombreResponsable);
        $('#Estado option[value=' + Estado + ']').prop('selected', true);
    }

    //función que oculta columnas de DataTable según el rol que inicia sesión
    function ocultarColumTableActResp(){
        //creamos instancia a las tablas para acceder a sus columnas
        var dt= $('#tblResponsables').DataTable();

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
        function validarCodResptNoRegistrado(){
            //pasamos un parametro que serpa una función en este caso callback
            $.ajax({
                url:"../controladores/activoResponControlador.php",
                method: "post",
                dataType: "json",
                data: { "key": "mostrar"},
                success: function (r) {
                    //obtenemos valor del input, pasamos a miniscula, y quitamos espacios
                    var tipoActNombre = $("#CodigoResponsable").val().toLowerCase().trim();
                   
                    //recorremos la respuesta del server
                    for(let i =0; i<r.length; i++){
                        if(tipoActNombre== r[i]["Codigo_responsable"].trim().toLowerCase()){
                            //si existe, lanzamos error
                            $("#lbError").show();
                            $("#lbError").text("El código de responsable ya está registrado, intenta con otro.");
                            $("#CodigoResponsable").val("");
                            $("#CodigoResponsable").focus();
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
                        text: 'Parece tenemos problemas para comunicarnos con los servidores y validar que el código de responsable no se encuentre en el sistema'
                        +' por favor verifica tu conexión de internet e intenta de nuevo.',
                        showConfirmButton: true
                    })
                }
            });
                
              
        }

});
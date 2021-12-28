$.noConflict();
jQuery(document).ready(function ($) {

    //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
    $('#btnInsertar').attr('disabled', false);
    $('#btnModificar').attr('disabled', true);
    //QUITANDO READONLY AL INPUT DEL ID PARA QUE SE PUEDE ESCRIBIR
    $('#tipoActivoId').attr('readonly', false);
    $("#tblTipoActivo tr td.cargarEliminar").hide();
    
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


    //CUANDO SE INSERTA UN NUEVO TIPO ACTIVO
    $('#frmTipoActivo').submit(function (e) {

        e.preventDefault();
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
    });

    //CUANDO SE ELIMINA UN TIPO DE ACTIVO
    $('#tblTipoActivo tbody').on('click', '.cargarEliminar', function () {

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
                    }
                });

            } else if (result.isDismissed) {
                //SI EL USUARIO PRESIONA EL BOTON CANCELAR SE LIMPIA EL FORMULARIO
                $("#frmTipoActivo")[0].reset();
                //QUITANDO READONLY AL INPUT DEL ID PARA QUE SE PUEDE ESCRIBIR
                $('#tipoActivoId').attr('readonly', false);
            }
        })
    });

    //CUANDO LE DAL AL ICONO DE EDITAR CARGA LOS INPUT CON LOS DATOS DEL RESPONSABLE SELECIONADO
    $('#tblTipoActivo tbody').on('click', '.cargarModificar', function () {
        //GUARDANDO LA INFORMACION DE LA TABLA EN LA VARIABLE DATA
        var table = $('#tblTipoActivo').DataTable();
        var data = table.row(this).data();

        //LLENANDO LOS INPUT CON LA INFORMACION DEL TIPO ACTIVO QUE SE QUIERE ELIMINAR
        cargarTipoActivo(
            data['tipo_activo_id'],
            data['tipo_activo_nombre'],
            data['usuario_id'],
        );

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', false);
        //AGRENGADO READONLY AL INPUT DEL ID PARA QUE NO PUEDAN MODIFICARLO
        $('#tipoActivoId').attr('readonly', true);

    });

    //CUANDO LE DAN AL BOTON MODIFICAR DEL FORMULARIO SE MODIFICAN LOS DATOS EN LA BASE DE DATOS
    $('#btnModificar').on('click', function () {
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
    

});
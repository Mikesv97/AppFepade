$.noConflict();
jQuery(document).ready(function ($) {

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

    //CUANDO SE INSERTA UN NUEVO RESPONSABLE
    $('#frmResponsable').submit(function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Ingresar responsable al sistema',
            text: "Porfavor confirma para ingresar la nuevo responsable al sistema",
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

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', false);

    });

    //CUANDO LE DAN CENCELAR SE LIMPIA EL FORMULARIO Y SE HABILITAN O DESABILITAN LOS BOTONES
    $('#btnCancelar').on('click', function () {

        //HABILITANDO Y DESABILITANDO EL BOTON INSERTAR Y MODIFICAR
        $('#btnInsertar').attr('disabled', false);
        $('#btnModificar').attr('disabled', true);

        $("#frmResponsable")[0].reset();
    });

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

});
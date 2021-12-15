$.noConflict();
jQuery(document).ready(function ($) {
    desabilitarInputPc(false);
    desabilitarInputProyector(true);
    desabilitarInputImpresora(true);
    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK ELIMINADO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO ACTIVO
    var eliminado = 0;
    $('#ActivoEliminado').change(function () {
        if (eliminado == 0) {
            eliminado = 1;
        } else {
            eliminado = 0;
        }
    })

    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK INACTIVO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO ACTIVO
    var inactivo = 1;
    $('#estado').change(function () {
        if (inactivo == 1) {
            inactivo = 0;
        } else {
            inactivo = 1;
        }
    })

    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK INACTIVO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO HISTORICOM
    var inactivoH = 1;
    $('#estadoH').change(function () {
        if (inactivoH == 1) {
            inactivoH = 0;
        } else {
            inactivoH = 1;
        }
    })

    //DESABILITANDO BOTON INSERTAR CUANDO SE CARGA LA PAGINA
    $('#btnInsertar').attr('disabled', true);
    $('#btnMostrarHistorial').attr('disabled', true);

    //INVOCANDO FUNCION QUE DESABILITA LOS CONTROLES DEL FORMULARIO
    blockControl(true);

    //EVENTO CLICK QUE ACTIVO O DESABILITA CONTROLES DEL FORMULARIO
    $('#verFormulario').on('click', function () {
        $('#activoHistorial').dataTable().fnDestroy();
        blockControl(false);
        $('#btnInsertar').attr('disabled', false);
        $('#btnMostrarHistorial').attr('disabled', true);
        $("#formActivo")[0].reset();
        $('#ActivoEliminado').attr('checked', false);
        $('#estado').attr('checked', false);
        $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/nodisponible.jpg');

    });

    //EVENTO CHANGE QUE MUESTRA LA IMAGEN QUE SE AGREGAR EN EL INPUT FILE
    //PARA PREVISUALIZAR LA IMAGEN ANTES DE INSERTARLA
    $('#Imagen').change(function () {
        var file = this.files;
        var element = file[0];
        var imgTemp = URL.createObjectURL(element);
        $('#mostrarImagen').attr('src', imgTemp);
    });
    //CUANDO SE INSERTA UN ACTIVO FIJO
    $('#formActivo').submit(function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Ingresar activo al sistema',
            text: "Porfavor confirma para ingresar el activo al sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ingresasr'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formActivo')[0]);
                formData.append("key", "insertar");
                formData.append("tipoActivo", $('#ActivoTipo').val());
                formData.append("activoDel", eliminado);
                formData.append("activoInac", inactivo);
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/activoFijoControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "Insertado":
                                Swal.fire(
                                    'Activo ingresado!',
                                    'El activo a sido ingresado al sistema',
                                    'success'
                                )
                                $("#formActivo")[0].reset();
                                $('#activoInformacion').DataTable().ajax.reload();
                                $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/nodisponible.jpg');
                                break;
                            case "FailActiveEspe":
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta la especificacion del activo'
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

    //CUANDO SE INSERTA EN HISTICO ACTIVO
    $('#formHistorico').submit(function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Ingresar historico al sistema',
            text: "Porfavor confirma para ingresar al historico",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ingresasr'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formHistorico')[0]);
                formData.append("key", "insertarHistorial");
                formData.append("activoInacH", inactivoH);
                $.ajax({
                    type: 'POST',
                    url: "../Controladores/activoFijoControlador.php",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (r) {
                        console.log(r);
                        switch (r) {
                            case "Insertado":
                                Swal.fire(
                                    'Activo ingresado!',
                                    'El activo a sido ingresado al sistema',
                                    'success'
                                )
                                $("#formHistorico")[0].reset();
                                $('#historial').DataTable().ajax.reload();
                                $('#activoHistorial').DataTable().ajax.reload();
                                break;
                            case "FailHistorico":
                                console.log(r);
                                Swal.fire({
                                    title: '¡Problemas técnicos!',
                                    text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta la especificacion del activo'
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

    //EN LA CARGA DE LA PAGINA SE CARGA LA TABLA DE ACTIVO FIJO MEDIANTE 
    //AJAX CON DATATABLE
    $('#activoInformacion').DataTable({
        "ajax": {
            "url": "../Controladores/activoFijoControlador.php",
            "method": "post",
            "dataType": "json",
            "data": { "key": "getInfoActivo" },
            "dataSrc": ""
        },
        "columns": [
            {
                data: "Activo_id",
                className: "Activo_id"
            },
            {
                data: "Activo_referencia",
                className: "Activo_referencia"
            },
            {
                data: "PartidaCta",
                className: "PartidaCta"
            },
            {
                data: "Empresa_id",
                className: "Empresa_id"
            },
            {
                data: "numero_serie",
                className: "numero_serie"
            },
            {
                data: "Activo_fecha_adq",
                className: "Activo_fecha_adq"
            },
            {
                data: "Activo_fecha_caduc",
                className: "Activo_fecha_caduc"
            },
            {
                data: "Activo_factura",
                className: "Activo_factura"
            },
            {
                data: "tipo_activo_nombre",
                className: "tipo_activo_nombre"
            },
            {
                data: "IP",
                className: "IP"
            },
            {
                data: "Usuario",
                className: "Usuario"
            },
            {
                data: "Modelo",
                className: "Modelo"
            },
            {
                data: "Estructura1_id",
                className: "Estructura1_id"
            },
            {
                data: "Estructura2_id",
                className: "Estructura2_id"
            },
            {
                data: "Estructura3_id",
                className: "Estructura3_id"
            },
            {
                data: "Activo_descripcion",
                className: "Activo_descripcion"
            },
            {
                data: "Activo_eliminado",
                className: "Activo_eliminado"
            },
            {
                data: null,
                className: "center",
                defaultContent: '<button type="button" class="btn btn-spotify btnMostrar" id="btnMostrar"><i class="fa fa-eye"></i></button> <button type="button" class="btn btn-facebook btnEditar"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="btn btn-pinterest btnEliminar"><i class="fa fa-trash-o"></i></button> '
            },
            {
                data: "Imagen",
                "render": function (data) {
                    return '<img src="../Recursos/Multimedia/Imagenes/Upload/' + data + '" height="100px" width="100px" >';
                }
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

    $('#activoInformacion tbody').on('click', '#btnMostrar', function () {

        //INVOCANDO FUNCION PARA DESABILITAR CONTROLES DEL FORMULARIO
        blockControl(true);

        //REMOVIENTO LA CLASE COLLAPSE PARA QUE AL DARLE CLICK AL ACTIVO SE DESPLIEGUE EL FORM 
        //CON LA INFORMACION
        $('#mostrarFormulario').removeClass('collapse');

        //DESABILITANDO EL BOTON INSERTAR ACTIVO CUANDO EL USUARIO CARGA LA INFORMACION DE UN ACTIVO
        $('#btnInsertar').attr('disabled', true);
        $('#btnMostrarHistorial').attr('disabled', false);

        //ENVIANDO AL INICIO DEL FORMULARIO CUANDO EL USUARIO DE CLICK AL ACTIVO
        $(location).attr('href', '#inicioForm');

        //DESTRUIR EL OBJETO DE LA TABLA ACTIVOHISTORIAL YA INICIALIZADO Y ASI PODER
        //MOSTRAR EL HISTORIAL DE OTRO ACTIVO
        $('#activoHistorial').dataTable().fnDestroy();

        //LA VARIABLE DATA OBTIENE TODO EL CONTENIDO QUE VIENE DE LA FUNCION tablaActivoFijo DE ACTIVOFIJODAO
        var table = $('#activoInformacion').DataTable();
        var data = table.row(this).data();

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ELIMINADO PARA PONER EL CHEKE O QUITARLO
        if (data['Activo_eliminado'] == 1) {
            $('#ActivoEliminado').attr('checked', true);
        } else {
            $('#ActivoEliminado').attr('checked', false);
        }

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 0) {
            $('#estado').attr('checked', true);
        } else {
            $('#estado').attr('checked', false);
        }

        //INVOCANDO FUNCIONES DE tipoActivo.js PARA HABILITAR O DESABILITAR LOS INPUT SEGUN TIPO DE ACTIVO
        if (data['Activo_tipo'] == 1 || data['Activo_tipo'] == 2) {
            desabilitarInputPc(false);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(true);
        } else if (data['Activo_tipo'] == 3) {
            desabilitarInputPc(true)
            desabilitarInputProyector(true)
            desabilitarInputImpresora(false);
        } else if (data['Activo_tipo'] == 4) {
            desabilitarInputPc(true)
            desabilitarInputProyector(false)
            desabilitarInputImpresora(true);
        }

        //MOSTRANDO LA IMAGEN QUE TIENE CADA ACTIVO
        $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/' + data['Imagen']);

        cargarGeneral1(
            data['Activo_referencia'],
            data['PartidaCta'],
            data['Empresa_id'],
            data['numero_serie'],
            data['Activo_id'],
            data['FechaAdquisicion'],
            data['Activo_factura'],
            data['tipo_activo_id'],
            data['IP']
        );

        cargarGeneral2(
            data['Usuario'],
            data['Modelo'],
            data['Estructura1_id'],
            data['Estructura2_id'],
            data['Estructura3_id'],
            data['Activo_descripcion'],
            data['FechaCaducacion'],
            data['Activo_eliminado']
        );

        cargarEspComputadora(
            data['Procesador'],
            data['Generacion'],
            data['Ram'],
            data['TipoRam'],
            data['DiscoDuro'],
            data['Capacidad_D1'],
            data['DiscoDuro2'],
            data['Capacidad_D2'],
            data['Office'],
            data['SO']
        );

        cargarEspImpresora(
            data['TonerN'],
            data['TonerM'],
            data['TonerC'],
            data['TonerA'],
            data['tambor'],
            data['fusor']
        );

        cargarEspProyector(
            data['HorasUso'],
            data['HoraEco']
        );

        //DATATABLE QUE SE MUESTRA EN FORMULARIO Y QUE CONTIENE EL HISTORIAL DE CADA ACTIVO FIJO SEGUN EL ACTIVO ID QUE RECIBE
        $('#activoHistorial').DataTable({
            "ajax": {
                "url": "../Controladores/activoFijoControlador.php",
                "method": "post",
                "dataType": "json",
                "data": { "key": "getInfoHistorial", "ActivoId": data['Activo_id'] },
                "dataSrc": ""
            },
            "columns": [
                {
                    data: "Estructura31_id",
                    className: "Estructura31_id"
                },
                {
                    data: "estructura31_nombre",
                    className: "estructura31_nombre"
                },
                {
                    data: "Responsable",
                    className: "Responsable"
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

        //INPUT QUE GUARDA EL ACTIVO ID DEL ACTIVO QUE EL USUARIO SELECIONA
        $('#guardarIdActivo').val(data['Activo_id']);
    });

    $('#btnMostrarHistorial').on('click', function () {

        //DEJANDO EL FORMULARIO DE HISTORICO EN LIMPIO SIEMPRE QUE LO MUESTREN
        $("#formHistorico")[0].reset();

        //MOSTRANDO EL ID DE ESTRUCTURA 31 EN EL INPUT IDAREA
        $('#Estructura3IdH').on('change', function () {
            $('#idArea').val(this.value);
        });

        //MOSTRANDO EL ID DE ESTRUCTURA 31 EN EL INPUT RESPONSABLEID
        $('#ResponsableIdH').on('change', function () {
            $('#idResponsable').val(this.value);
        });

        //OBTENIEDO EL ACTIVO ID PARA CARGAR EL HISTORICO PO
        var historialId1 = $('#guardarIdActivo').val();
        //OBTENIENDO VARIABLES REFERENCIA Y DESCRIPCION DE ACTIVO PARA CARGARLOS EN EL FORMULARIO DE HISTORIAL
        var referencia = $('#ActivoReferencia').val();
        var descripcion = $('#ActivoDescripcion').val();
        //PONE EN EL INPUT GUARDARIDACTIVO2 EL VALOR DE ACTIVO_ID
        var ActivoIdHistorico = $('#guardarIdActivo2').val(historialId1);

        cargarHistorico2(referencia, descripcion);

        $('#historial').dataTable().fnDestroy();
        //DATATABLE QUE SE ENCUENTRA EN MODAL CONTIENE EL HISTORIAL DE CADA ACTIVO FIJO SEGUN EL ACTIVO ID QUE RECIBE
        $('#historial').DataTable({
            "ajax": {
                "url": "../Controladores/activoFijoControlador.php",
                "method": "post",
                "dataType": "json",
                "data": { "key": "getInfoHistorial", "ActivoId": historialId1 },
                "dataSrc": ""
            },
            "columns": [
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
                },
                {
                    data: "Descripcion",
                    className: "Descripcion"
                },
                {
                    data: "Estructura31_id",
                    className: "Estructura31_id"
                },
                {
                    data: "Responsable",
                    className: "Responsable"
                },
                {
                    data: null,
                    className: "btnMostrarH center",
                    defaultContent: '<button type="button" class="btn btn-spotify btnMostrarH" id="btnMostrarH"><i class="fa fa-eye"></i></button>'
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
    });

    $('#historial tbody').on('click', 'tr', function () {

        var table = $('#historial').DataTable();
        var data = table.row(this).data();

        cargarHistorico(
            data['Activo_referencia'],
            data['Descripcion'],
            data['Estructura31_id'],
            data['Responsable_id'],
            data['fechaHistorico'],
            data['Estado'],
            data['Historico_comentario'],
            data['Activo_id']
        );

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 0) {
            $('#estadoH').attr('checked', true);
        } else {
            $('#estadoH').attr('checked', false);
        }

    });

    // $('#historial tbody').on('click','#btnMostrarH', function(){
    // });

    function cargarGeneral1(activoRerefencia, partidaContabilidad, empresaId, numeroSerie, activoId, fechaAdq, activoFactura, activoTipo, ip) {
        $('input[name=ActivoReferencia]').val(activoRerefencia);
        $('input[name=PartidaCta]').val(partidaContabilidad);
        $('input[name=EmpresaId]').val(empresaId);
        $('input[name=numeroSerie]').val(numeroSerie);
        $('input[name=ActivoId]').val(activoId);
        $('input[name=ActivoFechaAdq]').val(fechaAdq);
        $('input[name=ActivoFactura]').val(activoFactura);
        $('#ActivoTipo option[value=' + activoTipo + ']').prop('selected', true);
        $('input[name=ip]').val(ip);
    }

    function cargarGeneral2(nombreUsuario, modelo, estructura1, estructura2, estructura3, activoDescripcion, fechaCaducacion, activoEliminado) {
        $('input[name=nombreUsuario]').val(nombreUsuario);
        $('input[name=Modelo]').val(modelo);
        $('#Estructura1Id option[value=' + estructura1 + ']').prop('selected', true);
        $('#Estructura2Id option[value=' + estructura2 + ']').prop('selected', true);
        $('#Estructura3Id option[value=' + estructura3 + ']').prop('selected', true);
        $('textarea[name=ActivoDescripcion]').val(activoDescripcion);
        $('input[name=ActivoFechaCaduc]').val(fechaCaducacion);
        $('#ActivoEliminado option[value=' + activoEliminado + ']').prop('selected', true);
    }

    function cargarEspComputadora(procesador, gerenacion, ram, tipoRam, discoDuro, capacidad1, discoDuro2, capacidad2, office, so) {
        $('input[name=Procesador]').val(procesador);
        $('input[name=Generacion]').val(gerenacion);
        $('input[name=Ram]').val(ram);
        $('input[name=TipoRam]').val(tipoRam);
        $('input[name=DiscoDuro]').val(discoDuro);
        $('input[name=CapacidadD1]').val(capacidad1);
        $('input[name=DiscoDuro2]').val(discoDuro2);
        $('input[name=CapacidadD2]').val(capacidad2);
        $('input[name=Office]').val(office);
        $('input[name=SO]').val(so);
    }

    function cargarEspImpresora(toneN, tonerM, tonerC, tonerA, tambor, fusor) {
        $('input[name=TonerN]').val(toneN);
        $('input[name=TonerM]').val(tonerM);
        $('input[name=TonerC]').val(tonerC);
        $('input[name=TonerA]').val(tonerA);
        $('input[name=tambor]').val(tambor);
        $('input[name=fusor]').val(fusor);
    }

    function cargarEspProyector(horasUso, horaEco) {
        $('input[name=HorasUso]').val(horasUso);
        $('input[name=HoraEco]').val(horaEco);
    }

    function cargarHistorico(referencia, descripcionActivo, estructura3, reponsable, fecha, estado, comentario, id) {
        $('input[name=ActivoReferenciaH]').val(referencia);
        $('textarea[name=ActivoDescripcionH]').val(descripcionActivo);
        $('input[name=idArea]').val(estructura3);
        $('#Estructura3IdH option[value=' + estructura3 + ']').prop('selected', true);
        $('input[name=idResponsable]').val(reponsable);
        $('#ResponsableIdH option[value=' + reponsable + ']').prop('selected', true);
        $('input[name=fechaHistorico]').val(fecha);
        $('input[name=estadoH]').val(estado);
        $('textarea[name=HistoricoComentarioH]').val(comentario);
        $('input[name=guardarIdActivo2]').val(id);
    }

    function cargarHistorico2(referencia, descripcionActivo) {
        $('input[name=ActivoReferenciaH]').val(referencia);
        $('textarea[name=ActivoDescripcionH]').val(descripcionActivo);
    }

    function blockControl(desabilitar) {
        //INPUTS DE INFORMACION GENERAL ACTIVO
        $('input[name=ActivoReferencia]').attr('disabled', desabilitar);
        $('input[name=PartidaCta]').attr('disabled', desabilitar);
        $('input[name=EmpresaId]').attr('disabled', desabilitar);
        $('input[name=numeroSerie]').attr('disabled', desabilitar);
        $('input[name=ActivoId]').attr('disabled', desabilitar);
        $('input[name=ActivoFechaAdq]').attr('disabled', desabilitar);
        $('input[name=ActivoFactura]').attr('disabled', desabilitar);
        $("#ActivoTipo").attr('disabled', desabilitar);
        $('input[name=ip]').attr('disabled', desabilitar);
        $('input[name=nombreUsuario]').attr('disabled', desabilitar);
        $('input[name=Modelo]').attr('disabled', desabilitar);
        $("#Estructura1Id").attr('disabled', desabilitar);
        $("#Estructura2Id").attr('disabled', desabilitar);
        $("#Estructura3Id").attr('disabled', desabilitar);
        $('textarea[name=ActivoDescripcion]').attr('disabled', desabilitar);
        $('input[name=ActivoFechaCaduc]').attr('disabled', desabilitar);
        $('input[name=ActivoEliminado]').attr('disabled', desabilitar);
        $('input[name=Imagen]').attr('disabled', desabilitar);
        //INPUTS ACTIVO RESPONSABLE
        $('#estado').attr('disabled', desabilitar);
        $("#ResponsableId").attr('disabled', desabilitar);
        $('textarea[name=HistoricoComentario]').attr('disabled', desabilitar);
        //INPUTS DE ACTIVO ESPECIFICACION
        $('input[name=Procesador]').attr('disabled', desabilitar);
        $('input[name=Generacion]').attr('disabled', desabilitar);
        $('input[name=Ram]').attr('disabled', desabilitar);
        $('input[name=TipoRam]').attr('disabled', desabilitar);
        $('input[name=DiscoDuro]').attr('disabled', desabilitar);
        $('input[name=CapacidadD1]').attr('disabled', desabilitar);
        $('input[name=DiscoDuro2]').attr('disabled', desabilitar);
        $('input[name=CapacidadD2]').attr('disabled', desabilitar);
        $('input[name=Office]').attr('disabled', desabilitar);
        $('input[name=SO]').attr('disabled', desabilitar);
        $('input[name=TonerN]').attr('disabled', desabilitar);
        $('input[name=TonerM]').attr('disabled', desabilitar);
        $('input[name=TonerC]').attr('disabled', desabilitar);
        $('input[name=TonerA]').attr('disabled', desabilitar);
        $('input[name=tambor]').attr('disabled', desabilitar);
        $('input[name=fusor]').attr('disabled', desabilitar);
        $('input[name=HorasUso]').attr('disabled', desabilitar);
        $('input[name=HoraEco]').attr('disabled', desabilitar);
    }

});
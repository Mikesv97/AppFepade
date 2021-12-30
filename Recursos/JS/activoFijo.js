$.noConflict();
jQuery(document).ready(function ($) {
    var filasTabla = 0;
    //DESABILITANDO LOS INPUT DEPENDIENDO DEL TIPO DE ACTIVO QUE SE SELECCIONE, POR DEFECTO LOS DE COMPUTADORA Y LAPTOP ESTAN DISPONIBLES
    //SIEMPREU QUE SE CARAG LA PAGINA
    desabilitarInputPc(false, true);
    desabilitarInputProyector(true);
    desabilitarInputImpresora(true);
    desabilitarIp(false, true);

    //MOSTRAR LOS COMENTARIOS, ASIGNACION Y ESTADO CUANDO QUIERAN INSERTAR
    $('#ResCompAsig').attr('hidden', false);

    //VARIABLE QUE UTILIZO SOLAMENTE PARA SABER CUAL ES LA ULTIMA POSICION EN EL HISTORIAL
    var lastHistoricoPosition = false;

    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK ELIMINADO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO ACTIVO
    var eliminado = 0;
    $('#ActivoEliminado').change(function () {
        if (eliminado == 0) {
            eliminado = 1;
        } else {
            eliminado = 0;
        }
    });

    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK INACTIVO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO ACTIVO
    var inactivo = 0;
    $('#estado').change(function () {
        if (inactivo == 0) {
            inactivo = 1;
        } else {
            inactivo = 0;
        }
    });

    //ASIGNADO EL VALOR DE 0 O 1 SI EL CHECK INACTIVO TIENE UN CAMBIO, OSEA SI LO ACTIVAN O NO DEL FORMULARIO HISTORICOM
    var inactivoH = 0;
    $('#estadoH').on('click', function () {
        if (inactivoH == 0) {
            inactivoH = 1;
        } else {
            inactivoH = 0;
        }
    });

    //DESABILITANDO BOTON INSERTAR, MODIFICAR Y MOSTRAR HISTORIAL CUANDO SE CARGA LA PAGINA
    $('#btnInsertar').attr('disabled', true);
    $('#btnModificar').attr('disabled', true);
    $('#btnEliminar').attr('disabled', true);
    $('#btnMostrarHistorial').attr('disabled', true);

    //INVOCANDO FUNCION QUE DESABILITA LOS CONTROLES DEL FORMULARIO
    blockControl(true);

    //EVENTO CLICK QUE ACTIVO O DESABILITA CONTROLES DEL FORMULARIO
    $('#verFormulario').on('click', function () {
        //PARA HACER RESET A LA TABLA ACTIVOHISTORIAL QUE SE MUESTRA EN EL FORMULARIO
        $('#activoHistorial').dataTable().fnDestroy();
        //HABILITANDO TODOS LOS INPUT DEL FORMULARIO
        blockControl(false);
        //MOSTRAR LOS COMENTARIOS, ASIGNACION Y ESTADO CUANDO QUIERAN INSERTAR
        $('#ResCompAsig').attr('hidden', false);
        //HABILITANDO BOTON INSERTAR
        $('#btnInsertar').attr('disabled', false);
        //DESABILITANDO BOTON MODIFICAR
        $('#btnModificar').attr('disabled', true);
        //DESABILITANDO BOTON ELIMINAR
        $('#btnEliminar').attr('disabled', true);
        //DESABILITANDO BOTON TRASLADAR ACTIVO
        $('#btnMostrarHistorial').attr('disabled', true);
        //LIMPIANDO EL FORMUARLIO SIEMPRE QUE DEN CLICK EN INGRESAR ACTIVO FIJO
        $("#formActivo")[0].reset();
        //RESETENADO LOS INPUT CHECK
        $('#ActivoEliminado').attr('checked', false);
        $('#estado').attr('checked', false);
        //CARGANDO LA IMAGEN POR DEFECTO CUANDO DEN CLICK EN INGRESAR ACTIVO FIJO
        $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/nodisponible.jpg');
        //AGREGANDO ESTILO AL INPUT CODIGO AUTOMATICO
        $('input[name=ActivoId]').addClass('desabilitado');
        //MUESTRA EL SELECT PARA QUE EL USUARIO CAMBIE EL AREA DESDE EL FORMUALRIO ACTIVO
        $("#Estructura3Id").show();
        //OCULTANDO TEXTO QUE EL AREA DEBE SER CAMBIADA DESDE EL HISTORIAL DE ACTIVO 
        $("#labelError2").hide();
        $("#labelError2").text("El area debe ser cambiada en el historial del activo.");

        //PARA CARGAR LA FECHA ACTUAL EN EL INPUT DATE DE ACTIVO FIJO CON LA FECHA ACTUAL
        function zeroPadded(val) {
            if (val >= 10)
                return val;
            else
                return '0' + val;
        }
        var d = new Date();
        $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));
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
            confirmButtonText: 'Aceptar'
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
                                    'El activo ha sido ingresado al sistema',
                                    'success'
                                )
                                $("#formActivo")[0].reset();
                                $('#activoInformacion').DataTable().ajax.reload();
                                $('#mostrarFormulario').addClass('collapse');
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

    //CUANDO SE MODIFICA UN ACTIVO
    $('#btnModificar').on('click',function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Modificar el activo en el sistema',
            text: "Porfavor confirma para modificar en el sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formActivo')[0]);
                formData.append("key", "modificar");
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
                            case "Modificado":
                                Swal.fire(
                                    'Activo modificado!',
                                    'El activo ha sido modificado en el sistema',
                                    'success'
                                )
                                $("#formActivo")[0].reset();
                                $('#activoInformacion').DataTable().ajax.reload();
                                $('#mostrarFormulario').addClass('collapse');
                                $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/nodisponible.jpg');
                                break;
                            case "FailModificarActivo":
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

    //CUANDO SE ELIMINA UN ACTIVO
    $('#btnEliminar').on('click',function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Eliminar el activo del sistema',
            text: "Porfavor confirma para cambiar estado a eliminado en el sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formActivo')[0]);
                formData.append("key", "eliminar");
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
                            case "EliminadoAct":
                                Swal.fire(
                                    'Activo eliminado!',
                                    'El activo cambio ha estado eliminado',
                                    'success'
                                )
                                $("#formActivo")[0].reset();
                                $('#activoInformacion').DataTable().ajax.reload();
                                $('#mostrarFormulario').addClass('collapse');
                                $('#mostrarImagen').attr('src', '../recursos/multimedia/imagenes/upload/nodisponible.jpg');
                                break;
                            case "FailActivoEliminado":
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

    //CUANDO SE CANCELA UN ACTIVO
    $('#btnCancelar').on('click', function(){
        $("#formActivo")[0].reset();
        $('#mostrarFormulario').addClass('collapse');
        $('#mostrarFormulario').removeClass('show');
    });

    //CUANDO SE INSERTA EN HISTICO ACTIVO
    $('#formHistorico').submit(function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Ingresar historico al sistema',
            text: "Porfavor confirma para ingresar el nuevo historico",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
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
                                    'Historico ingresado!',
                                    'El historico ha sido ingresado al sistema',
                                    'success'
                                )
                                $("#formHistorico")[0].reset();
                                $('#historial').DataTable().ajax.reload();
                                $('#activoHistorial').DataTable().ajax.reload();
                                var referencia = $('#ActivoReferencia').val();
                                var descripcion = $('#ActivoDescripcion').val();
                                cargarHistorico2(referencia, descripcion);
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
                data: "FechaAdquisicion",
                className: "FechaAdquisicion"
            },
            {
                data: "FechaCaducacion",
                className: "FechaCaducacion"
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
                defaultContent: '<button type="button" class="btn btn-spotify" id="btnMostrar"><i class="fa fa-eye"></i></button>'
                    
            },
            {
               
                data: null,
                className: "center",
                defaultContent: '<button type="button" class="btn btn-facebook" id="btnEditar"><i class="fa fa-pencil-square-o"></i></button>'
                +'<button type="button" class="btn btn-pinterest" id="btnBorrar"><i class="fa fa-trash-o"></i></button>'
                
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

    //validamos el rol para ocultar las columnas
    ocultarColumTableRol(rol);

    //CUANDO SE DA AL OJO DEL ACTIVO QUE SE QUIERE MOSTRAR
    $('#activoInformacion tbody').on('click', '#btnMostrar', function () {

        //INVOCANDO FUNCION PARA DESABILITAR CONTROLES DEL FORMULARIO
        blockControl(true);

        //REMOVIEHNDO ESTILO AL INPUT CODIGO AUTOMATICO
        $('input[name=ActivoId]').removeClass('desabilitado');

        //MUESTRA EL SELECT PARA QUE EL USUARIO CAMBIE EL AREA DESDE EL FORMUALRIO ACTIVO
        $("#Estructura3Id").show();

        //OCULTANDO TEXTO QUE EL AREA DEBE SER CAMBIADA DESDE EL HISTORIAL DE ACTIVO 
        $("#labelError2").hide();

        //OCULTAMOS LOS COMENTARIOS, ASIGNACION Y ESTADO CUANDO QUIERAN MODIFICAR
        $('#ResCompAsig').attr('hidden', true);

        //REMOVIENTO LA CLASE COLLAPSE PARA QUE AL DARLE CLICK AL ACTIVO SE DESPLIEGUE EL FORM 
        //CON LA INFORMACION
        $('#mostrarFormulario').removeClass('collapse');

        //DESABILITANDO EL BOTON INSERTAR ACTIVO CUANDO EL USUARIO CARGA LA INFORMACION DE UN ACTIVO
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', true);
        $('#btnEliminar').attr('disabled', true);
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
        if (data['Estado'] == 1) {
            $('#estado').attr('checked', true);
        } else {
            $('#estado').attr('checked', false);
        }

        //INVOCANDO FUNCIONES DE tipoActivo.js PARA HABILITAR O DESABILITAR LOS INPUT SEGUN TIPO DE ACTIVO
        if (data['Activo_tipo'] == 1 || data['Activo_tipo'] == 2) {
            desabilitarInputPc(true);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(true);
        } else if (data['Activo_tipo'] == 3) {
            desabilitarInputPc(true)
            desabilitarInputProyector(true)
            desabilitarInputImpresora(true);
        } else if (data['Activo_tipo'] == 4) {
            desabilitarInputPc(true)
            desabilitarInputProyector(true)
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
            data['Activo_eliminado'],
            data['Imagen'],
            data['Responsable_codigo'],
            data['Estado']
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

    //BOTON PARA EDITAR EL ACTIVO
    $('#activoInformacion tbody').on('click', '#btnEditar', function () {

        //INVOCANDO FUNCION PARA DESABILITAR CONTROLES DEL FORMULARIO
        blockControl(false);

        //OCULTA EL SELECT PARA QUE EL USUARIO NO CAMBIE EL AREA DESDE EL FORMUALRIO ACTIVO
        $("#Estructura3Id").hide();

        //MOSTRANDO TEXTO QUE EL AREA DEBE SER CAMBIADA DESDE EL HISTORIAL DE ACTIVO 
        $("#labelError2").show();
        $("#labelError2").text("El area debe ser cambiada en el historial del activo.");

        //REMOVIEHNDO ESTILO AL INPUT CODIGO AUTOMATICO
        $('input[name=ActivoId]').removeClass('desabilitado');

        //OCULTAMOS LOS COMENTARIOS, ASIGNACION Y ESTADO CUANDO QUIERAN MODIFICAR
        $('#ResCompAsig').attr('hidden', true);

        //REMOVIENTO LA CLASE COLLAPSE PARA QUE AL DARLE CLICK AL ACTIVO SE DESPLIEGUE EL FORM 
        //CON LA INFORMACION
        $('#mostrarFormulario').removeClass('collapse');

        //DESABILITANDO EL BOTON INSERTAR ACTIVO CUANDO EL USUARIO CARGA LA INFORMACION DE UN ACTIVO
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', false);
        $('#btnEliminar').attr('disabled', true);
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
            eliminado = 1
        } else {
            $('#ActivoEliminado').attr('checked', false);
            eliminado = 0
        }

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 1) {
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
            desabilitarInputPc(true);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(false);
            desabilitarIp(false);
        } else if (data['Activo_tipo'] == 4) {
            desabilitarInputPc(true);
            desabilitarInputProyector(false);
            desabilitarInputImpresora(true);
            desabilitarIp(true);
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
            data['Activo_eliminado'],
            data['Imagen'],
            data['Responsable_codigo'],
            data['Estado']
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

    $('#activoInformacion tbody').on('click', '#btnBorrar', function () {

        //INVOCANDO FUNCION PARA DESABILITAR CONTROLES DEL FORMULARIO
        blockControl(true);

        //REMOVIEHNDO ESTILO AL INPUT CODIGO AUTOMATICO
        $('input[name=ActivoId]').removeClass('desabilitado');
        $('input[name=ActivoId]').attr('disabled',false);

        //OCULTAMOS LOS COMENTARIOS, ASIGNACION Y ESTADO CUANDO QUIERAN MODIFICAR
        $('#ResCompAsig').attr('hidden', true);

        //REMOVIENTO LA CLASE COLLAPSE PARA QUE AL DARLE CLICK AL ACTIVO SE DESPLIEGUE EL FORM 
        //CON LA INFORMACION
        $('#mostrarFormulario').removeClass('collapse');

        //DESABILITANDO EL BOTON INSERTAR ACTIVO CUANDO EL USUARIO CARGA LA INFORMACION DE UN ACTIVO
        $('#btnInsertar').attr('disabled', true);
        $('#btnModificar').attr('disabled', true);
        $('#btnEliminar').attr('disabled', false);
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
            eliminado = 1
        } else {
            $('#ActivoEliminado').attr('checked', false);
            eliminado = 0
        }

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 1) {
            $('#estado').attr('checked', true);
        } else {
            $('#estado').attr('checked', false);
        }

        //INVOCANDO FUNCIONES DE tipoActivo.js PARA HABILITAR O DESABILITAR LOS INPUT SEGUN TIPO DE ACTIVO
        if (data['Activo_tipo'] == 1 || data['Activo_tipo'] == 2) {
            desabilitarInputPc(true);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(true);
        } else if (data['Activo_tipo'] == 3) {
            desabilitarInputPc(true);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(true);
            desabilitarIp(true);
        } else if (data['Activo_tipo'] == 4) {
            desabilitarInputPc(true);
            desabilitarInputProyector(true);
            desabilitarInputImpresora(true);
            desabilitarIp(true);
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
            data['Activo_eliminado'],
            data['Imagen'],
            data['Responsable_codigo'],
            data['Estado']
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

    //BOTON PARA MOSTRAR EL HISTORIAL DEL ACTIVO SELECIONADO
    $('#btnMostrarHistorial').on('click', function () {

        //DEJANDO EL FORMULARIO DE HISTORICO EN LIMPIO SIEMPRE QUE LO MUESTREN
        $("#formHistorico")[0].reset();

        //DESABILITANDO BOTONES DE INSERTAR Y MODIFICAR
        $("#btnModificarHostorico").attr('disabled', true);

        //RESETENADO LOS INPUT CHECK
        $('#estadoH').attr('checked', false);

        //MOSTRANDO EL ID DE ESTRUCTURA 31 EN EL INPUT IDAREA
        $('#Estructura3IdH').on('change', function () {
            $('#idArea').val(this.value);
        });

        //MOSTRANDO EL ID DE ESTRUCTURA 31 EN EL INPUT RESPONSABLEID
        $('#ResponsableIdH').on('change', function () {
            $('#idResponsable').val(this.value);
        });

        //PARA CARGAR LA FECHA ACTUAL EN EL INPUT DATE DE HISTORIAL CON LA FECHA ACTUAL
        function zeroPadded(val) {
            if (val >= 10)
                return val;
            else
                return '0' + val;
        }
        var d = new Date();
        $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));

        //ESTE CARGA FECHA Y HORA PERO DABA ERROR
        // d = new Date();
        // $('input[type=datetime-local]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate())+"T"+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds());

        //OBTENIEDO EL ACTIVO ID PARA CARGAR EL HISTORICO PO
        var historialId1 = $('#guardarIdActivo').val();
        //OBTENIENDO VARIABLES REFERENCIA Y DESCRIPCION DE ACTIVO PARA CARGARLOS EN EL FORMULARIO DE HISTORIAL
        var referencia = $('#ActivoReferencia').val();
        var descripcion = $('#ActivoDescripcion').val();
        //PONE EN EL INPUT GUARDARIDACTIVO2 EL VALOR DE ACTIVO_ID
        var ActivoIdHistorico = $('#guardarIdActivo2').val(historialId1);

        //FUNCION PARA CARGAR LOS INPUT DE REFERENCIA Y DESCRIPCION SEGUN EL HISTORIAL DEL ACTIVO QUE CARGUEN
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
            "order": [[0, "desc"]],//CON ESTO LE DECIMOS QUE PONGA LA COLUMNA DE FECHA HISTORICO DESCENDENTE
            "columns": [
                {
                    data: "fechaHistorico",
                    className: "fechaHistorico"
                },
                {
                    data: "estructura31_nombre",
                    className: "estructura31_nombre"
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
                    className: "center btnMostrarHistorial",
                    defaultContent: '<button type="button" class="btn btn-spotify"><i class="fa fa-eye"></i></button>'
                },
                {
                    data: null,
                    className: "center btnEditarHistorial",
                    defaultContent: '<button type="button" class="btn btn-facebook"><i class="fa fa-pencil-square-o"></i></button>'
                },
                {
                    data: null,
                    className: "center btnEliminarHistorial",
                    defaultContent: '<button type="button" class="btn btn-pinterest"><i class="fa fa-trash-o"></i></button>'
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

    //BOTON PARA CARGAR LOS INPUT CON LA INFORMACION DEL HISTORIAL SELECIONADO
    $('#historial tbody').on('click', '.btnMostrarHistorial', function () {

        //GUARDANDO LA INFORMACION ALMACENADA EN LA TABLA EN LA VARIABLE DATA
        var table = $('#historial').DataTable();
        var data = table.row(this).data();

        //VARIABLES QUE SIRVEN PARA ACTUALIZAR EL ESTADO DEL ACTIVO EN LA TABLA ACTIVO
        var totalFilas = 1;
        var filaClick = parseInt(table.row(this).index()) + 1;

        //COMPROBACION DE CUAL ES EL ULTIMO HISTORICO INGRESADO
        if (filaClick == totalFilas) {
            lastHistoricoPosition = true;
        } else {
            lastHistoricoPosition = false;
        }

        //HABILITANDO LOS INPUT
        blockControlHistorial(false);

        //ENVIANDO AL INICIO DEL FORMULARIO CUANDO EL USUARIO DE CLICK AL HISTORIAL
        $(location).attr('href', '#inicioFormHistorial');

        //DESABILITANDO BOTON MODIFICAR Y BOTON INSERTAR
        $("#btnModificarHostorico").attr('disabled', true);
        $("#btnInsertarHistorico").attr('disabled', true);

        //DESABILITANDO LOS INPUT CUANDO EL USUARIO SOLAMENTE QUIERE VER LA INFORMACION
        blockControlHistorial(true);

        //CARGANDO LOS INPUT CON LA DATA DE LA TABLA HISTORIAL
        cargarHistorico(
            data['Activo_referencia'],
            data['Descripcion'],
            data['Estructura31_id'],
            data['Responsable_id'],
            data['fechaHistorico'],
            data['Estado'],
            data['Historico_comentario'],
            data['Activo_id'],
            data['Historico_id']
        );

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 1) {
            $('#estadoH').attr('checked', true);
            inactivoH = 1;
        } else {
            $('#estadoH').attr('checked', false);
            inactivoH = 0;
        }

    });

    //BOTON PARA CARGAR LOS INPUT CON LA INFORMACION DEL HISTORIAL SELECIONADO
    $('#historial tbody').on('click', '.btnEditarHistorial', function () {

        //GUARDANDO LA INFORMACION ALMACENADA EN LA TABLA EN LA VARIABLE DATA
        var table = $('#historial').DataTable();
        var data = table.row(this).data();

        //VARIABLES QUE SIRVEN PARA ACTUALIZAR EL ESTADO DEL ACTIVO EN LA TABLA ACTIVO
        var totalFilas = 1;
        var filaClick = parseInt(table.row(this).index()) + 1;

        //COMPROBACION DE CUAL ES EL ULTIMO HISTORICO INGRESADO
        if (filaClick == totalFilas) {
            lastHistoricoPosition = true;
        } else {
            lastHistoricoPosition = false;
        }

        //HABILITANDO LOS INPUT CUANDO EL USUARIO QUIERE EDITAR EL HISTORIAL
        blockControlHistorial(false);

        //DESABILITANDO BOTONES DE INSERTAR Y MODIFICAR
        $("#btnInsertarHistorico").attr('disabled', true);
        $("#btnModificarHostorico").attr('disabled', false);

        //CARGANDO LOS INPUT CON LA DATA DE LA TABLA HISTORIAL
        cargarHistorico(
            data['Activo_referencia'],
            data['Descripcion'],
            data['Estructura31_id'],
            data['Responsable_id'],
            data['fechaHistorico'],
            data['Estado'],
            data['Historico_comentario'],
            data['Activo_id'],
            data['Historico_id']
        );

        //EVALUA EL VALOR QUE VIENE DE LA COLUMNA ACTIVO ESTADO PARA PONER EL CHEKE O QUITARLO
        if (data['Estado'] == 1) {
            $('#estadoH').attr('checked', true);
            inactivoH = 1;
        } else {
            $('#estadoH').attr('checked', false);
            inactivoH = 0;
        }

    });

    //BOTON PARA MODIFICAR UN HISTIRAL SELECIONADO
    $('#btnModificarHostorico').on('click', function () {

        //VARIABLE PARA VERIFICAR SI lastHistoricoPosition ES VERDADERO O FALSO Y ASI ENTRAR A LA CONDICION DE ACTIVO CONTROLADOR
        var prueba1;

        //SI ES VERDADER0 ENTONCES EL VALOR TOMA 1 PARA MODIFICAR HISTORICO Y EL ESTADO DE ACTIVO
        if (lastHistoricoPosition) {
            prueba1 = 1;
            //SI NO SOLO MODIFICA EL HISTORICO
        } else {
            prueba1 = 0;
        }

        Swal.fire({
            title: 'Modificar historico en el sistema',
            text: "Porfavor confirma para modificar el historico",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formHistorico')[0]);
                formData.append("key", "modificarHisotial");
                formData.append("activoInacH", inactivoH);
                formData.append("ultimoLinea", prueba1);
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
                            case "modificar":
                                Swal.fire(
                                    'Historico modifico!',
                                    'El historico ha sido modificado en el sistema',
                                    'success'
                                )
                                $("#formHistorico")[0].reset();
                                $('#historial').DataTable().ajax.reload();
                                $('#activoHistorial').DataTable().ajax.reload();
                                var referencia = $('#ActivoReferencia').val();
                                var descripcion = $('#ActivoDescripcion').val();
                                cargarHistorico2(referencia, descripcion);
                                break;
                            case "FailHistoricoModificado":
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

    //BOTON PARA ELIMINAR UN HISTORIAL SELECIONADO
    $('#historial tbody').on('click', '.btnEliminarHistorial', function (){

        //GUARDANDO LA INFORMACION ALMACENADA EN LA TABLA EN LA VARIABLE DATA
        var table = $('#historial').DataTable();
        var data = table.row(this).data();

        //CARGANDO LOS INPUT CON LA DATA DE LA TABLA HISTORIAL
        cargarHistorico(
            data['Activo_referencia'],
            data['Descripcion'],
            data['Estructura31_id'],
            data['Responsable_id'],
            data['fechaHistorico'],
            data['Estado'],
            data['Historico_comentario'],
            data['Activo_id'],
            data['Historico_id']
        );

        Swal.fire({
            title: 'Eliminar historico del sistema',
            text: "Porfavor confirma para eliminar al historico",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($('#formHistorico')[0]);
                formData.append("key", "eliminarHistorial");
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
                            case "Eliminado":
                                Swal.fire(
                                    'Historico eliminado!',
                                    'El historico ha sido eliminado del sistema',
                                    'success'
                                )
                                $("#formHistorico")[0].reset();
                                $('#historial').DataTable().ajax.reload();
                                $('#activoHistorial').DataTable().ajax.reload();
                                break;
                            case "FailHistoricoEliminado":
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
            } else if (result.isDismissed) {
                //SI EL USUARIO PRESIONA EL BOTON CANCELAR SE LIMPIA EL FORMULARIO
                $("#formHistorico")[0].reset();
                //CARGAOS LOS INPUT CON LOS VALORES DE REFERENCIA Y DESCRIPCION LUGO DE LIMPIAR EL FORMULARIO
                var referencia = $('#ActivoReferencia').val();
                var descripcion = $('#ActivoDescripcion').val();
                cargarHistorico2(referencia, descripcion);
            }
        })


    });

    //BOTON PARA LIMPIAR EL FORMULARIO Y PODER INGRESAR UN NUEVO HISTORIAL
    $('#btnNuevoHistorico').on('click', function (){
        //DEJANDO EL FORMULARIO DE HISTORICO EN LIMPIO
        $("#formHistorico")[0].reset();

        //HABILITANDO LOS INPUT CUANDO EL USUARIO QUIERE EDITAR EL HISTORIAL
        blockControlHistorial(false);

        //CARGANDO LA INFORMACION DE REFERENECIA Y DESCRIPCION EN LOS INPUT
        var referencia = $('#ActivoReferencia').val();
        var descripcion = $('#ActivoDescripcion').val();
        cargarHistorico2(referencia, descripcion);

        //DESABILITANDO BOTON MODIFICAR Y HABILITANDO BOTON INSERTAR
        $("#btnModificarHostorico").attr('disabled', true);
        $("#btnInsertarHistorico").attr('disabled', false);

        //RESETENADO LOS INPUT CHECK
        $('#estadoH').attr('checked', false);

        //PARA CARGAR LA FECHA ACTUAL EN EL INPUT DATE DE HISTORIAL CON LA FECHA ACTUAL
        function zeroPadded(val) {
            if (val >= 10)
                return val;
            else
                return '0' + val;
        }
        var d = new Date();
        $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));
    });


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

    function cargarGeneral2(nombreUsuario, modelo, estructura1, estructura2, estructura3, activoDescripcion, fechaCaducacion, activoEliminado,imagenBD,Responsable,estado) {
        $('input[name=nombreUsuario]').val(nombreUsuario);
        $('input[name=Modelo]').val(modelo);
        $('#Estructura1Id option[value=' + estructura1 + ']').prop('selected', true);
        $('#Estructura2Id option[value=' + estructura2 + ']').prop('selected', true);
        $('#Estructura3Id option[value=' + estructura3 + ']').prop('selected', true);
        $('textarea[name=ActivoDescripcion]').val(activoDescripcion);
        $('input[name=ActivoFechaCaduc]').val(fechaCaducacion);
        $('#ActivoEliminado option[value=' + activoEliminado + ']').prop('selected', true);
        $('input[name=imagenBD]').val(imagenBD);
        $('#ResponsableId option[value=' + Responsable + ']').prop('selected', true);
        $('#estado option[value=' + estado + ']').prop('selected', true);
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

    function cargarHistorico(referencia, descripcionActivo, estructura3, reponsable, fecha, estado, comentario, id, historicoId) {
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
        $('input[name=historicoId]').val(historicoId);
    }

    function cargarHistorico2(referencia, descripcionActivo) {
        $('input[name=ActivoReferenciaH]').val(referencia);
        $('textarea[name=ActivoDescripcionH]').val(descripcionActivo);
    }

    //FUNCION PARA DESABILITAR LOS INPUT DE ACTIVO FIJO
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

    //FUNCION PARA DESABILITAR LOS INPUT DEL HISTORIAL
    function blockControlHistorial(desabilitar){
        $('#Estructura3IdH').attr('disabled', desabilitar);
        $('#ResponsableIdH').attr('disabled', desabilitar);
        $('input[name=fechaHistorico]').attr('disabled', desabilitar);
        $('input[name=estadoH]').attr('disabled', desabilitar);
        $('textarea[name=HistoricoComentarioH]').attr('disabled', desabilitar);
    }

    //función que oculta columnas de DataTable según el rol que inicia sesión
    function ocultarColumTableRol(rol){
        var dtActivo = $('#activoInformacion').DataTable();
       
        
        //evaluamos por switch los diferentes roles del sistema
        switch(rol){
            case "admin":
                //el admin puede editar y eliminar mostramos la columna
                dtActivo.columns(18).visible(true);
            break;
            case "Secretaria":
                //la secretaria no puede editar ni eliminar, ocultamos columna
                dtActivo.columns(18).visible(false);
            break;
            case "Visitante":
                //el visitante no puede hacer acciones crud, ocultamos columna
                dtActivo.columns(18).visible(false);
            break;
        }
    }
});
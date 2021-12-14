$.noConflict();
jQuery( document ).ready(function( $ ) {
    //EVENTO CHANGE QUE MUESTRA LA IMAGEN QUE SE AGREGAR EN EL INPUT FILE
    //PARA PREVISUALIZAR LA IMAGEN ANTES DE INSERTARLA
    $('#Imagen').change(function(){
        var file =this.files;
        var element = file[0];

        var imgTemp = URL.createObjectURL(element);
        $('#mostrarImagen').attr('src',imgTemp);
    });
    //CUANDO SE INSERTA UN ACTIVO FIJO
    $('#formActivo').submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#formActivo')[0]);
        formData.append("key", "insertar");
        formData.append("tipoActivo", $('#ActivoTipo').val());
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
                    case 1:
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
                                Swal.fire(
                                    'Activo ingresado!',
                                    'El activo a sido ingresado al sistema',
                                    'success'
                                ).then(function () {
                                    $("#formActivo")[0].reset();
                                    $('#activoInformacion').DataTable().ajax.reload();
                                })
                            }
                        })
                        break;
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
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
                defaultContent: '<button type="button" class="btn btn-spotify btnMostrar" id="mostrar"><i class="fa fa-eye"></i></button> <button type="button" class="btn btn-facebook btnEditar"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="btn btn-pinterest btnEliminar"><i class="fa fa-trash-o"></i></button> '
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

    $('#activoInformacion tbody').on('click', 'tr', function () {
        //REMOVIENTO LA CLASE COLLAPSE PARA QUE AL DARLE CLICK AL ACTIVO SE DESPLIEGUE EL FORM 
        //CON LA INFORMACION
        $('#mostrarFormulario').removeClass('collapse');
        //ENVIANDO AL INICIO DEL FORMULARIO CUANDO EL USUARIO DE CLICK AL ACTIVO
        $(location).attr('href','#inicioForm');
        //DESTRUIR EL OBJETO DE LA TABLA ACTIVOHISTORIAL YA INICIALIZADO Y ASI PODER
        //MOSTRAR EL HISTORIAL DE OTRO ACTIVO
        $('#activoHistorial').dataTable().fnDestroy();
        var table = $('#activoInformacion').DataTable();
        //LA VARIABLE DATA OBTIENE TODO EL CONTENIDO QUE VIENE DE LA FUNCION tablaActivoFijo DE ACTIVOFIJODAO
        var data = table.row(this).data();
        //MOSTRANDO LA IMAGEN QUE TIENE CADA ACTIVO
        $('#mostrarImagen').attr('src','../recursos/multimedia/imagenes/upload/'+data['Imagen']);

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

        
        
        //DATATABLE QUE CONTIENE EL HISTORIAL DE CADA ACTIVO FIJO SEGUN EL ACTIVO ID QUE RECIBE
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
    });

    function cargarGeneral1(activoRerefencia,partidaContabilidad,empresaId,numeroSerie,activoId,fechaAdq,activoFactura,activoTipo,ip){
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

    function cargarGeneral2(nombreUsuario,modelo,estructura1,estructura2,estructura3,activoDescripcion,fechaCaducacion,activoEliminado){
        $('input[name=nombreUsuario]').val(nombreUsuario);
        $('input[name=Modelo]').val(modelo);
        $('#Estructura1Id option[value=' + estructura1 + ']').prop('selected', true);
        $('#Estructura2Id option[value=' + estructura2 + ']').prop('selected', true);
        $('#Estructura3Id option[value=' + estructura3 + ']').prop('selected', true);
        $('textarea[name=ActivoDescripcion]').val(activoDescripcion);
        $('input[name=ActivoFechaCaduc]').val(fechaCaducacion);
        $('#ActivoEliminado option[value=' + activoEliminado + ']').prop('selected', true);
    }

    function cargarEspComputadora(procesador,gerenacion,ram,tipoRam,discoDuro,capacidad1,discoDuro2,capacidad2,office,so){
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

    function cargarEspImpresora(toneN,tonerM,tonerC,tonerA,tambor,fusor){
        $('input[name=TonerN]').val(toneN);
        $('input[name=TonerM]').val(tonerM);
        $('input[name=TonerC]').val(tonerC);
        $('input[name=TonerA]').val(tonerA);
        $('input[name=tambor]').val(tambor);
        $('input[name=fusor]').val(fusor);
    }

    function cargarEspProyector(horasUso,horaEco){
        $('input[name=HorasUso]').val(horasUso);
        $('input[name=HoraEco]').val(horaEco);
    }

    // $('#ActivoFechaAdq').change(function(){
    //     console.log($('#ActivoFechaAdq').val());
    // });
});
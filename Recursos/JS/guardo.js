$(document).ready(function () {
    mostrar();

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

    function mostrar() {
        $.noConflict(true);
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
    }

    function mostrarHistorico(id) {
        $.noConflict(true);
        $('#activoHistorial').DataTable({
            "ajax": {
                "url": "../Controladores/activoFijoControlador.php",
                "method": "post",
                "dataType": "json",
                "data": { "key": "getInfoHistorial", "ActivoId": 256 },
                "dataSrc": ""
            },
            "columns": [
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
                },
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
                },
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
                },
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
                },
                {
                    data: "Activo_referencia",
                    className: "Activo_referencia"
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

    $('#activoInformacion tbody').on('click', 'tr', function () {
        var table = $('#activoInformacion').DataTable();
        //LA VARIABLE DATA OBTIENE TODOS LOS VALORES QUE ESTAN EN LA TABLA CON ID ACTIVOINFORMACION
        var data = table.row(this).data();
        
        //PONEMOS DATA MAS EL NOMBRE DE LA COLUMNA SEGUN LA BASE DE DATOS Y OBTENEMOS EL VALOR
        $('input[name=ActivoReferencia]').val(data['Activo_referencia']);
        $('input[name=PartidaCta]').val(data['PartidaCta']);
        $('input[name=EmpresaId]').val(data['Empresa_id']);
        $('input[name=numeroSerie]').val(data['numero_serie']);
        $('input[name=ActivoId]').val(data['Activo_id']);

        // console.log(mostrarHistorico(data['Activo_id']));

        //INPUT FECHA HAY PROBLEMAS CON PASAR LA INFORMACION DE LA BASE DE DATOS AL INPUT
        $('input[name=ActivoFactura]').val(data['Activo_factura']);
        $('#ActivoTipo option[value=' + data['tipo_activo_id'] + ']').prop('selected', true);
        $('input[name=ip]').val(data['IP']);
        $('input[name=nombreUsuario]').val(data['Usuario']);
        $('input[name=Modelo]').val(data['Modelo']);
        $('#Estructura1Id option[value=' + data['Estructura1_id'] + ']').prop('selected', true);
        $('#Estructura2Id option[value=' + data['Estructura2_id'] + ']').prop('selected', true);
        $('#Estructura3Id option[value=' + data['Estructura3_id'] + ']').prop('selected', true);
        $('textarea[name=ActivoDescripcion]').val(data['Activo_descripcion']);
        //INPUT FECHA HAY PROBLEMAS CON PASAR LA INFORMACION DE LA BASE DE DATOS AL INPUT
        $('#ActivoEliminado option[value=' + data['Activo_eliminado'] + ']').prop('selected', true);
        $('input[name=Procesador]').val(data['Procesador']);
        $('input[name=Generacion]').val(data['Generacion']);
        $('input[name=Ram]').val(data['Ram']);
        $('input[name=TipoRam]').val(data['TipoRam']);
        $('input[name=DiscoDuro]').val(data['DiscoDuro']);
        $('input[name=CapacidadD1]').val(data['Capacidad_D1']);
        $('input[name=DiscoDuro2]').val(data['DiscoDuro2']);
        $('input[name=CapacidadD2]').val(data['Capacidad_D2']);
        $('input[name=Office]').val(data['Office']);
        $('input[name=SO]').val(data['SO']);
        $('input[name=TonerN]').val(data['TonerN']);
        $('input[name=TonerM]').val(data['TonerM']);
        $('input[name=TonerC]').val(data['TonerC']);
        $('input[name=TonerA]').val(data['TonerA']);
        $('input[name=tambor]').val(data['tambor']);
        $('input[name=fusor]').val(data['fusor']);
        $('input[name=HorasUso]').val(data['HorasUso']);
        $('input[name=HoraEco]').val(data['HoraEco']);
        
    });

});
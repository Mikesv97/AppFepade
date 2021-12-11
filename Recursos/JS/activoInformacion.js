$(document).ready(function(){
    mostrar()
    function mostrar(){
        $.noConflict(true);
        $('#activoInformacion').DataTable({
            "ajax":{
                "url": "../Controladores/activoInfoControlador.php",
                "method": "post",
                "dataType": "json",
                "data": {"key": "getInfoActivo"},
                "dataSrc": ""
            },
            "columns": [
                {"data": "Activo_id"},
                {"data": "Empresa_id"},
                {"data": "Estructura1_id"},
                {"data": "Estructura2_id"},
                {"data": "Estructura3_id"},
                {
                    data: null,
                    className: "center",
                    defaultContent: '<a href="" class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
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
});
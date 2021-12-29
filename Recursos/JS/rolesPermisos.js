$(document).ready(function ($) {

    cargarRoles();
    cargarAcciones();
    cargarMenus();

    /*Cuando se genere clic en el último elemento de la lista dentro del ID grupoCkbAcciones
    desmarcamos los demás checkbox seleccionados, ya que el último elemento de la lista pertenece
    a "Ninguna" lo que significa que el rol no podrá hacer ninguna acción en el sistema, porque así 
    está en la tabla acciones en la BD, si esto se cambia, y la acción "ninguna" deja de ser
    el último elemento, se debe ajustar al elemento que sea, ejm: first, second, etc. */
    $("body").on("click","#grupoCkbAcciones li:last", function(){

        /*como se hace clic en el último elemento de la lista que pertenece a ninguno obtenemos su valor */
        var valNinguno = $(this).find(".ckbAcciones").val();
         //evaluamos si el chekbox ninguno esta seleccionado
        if($(this).find(".ckbAcciones").is(":checked")){
            //si está seleccionado, recorremos todos los chekbox con clase .ckbAcciones 
            $(".ckbAcciones:checkbox").each(function(index, elemento){
            //preguntamos si el elemento actual del recorrido (0,1,2,etc)
            //está seleccionado
            if($(elemento).is(":checked")){
                //si esta seleccionado, evaluamos que su valor no sea igual al del último elemento("ninguno")
                if($(elemento).val() != valNinguno){
                    //si su valor es difetente, quiere decir que el chekbox seleccionado
                    //es diferente a ninguno, procedemos a desmarcarlo
                    $(elemento).prop('checked',false);
                }
            }
        });
        } 

    });

    
    //al submit evaluamos si los chekbox están seleccionados almenos 1 de cada tipo
    $("#frmRoles").submit(function(e){
        e.preventDefault();
        var ckbAcc =$(".ckbAcciones:checkbox");
        var countCkbAcc = parseInt(0);
        var totalCkbAcc =  ckbAcc.length;
        //verificamos si almenos un ckbx de acción está seleccionado
        $(".ckbAcciones:checkbox").each(function(index, elemento){
            if($(elemento).is(":checked")){
                if(index != (totalCkbAcc-1)){
                    console.log("se suma la accion "+$(elemento).next("label").text()+" con el valor: "+$(elemento).val());
                }else{
                    console.log("Solo se suma "+$(elemento).next("label").text()+" con el valor: "+$(elemento).val());
                }
            
            }
        });
    });

    //función que solicita por ajax la carga de roles
    //y carga la tabla automáticamente con Ajax- DataTable
    function  cargarRoles() {
        $.noConflict();
        $('#tblRoles').DataTable({
                "ajax":{
                    "url": "../controladores/rolesPermisosControlador.php",
                    "method": "post",
                    "dataType": "json",
                    "data": { "key": "obtenerRoles" },
                    "dataSrc": ""
                },
                "columns": [
                    {
                        data: "id_rol",
                        className: "idRol"
                    },
                    {
                        data: "rol_nombre",
                        className: "nombreRol"
                    },
                    {
                        data: "rol_descripcion",
                        className: "rolDescripcion"
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: 
                        '<button id="btnEditar" class="btn btn-warning noHover">Editar</button>'
                        +'<button id="btnEliminar" class="mx-2 btn btn-danger noHover">Eliminar</button>'
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

    //función que solicita las acciones (CRUD) de la BD para cargar los
    //chekbox en la vista roles y permisos
    function cargarAcciones(){
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerAcciones"},
            success: function (r) {
                var count = parseInt(0);

               for(let i=0; i<r.length; i++){
                    var div =
                        '<li><input type="checkbox" value="'+r[i]["id_accion"]+'" class=" form-check-input checkContent ckbAcciones" id="accionItem'+count+'">'
                        +'<label class="form-check-label checkContent" for="accionItem'+count+'">'+r[i]["nombre_accion"]+'</label></li>';
                    count++;
                    $("#grupoCkbAcciones").append(div);
               }
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar las acciones para el rol'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }

    //función que solicita el menu de la BD para cargar los
    //chekbox en la vista roles y permisos
    function cargarMenus(){
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerMenu"},
            success: function (r) {
                var count = parseInt(0);

               for(let i=0; i<r.length; i++){
                    var div =
                        '<li><input type="checkbox" value="'+r[i]["id_menu"]+'" class="form-check-input ckbMenu" id="menuItem'+count+'">'
                        +'<label class="form-check-label" for="menuItem'+count+'">'+r[i]["nombre_menu"]+'</label></li>';
                    count++;
                    $("#grupoCkbMenu").append(div);
               }
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar el menú'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }
});
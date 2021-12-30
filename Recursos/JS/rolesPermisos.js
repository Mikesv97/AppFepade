$.noConflict();
jQuery(document).ready(function ($){
    //variables globales
    var error = null;
    $("#labelError").hide();
    cargarRoles();
    cargarAcciones();
    cargarMenus();
  
    //cuando se genere click en el último elemento de la lista
    //desmarcamos los demás chekbox de la misma lista (más detalles dentro de la función, al final.)
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

        /* -----DETALLE DE LA LÓGICA DE LA FUNCIÓN */
        /*Cuando se genere clic en el último elemento de la lista de ID grupoCkbAcciones
        desmarcamos los demás checkbox seleccionados, ya que el último elemento de la lista pertenece
        a "Ninguna" lo que significa que el rol no podrá hacer ninguna acción en el sistema, porque así 
        lo definimos en la tabla acciones en la BD, si esto se cambia, y la acción "ninguna" deja de ser
        el último elemento, se debe ajustar al elemento que sea, ejm: first, second, etc. O en caso no la
        agreguen es de comentar/eliminar esta función */
    });

    /*lo contrario a lo del evento click del último elemento de la lista de ID grupoCkbAcciones*/
    $("body").on("click","#grupoCkbAcciones li", function(){
        //obtenemos el número total de elementos inputs tipo chekbox con clase .ckbAcciones
        var totalCkbAcc =  $(".ckbAcciones:checkbox").length;
        //preguntamos si el index donde se hizo click es el mismo del total (que viene siendo el último)
        if($(this).index() != totalCkbAcc){
            //en caso sea diferente, quiere decir que hizo click en otro chekbox
            //diferente a "Ninguna", procedemos a desmarcar el chekbox "Ninguna"
            $(".ckbAcciones:checkbox:last").prop('checked',false);
        }

    });

    /*al envento change del input nombre rol, validamos que no esté ingresado el rol*/
    $("#txtNombreRol").change(function(){
        //obtenemos el valor ingresado, convirtiendo a mayusculas el primer caracter
        //para evitar que admin (ingresado por el usuario) != Admin (valor en BD)
        //y mantener siempre la primer letra mayuscula.
        var rolIngresado = convertirPrimerLetraMayus($(this).val());

        //llamamos a la función que envia ajax pidiendo roles
        //llamamos a la función y su parametro (el arreglo) que viene siendo el parametro callbalck 
        //definido cuando creamos la función
        validarRolNoRegistrado( function(roles){
            //recorremos el arreglo y buscamos si el valor ingresado ya existe
            for(let i=0; i<roles.length; i++){
                if(roles[i]==rolIngresado){
                    //si existe, lanzamos error
                    $("#labelError").show();
                    $("#labelError").text("Rol ya ingresado en el sistema, por favor ingresa otro.");
                    $("#txtNombreRol").focus();
                    i=roles.length;
                    error = rolIngresado;
                }else{
                    //sino, ocultamos el error por si está visible
                    $("#labelError").hide();
                }
            }
        });
        
    });

    /*cuando presiona tecla ocultamos el error si está visible*/
    $("#txtNombreRol").keypress(function(e){
        
        if($("#labelError").is(":visible")){
            
            if($(this).val() != error){
                $("#labelError").hide();
            }
        }


    });
    //cuando se ejecuta el submit del form roles
    $("#frmRoles").submit(function(e){
   
        //evitamos el evento
        e.preventDefault();

        if($("#labelError").is(":visible")){
            Swal.fire(
                'Errores Detectados',
                'Verifica que la información ingresada sea correcta y no tenga errores.',
                'info'
              )
              
        }else{
            //obtenemos el array con las acciones seleccionadas para el rol
            var accionesArray = generarArrayAcciones();

            //obtenemos el array con el menú seleccionado para el rol
            var menuArray = generarArrayMenu();

            if(accionesArray ==0){
                Swal.fire(
                    '¿Acciones para este rol?',
                    'Debes seleccionar al menos una acción para este rol',
                    'question'
                )
                $("#btnIngresar").blur();
            }else if(menuArray ==0){
                Swal.fire(
                    '¿Menú para este rol?',
                    'Debes seleccionar al menos un menú al que podrá acceder este rol',
                    'question'
                )
                $("#btnIngresar").blur();
            }else{
                    var nombreRol = $("#txtNombreRol").val();
                    var descRol =  $("#txtDescRol").val();

                    //se envia ajax
                    $.ajax({
                        url:"../controladores/rolesPermisosControlador.php",
                        method: "post",
                        dataType: "json",
                        data: { "key": "insertarRol",
                        "nombreRol": nombreRol,
                        "descRol": descRol, 
                        "accionesArray": accionesArray,
                        "menuArray": menuArray},
                        success: function (r) {
                            if(r == true){
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'success',
                                    title: 'Rol insertado con éxtio',
                                    showConfirmButton: false,
                                    timer: 1500
                                  })
                                $("#frmRoles")[0].reset();
                                $('#tblRoles').DataTable().ajax.reload();
                            }
                        },
                        error: function (r) {
                            //console.log(r.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: "Problemas de comunicación",
                                text: 'Parece tenemos problemas para comunicarnos con los servidores e insertar el rol'
                                +' por favor verifica tu conexión de internet e intenta de nuevo.',
                                showConfirmButton: true
                            })
                        }
                    });   
            }
        }
       

    });


    //al click del ojo es para ver toda la información del rol
    $("#tblRoles tbody").on("click","#btnMostrar", function(){
       //desabilitamos controles y mandamos al inicio del form al usuario
       $(location).attr('href', '#inicioForm');
       //deshabilitamos los controles
       disabledControles(true);
       //cargamos información
       var table = $('#tblRoles').DataTable();
       var data = table.row(this).data();

       cargarCheckBoxMenuRol(data["id_rol"]);
    });

    function disabledControles(boolean){

        $("#txtNombreRol").prop("disabled", boolean);
        $("#txtDescRol").prop("disabled", boolean);
        $("#btnIngresar").prop("disabled", boolean);
        $(".ckbAcciones:checkbox").prop("disabled",boolean);
        $(".ckbMenu:checkbox").prop("disabled",boolean);
    }

    //función que solicita el menú según el idRol pasado como parametro
    //que sería el ID del rol seleccionado en la tabla
    //se comunica con homeControlador para reutilizar código.
    function cargarCheckBoxMenuRol(idRolTbl){
        $(".ckbMenu:checkbox").prop("checked", false);
        $.ajax({
            url: "../Controladores/homeControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "solicitarMenu","idRol": idRolTbl},
            success: function (r) {
                if(r == "ID Rol No Definido"){
                    Swal.fire({
                        icon: 'error',
                        title: "Problemas Encontrados",
                        text: 'Parece tenemos problemas, el ID del rol seleccionado no es encontrado en el sistema'
                        +' por favor verifica que seleccionas un ID valido, si el problema persiste informa a tu administrador '
                        +'o personal de TI.',
                        showConfirmButton: true
                    })
                }else{
                    $(".ckbMenu:checkbox").each(function(index, elemento){                    
                        for(let i=0; i<r.length; i++){
                           if($(elemento).val() == r[i]["id_menu"]){
                               $(elemento).prop("checked", true);
                           }
                       }
                   });
                }


                
            },
            error: function (r) {
                console.log(r.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar el menú asignado para este rol'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
            
        });
    }




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
                        defaultContent: '<button type="button" class="btn btn-spotify" id="btnMostrar"><i class="fa fa-eye"></i></button>'
                            
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

    /* esta función recorre todos los chekbox con clase .ckbAcciones
       crea un array con cada valor seleccionado y lo retorna  */
    function generarArrayAcciones(){
        //obtenemos el total de elementos inputs tipo chekbox con clase ckbAcciones
        var totalCkbAcc = $(".ckbAcciones:checkbox").length;
        //creamos el array
        var accionesArray = [];
        //creamos contador para ir manejando el número de elementos seleccionados
        var count = parseInt(0);
        //creamos una variable para controlar que se seleccione almenos un chekbox
        var countSelectCkbx = parseInt(0);
        //recorremos y verificamos si almenos un ckbx de acción está seleccionado
        $(".ckbAcciones:checkbox").each(function(index, elemento){
            if($(elemento).is(":checked")){
                //si está seleccionado el elemento actual del recorrido
                //evaluamos si es el último o no
                if(index != (totalCkbAcc-1)){
                    // si no es el último, asignamos la posicion de count con el valor del elemento actual
                    accionesArray[count] = $(elemento).val();
                    //incrementamos en 1 count
                    count++;
                    //incrementamos en 1 la cantidad de ckbx seleccionados
                    countSelectCkbx++;
                }else{
                    //en caso sea el último simplemente se crea el array
                    //con posición 0 (será 0 ya que si el último está seleccionado, los demás se desmarcan)
                    accionesArray[0] = $(elemento).val();
                    //incrementamos en 1 la cantidad de ckbx seleccionados
                    countSelectCkbx++;
                }
            
            }
        });

        if(countSelectCkbx ==0){
            //si no se ha incrementado la cantidad de ckbx seleccionado
            //retornamos 0 para pedir que seleccione almenos 1 opción
            return 0;
        }else{
            //retornamos el arreglo
            return accionesArray;
        }

    }

    /* esta función recorre todos los chekbox con clase .ckbMenu
    crea un array con cada valor seleccionado y lo retorna  */
    function generarArrayMenu(){
        //creamos el array
        var menuArray = [];
        //creamos contador para ir manejando el número de elementos seleccionados
        var count = parseInt(0);
        //creamos una variable para controlar que se seleccione almenos un chekbox
        var countSelectCkbx = parseInt(0);
        //recorremos y verificamos si almenos un ckbx de menu está seleccionado
        $(".ckbMenu:checkbox").each(function(index, elemento){
            if($(elemento).is(":checked")){
                //si está seleccionado el elemento actual del recorrido, lo anexamos al array
                menuArray[count] = $(elemento).val();
                //incrementamos count y cantidad de chekbox seleccionados
                count++;
                countSelectCkbx++;
            }
        });

        if(countSelectCkbx==0){
            return 0;
        }else{
            //retornamos el arreglo
            return menuArray;
        }

    }

    /*esta función solicita la carga de roles de BD, crea array y lo retorna por función
    callback de ajax  para validar que no se ingrese un rol repetido */
    function validarRolNoRegistrado(callback){
        //pasamos un parametro que serpa una función en este caso callback
        $.ajax({
            url:"../controladores/rolesPermisosControlador.php",
            method: "post",
            dataType: "json",
            data: { "key": "obtenerRoles"},
            success: function (r) {
                //si tiene respuesta validad del server creamos arreglo
                var roles = [];
                for(let i =0; i<r.length; i++){
                    //llenamos arreglo con los datos
                    roles[i] = r[i]["rol_nombre"];
     
                }
                //llamamos al parametro que pasa a ser una función que resive el parametro que es
                //el arreglo creado
                callback(roles);
            },
            error: function (r) {
                console.log(r)
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y validar los roles ingresados en el sistema'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });
        
      
    }

    //esta función obtiene una cadena string, convierte su primer letra a mayuscula
    //y retorna el nuevo valor
    function convertirPrimerLetraMayus(valor){
        var primerCaracter = valor.charAt().toUpperCase();
        var restoDeLaCadena = valor.substring(1, valor.length);
        var rolIngresado = primerCaracter.concat(restoDeLaCadena);

        return rolIngresado;
    }
});
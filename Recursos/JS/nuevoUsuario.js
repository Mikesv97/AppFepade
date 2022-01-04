
$(document).ready(function(){
    //llamamos las funciones que deben ejecutarse en la carga de la pag.
    cargarRoles();
    esconderControles();
    cargarUsuario();

    $("body").on("click","#btnEliminar",function(e){
        e.preventDefault();
        $("#btnEliminar").blur();
        Swal.fire({
            title: '¿Estás seguro de eliminar este usuario?',
            text: "¡No podrás deshacer los cambios!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
          }).then((result) => {
            if (result.isConfirmed) {

                var table = $('#usuarios').DataTable();
                var data = table.row(this).data();
                var id =data["usuario_id"];
                eliminarUsuario(id);
            }
          })
    });

    //ocultamos columnas en base al rol
    ocultarColumTableUsuario();
    
    //cuando hace clic en el btn nuevo usuario
    $("#frmNuevoUsuario").submit(function(e){
        //cancelo submit del form
        //el submit es para que el required funcione
        e.preventDefault();
        if($("#txtPassword1").val() != $("#txtPassword2").val()){
            $("#lbError").text("Las contraseñas no coinciden");
            $("#lbError").show();
        }else if($("#selectRol").val() =="0"){
            $("#lbError").text("Debes escoger un rol para el usuario");
            $("#lbError").show();
        }else{
            //obtenemos los datos del form
            var data = $("#frmNuevoUsuario").serialize();
            $.ajax({
                url:"../controladores/controladorNuevoUsuario.php",
                method: "post",
                dataType: "json",
                data: { "key": "insertarUsuario","data": data },
                success: function (r) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Usuario creado con éxtio',
                        showConfirmButton: false,
                        timer: 1500
                      })
                      $("#frmNuevoUsuario")[0].reset();
                      $('#usuarios').DataTable().ajax.reload();
                },
                error: function (r) {
                    console.log(r);
                }
            });
        }
    });
    
    

    //función que solicita la carga de roles y setea el select en la vista
    function cargarRoles(){
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "getRoles" },
            success: function (r) {
                for(let i=0; i<r.length; i++){
                    var option = '<option value="'+r[i]["id_rol"]+'">'+r[i]["rol_nombre"]+'</option>';
                    $("#selectRol").append(option);
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
    }
    //función que esconde controles que no deben ser visibles en la carga de la pag.
    function esconderControles(){
        $("#lbError").hide();
    }

    //función que solicita por ajax la carga de usuarios
    //y carga la tabla automáticamente con DataTable
    function  cargarUsuario() {
        $.noConflict(true);
        $('#usuarios').DataTable({
                "ajax":{
                    "url": "../controladores/controladorNuevoUsuario.php",
                    "method": "post",
                    "dataType": "json",
                    "data": { "key": "getUsuarios" },
                    "dataSrc": ""
                },
                "columns": [
                    {
                        data: "usuario_id",
                        className: "usuarioId"
                    },
                    {
                        data: "usuario_nombre",
                        className: "nombreUsuario"
                    },
                    {
                        data: "usuario_fecha",
                        className: "usuarioFecha"
                    },
                    {
                        data:"correo_electronico",
                        className: "usuarioCorreo"
                    },
                    {
                        data: "rol_nombre",
                        className: "usuarioRol"
                    },
                    {
                        data: "usuario_responsable",
                        className: "usuarioResponsable"
                    },
                    {
                        data: null,
                        className: "center",
                        defaultContent: '<button id="btnEliminar" class="btn btn-danger noHover">Eliminar</button>'
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

    //función que envía ID para eliminar el registro
    function eliminarUsuario(id){
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "eliminarUsuario","id": id },
            success: function (r) {
                switch(r){
                    case "nullId":
                        Swal.fire({
                            icon: 'error',
                            title: "Usuario no encontrado",
                            text: 'El id del usuario no se encuentra en la base de datos'+
                            ' asegúrate de que su id sea correcto e intenta de nuevo, si el problema'+
                            ' persiste contacta con tu administrador o personal de TI.',
                            showConfirmButton: true
                        })
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    case "userSesOn":
                        Swal.fire({
                            icon: 'error',
                            title: "Usuario con sesión activa",
                            text: 'No se puede eliminar el usuario debido a que tiene una sesión activa en estos momentos, por favor'
                            +' intenta cuando no este on-line, sí crees que se trata de algún problema por favor contacta a tu administrador o personal de TI.',
                            showConfirmButton: true
                        })
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    case true:
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Usuario eliminado con éxtio',
                            showConfirmButton: false,
                            timer: 1500
                          })
                        $("#frmNuevoUsuario")[0].reset();
                        $('#usuarios').DataTable().ajax.reload();
                    break;
                    
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: "Problemas de comunicación",
                    text: 'Parece tenemos problemas para comunicarnos con los servidores y eliminar el usuario'
                    +' por favor verifica tu conexión de internet e intenta de nuevo.',
                    showConfirmButton: true
                })
            }
        });          
    }
    
    //función que oculta columnas de DataTable según el rol que inicia sesión
    function ocultarColumTableUsuario(){
        //creamos instancia a las tablas para acceder a sus columnas
        var dt= $('#usuarios').DataTable();

        //ocultamos columnas de inicio para mostrarlas según sus permisos
        dt.columns(6).visible(false);
 
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
                        case "eliminar":
                            dt.columns(6).visible(true);
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
});

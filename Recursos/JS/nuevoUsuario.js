
$(document).ready(function(){

    //llamamos las funciones que deben ejecutarse en la carga de la pag.
    cargarRoles();
    esconderControles();
    cargarUsuario();

    $("body").on("click","#btnEliminar",function(e){
        e.preventDefault();
        $("#btnEliminar").blur();
        Swal.fire({
            title: 'Estás seguro de eliminar este registro?',
            text: "¡No podrás deshacer los cambios!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
            }
          })
    });

    $("body").on("click",".odd, .even",function(){
       alert("kya");
    });

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
                data: { "key": "insertatUsuario","data": data },
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

    
});

//length
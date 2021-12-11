$(document).ready(function(){
    //llamamos las funciones que deben ejecutarse en la carga de la pag.
    cargarRoles();
    esconderControles();

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

    
    //función que solicita la carga de roles y setea el select en la vista
    function cargarUsuarios(){
        $.ajax({
            url:"../controladores/controladorNuevoUsuario.php",
            method: "post",
            dataType: "json",
            data: { "key": "getUsuarios" },
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

    
});

//length
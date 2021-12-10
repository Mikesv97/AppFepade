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

    //comprobar controles no vengan vacíos
    function validarInputs(){

        if($("#selectRol").val() =="0"){
            $("#lbError").text("Debes escoger un rol para el usuario");
            $("#lbError").show();
        }else if($("#txtPassword1").val() != $("#txtPassword2").val()){
            $("#lbError").text("Las contraseñas no coinciden");
            $("#lbError").show();
        }else if($("#txtPassword1").val()==""){
            $("#lbError").text("Debes ingresar una contraseña");
            $("#lbError").show();
        }else if($("#txtNombreUser").val()=="" || $("#txtCorreoUsuario").val()=="" || $("#txtIdUser").val()=="" ){
            $("#lbError").text("No puedes dejar ningún campo vacío");
            $("#lbError").show();
        }

        
    }
});

//length
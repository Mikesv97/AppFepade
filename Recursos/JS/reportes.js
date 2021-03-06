$(document).ready(function(){
   //cargamos el select de tipo de activos
    cargarCmbTipoActivos();
    //ocultamos label de errores
    $("#labelError").hide();

    //cargamos el select de áreas
    cargarCmbAreasActivos();

    //al cambio de option en selec pasamos valor
    //al input escondido para manejar impresión de nombre de área
    //en el reporte
    $("#sAreas").change(function(){
        $("#hdnNameArea").val($("#sAreas option:selected").text().trim());
    });


    //al cambio de option en selec pasamos valor
    //al input escondido para manejar el nombre de tipo activo
    $("#sTipoActivoR").change(function(){
        if($("#labelError").is(":visible")){
            $("#labelError").hide();
        }
        $("#hdnNameAct").val($("#sTipoActivoR option:selected").text().trim());
    });

});


//solicita datos y carga el select de tipo activo
function cargarCmbTipoActivos(){
    $.ajax({
        url:"../controladores/tipoActivoControlador.php",
        method: "post",
        dataType: "json",
        data: { "key": "mostrar"},
        success: function (r) {
           for(let i=0; i<r.length; i++){
               var option = '<option value="'+r[i]["tipo_activo_id"]+'">'+r[i]["tipo_activo_nombre"]+'</option>';
                if(i==0){
                    $('#hdnNameTipAct').val(r[i]["tipo_activo_nombre"]);
                }
               $("#sTipoActivoR").append(option);
               $("#sTipoActivoR2").append(option);
           }
        },
        error: function (r) {
            //console.log(r.responseText);
            Swal.fire({
                icon: 'error',
                title: "Problemas de comunicación",
                text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar la lista de tipo activos'
                +' por favor verifica tu conexión de internet e intenta de nuevo.',
                showConfirmButton: true
            })
    }
});  
}

//solicita datos y carga el select de área
function cargarCmbAreasActivos(){
    $.ajax({
        url:"../controladores/activoFijoControlador.php",
        method: "post",
        dataType: "json",
        data: { "key": "getInfAreas"},
        success: function (r) {
           for(let i=0; i<r.length; i++){
               if(i==0){
                $("#hdnNameArea").val(r[i]["estructura31_nombre"].trim());
                $("#hdnNomArea").val(r[i]["estructura31_nombre"].trim());
                $("#hdnNameAreaMant").val(r[i]["estructura31_nombre"].trim());
               }

               var option = '<option value="'+r[i]["estructura31_id"]+'">'+r[i]["estructura31_nombre"]+'</option>';
               $("#sAreas").append(option);
               $("#sAreaRpt").append(option);
               $("#sRptAreMant").append(option);
           }
        },
        error: function (r) {
            //console.log(r.responseText);
            Swal.fire({
                icon: 'error',
                title: "Problemas de comunicación",
                text: 'Parece tenemos problemas para comunicarnos con los servidores y cargar la lista de áreas'
                +' por favor verifica tu conexión de internet e intenta de nuevo.',
                showConfirmButton: true
            })
    }
});  
}
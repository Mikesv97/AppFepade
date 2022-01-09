$(document).ready(function(){
   //cargamos el select de tipo de activos
    cargarCmbTipoActivos();
    
    //cargamos el select de áreas
    cargarCmbAreasActivos();

    //al cambio de option en selec pasamos valor
    //al input escondido para manejar impresión de nombre de área
    //en el reporte
    $("#sAreas").change(function(){
        $("#hdnNameArea").val($("#sAreas option:selected").text().trim());
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
               }

               var option = '<option value="'+r[i]["estructura31_id"]+'">'+r[i]["estructura31_nombre"]+'</option>';
               $("#sAreas").append(option);
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
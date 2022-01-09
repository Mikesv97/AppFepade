$(document).ready(function(){
    //PDFObject.embed("../recursos/reportes/reporteTipoActivo_19-12-2021_06-12-46 pm.pdf", "#pdfRenderer");
    cargarCmbTipoActivos();
    
    cargarCmbAreasActivos();

});


//carga el select de tipo activo
function cargarCmbTipoActivos(){
    $.ajax({
        url:"../controladores/tipoActivoControlador.php",
        method: "post",
        dataType: "json",
        data: { "key": "mostrar"},
        success: function (r) {
            console.log("asddad");
           for(let i=0; i<r.length; i++){
               var option = '<option value="'+r[i]["tipo_activo_id"]+'">'+r[i]["tipo_activo_nombre"]+'</option>';

               $("#sTipoActivoR").append(option);
           }
        },
        error: function (r) {
            console.log(r.responseText);
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

//carga el select de área
function cargarCmbAreasActivos(){
    $.ajax({
        url:"../controladores/activoFijoControlador.php",
        method: "post",
        dataType: "json",
        data: { "key": "getInfAreas"},
        success: function (r) {
            console.log("asddad");
           for(let i=0; i<r.length; i++){
               var option = '<option value="'+r[i]["estructura31_id"]+'">'+r[i]["estructura31_nombre"]+'</option>';

               $("#sAreas").append(option);
           }
        },
        error: function (r) {
            console.log(r.responseText);
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
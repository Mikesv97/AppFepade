$(document).ready(function () {

    
    $('#formActivo').submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#formActivo')[0]);
        formData.append("key", "insertar");
        formData.append("tipoActivo", $('#ActivoTipo').val());
        $.ajax({
            type: 'POST',
            url: "../Controladores/activoFijoControlador.php",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (r) {
                console.log(r);
                switch (r) {
                    case '1':
                        Swal.fire({
                            title: 'Ingresar activo al sistema',
                            text: "Porfavor confirma para ingresar el activo al sistema",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ingresasr'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Activo ingresado!',
                                    'El activo a sido ingresado al sistema',
                                    'success'
                                ).then(function () {
                                    $("#formActivo")[0].reset();
                                })
                            }
                        })
                        break;
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
    });


});
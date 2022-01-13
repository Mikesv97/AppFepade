$.noConflict();
jQuery(document).ready(function ($) {

    $('#frmInvenAct').submit(function (e) {
        //detenemos el envio del form
        e.preventDefault();
        //en caso que no, se pregunta si quiere insertarlo

        var formData = new FormData($('#frmInvenAct')[0]);
        formData.append("key", "insertar");
        $.ajax({
            type: 'POST',
            url: "../Controladores/inventarioControlador.php",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (r) {
                console.log(r);
                switch (r) {
                    case "InsertadoInventario":
                        Swal.fire(
                            'Invenario ingresado!',
                            'El inventario ha sido ingresado al sistema',
                            'success'
                        )
                        $("#frmTipoActivo")[0].reset();
                        $('#tblTipoActivo').DataTable().ajax.reload();
                        break;
                    case "FailInventario":
                        Swal.fire({
                            title: '¡Problemas técnicos!',
                            text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta el inventario'
                                + ' si el problema persiste contacta a tu administrador o soporte IT.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                        })
                        break;
                }
            },
            error: function (r) {
                console.log(r);
                Swal.fire({
                    title: '¡Problemas técnicos!',
                    text: '¡Vaya! Parece que tenemos dificultades técnicas para inserta el inventario'
                        + ' si el problema persiste contacta a tu administrador o soporte IT.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                })
            }
        });

    });

});
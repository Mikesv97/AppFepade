$.noConflict();
jQuery(document).ready(function ($) {

    //PARA CARGAR LA FECHA ACTUAL CUANDO SE CARGA LA PAGINA
    function zeroPadded(val) {
        if (val >= 10)
            return val;
        else
            return '0' + val;
    }
    var d = new Date();
    $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));

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
                            'Activo inventariado!',
                            'El activo ha sido agregado al inventario con exito',
                            'success'
                        )
                        $("#frmInvenAct")[0].reset();
                        //PARA DESACTIVAR LA CAMARA UNA VEZ SE INSERTAR UN ACTIVO
                        function zeroPadded(val) {
                            if (val >= 10)
                                return val;
                            else
                                return '0' + val;
                        }
                        var d = new Date();
                        $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));
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

    //CUANDO SE CANCELA UN INVENTARIO
    $('#btnCancelar').on('click', function(){
        $("#frmInvenAct")[0].reset();
        $('#mostrarEscaneo').addClass('collapse');
        $('#mostrarEscaneo').removeClass('show');
        function zeroPadded(val) {
            if (val >= 10)
                return val;
            else
                return '0' + val;
        }
        var d = new Date();
        $('input[type=date]').val(d.getFullYear()+"-"+zeroPadded(d.getMonth() + 1)+"-"+zeroPadded(d.getDate()));
        //PARA DETENER LA DETECION DE CAMARA
        Quagga.stop();
    });

});
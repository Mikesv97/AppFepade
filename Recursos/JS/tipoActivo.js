$(document).ready(function () {
    var tipo;
    $('#tipoactivo').hide();
    $('#tipoactivo').val('computadora');
    $('#computadora').show();
    $('#proyector').hide();
    $('#impresora').hide();
    //COMPRUEBA QUE TIPO DE ACTIVO SE SELECIONA
    $('#comboTipoActivo').on('change', function () {
        tipo = $(this).val();
        switch (tipo) {
            case '1':
                $('#impresora').hide();
                $('#computadora').show();
                $('#proyector').hide();
                $('#tipoactivo').val('computadora');
                break;
            case '2':
                $('#impresora').hide();
                $('#computadora').show();
                $('#proyector').hide();
                $('#tipoactivo').val('computadora');
                break;
            case '3':
                $('#impresora').show();
                $('#computadora').hide();
                $('#proyector').hide();
                $('#tipoactivo').val('impresora');
                break;
            case '4':
                $('#proyector').show();
                $('#computadora').hide();
                $('#impresora').hide();
                $('#tipoactivo').val('proyector');
                break;
            default:

                break;
        }
    });

});
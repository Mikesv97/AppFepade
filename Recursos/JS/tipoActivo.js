$(document).ready(function () {
    var tipo;
    $('#tipoactivo').hide();
    $('#tipoactivo').val('computadora');
    $('#computadora').show();
    $('#proyector').hide();
    $('#impresora').hide();
    //COMPRUEBA QUE TIPO DE ACTIVO SE SELECIONA
    $('#ActivoTipo').on('change', function () {
        tipo = $(this).val();
        switch (tipo) {
            case '1':
                $('#Impresor').hide();
                $('#PC').show();
                $('#Proyector').hide();
                $('#tipoactivo').val('PC');
                break;
            case '2':
                $('#Impresor').hide();
                $('#PC').show();
                $('#Proyector').hide();
                $('#tipoactivo').val('Laptop');
                break;
            case '3':
                $('#Impresor').show();
                $('#PC').hide();
                $('#Proyector').hide();
                $('#tipoactivo').val('Impresor');
                break;
            case '4':
                $('#Proyector').show();
                $('#PC').hide();
                $('#Impresor').hide();
                $('#tipoactivo').val('Proyector');
                break;
            default:

                break;
        }
    });

});
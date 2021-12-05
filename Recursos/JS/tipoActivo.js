$(document).ready(function() {
    var tipo;
    $('#computadora').show();
    $('#proyector').hide();
    $('#impresora').hide();
    $('#comboTipoActivo').on('change', function() {
        tipo = $(this).val();
        switch (tipo) {
            case '3':
                $('#impresora').show();
                $('#computadora').hide();
                $('#proyector').hide();
                break;
            case '4':
                $('#proyector').show();
                $('#computadora').hide();
                $('#impresora').hide();
                break;
            default:

                break;
        }
    });

});
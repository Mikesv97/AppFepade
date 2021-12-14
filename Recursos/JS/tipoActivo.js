$(document).ready(function () {
    var tipo;
    desabilitarInputPc(false);
    desabilitarInputImpresora(true);
    desabilitarInputProyector(true);
    //COMPRUEBA QUE TIPO DE ACTIVO SE SELECIONA
    $('#ActivoTipo').on('change', function () {
        tipo = $(this).val();
        switch (tipo) {
            case '1':
                desabilitarInputPc(false);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                break;
            case '2':
                desabilitarInputPc(false);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                break;
            case '3':
                desabilitarInputPc(true);
                desabilitarInputImpresora(false);
                desabilitarInputProyector(true);
                break;
            case '4':
                desabilitarInputPc(true);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(false);
                break;
            default:
                desabilitarInputPc(false);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                break
        }
    });
});

function desabilitarInputPc(desabilitar) {
    if (desabilitar) {
        $('input[name=Procesador]').addClass('desabilitado');
        $('input[name=Generacion]').addClass('desabilitado')
        $('input[name=Ram]').addClass('desabilitado');
        $('input[name=TipoRam]').addClass('desabilitado');
        $('input[name=DiscoDuro]').addClass('desabilitado');
        $('input[name=CapacidadD1]').addClass('desabilitado');
        $('input[name=DiscoDuro2]').addClass('desabilitado');
        $('input[name=CapacidadD2]').addClass('desabilitado');
        $('input[name=Office]').addClass('desabilitado');
        $('input[name=SO]').addClass('desabilitado');
    } else {
        $('input[name=Procesador]').removeClass('desabilitado');
        $('input[name=Generacion]').removeClass('desabilitado')
        $('input[name=Ram]').removeClass('desabilitado');
        $('input[name=TipoRam]').removeClass('desabilitado');
        $('input[name=DiscoDuro]').removeClass('desabilitado');
        $('input[name=CapacidadD1]').removeClass('desabilitado');
        $('input[name=DiscoDuro2]').removeClass('desabilitado');
        $('input[name=CapacidadD2]').removeClass('desabilitado');
        $('input[name=Office]').removeClass('desabilitado');
        $('input[name=SO]').removeClass('desabilitado');
    }
    $('input[name=Procesador]').attr('disabled', desabilitar)
    $('input[name=Generacion]').attr('disabled', desabilitar)
    $('input[name=Ram]').attr('disabled', desabilitar)
    $('input[name=TipoRam]').attr('disabled', desabilitar)
    $('input[name=DiscoDuro]').attr('disabled', desabilitar)
    $('input[name=CapacidadD1]').attr('disabled', desabilitar)
    $('input[name=DiscoDuro2]').attr('disabled', desabilitar)
    $('input[name=CapacidadD2]').attr('disabled', desabilitar)
    $('input[name=Office]').attr('disabled', desabilitar)
    $('input[name=SO]').attr('disabled', desabilitar)
}


function desabilitarInputProyector(desabilitar) {
    if (desabilitar) {
        $('input[name=HorasUso]').addClass('desabilitado');
        $('input[name=HoraEco]').addClass('desabilitado');
    } else {
        $('input[name=HorasUso]').removeClass('desabilitado');
        $('input[name=HoraEco]').removeClass('desabilitado');
    }
    $('input[name=HorasUso]').attr('disabled', desabilitar)
    $('input[name=HoraEco]').attr('disabled', desabilitar)
}

function desabilitarInputImpresora(desabilitar) {
    if (desabilitar) {
        $('input[name=TonerN]').addClass('desabilitado');
        $('input[name=TonerM]').addClass('desabilitado');
        $('input[name=TonerC]').addClass('desabilitado');
        $('input[name=TonerA]').addClass('desabilitado');
        $('input[name=tambor]').addClass('desabilitado');
        $('input[name=fusor]').addClass('desabilitado');
    } else {
        $('input[name=TonerN]').removeClass('desabilitado');
        $('input[name=TonerM]').removeClass('desabilitado');
        $('input[name=TonerC]').removeClass('desabilitado');
        $('input[name=TonerA]').removeClass('desabilitado');
        $('input[name=tambor]').removeClass('desabilitado');
        $('input[name=fusor]').removeClass('desabilitado');
    }
    $('input[name=TonerN]').attr('disabled', desabilitar)
    $('input[name=TonerM]').attr('disabled', desabilitar)
    $('input[name=TonerC]').attr('disabled', desabilitar)
    $('input[name=TonerA]').attr('disabled', desabilitar)
    $('input[name=tambor]').attr('disabled', desabilitar)
    $('input[name=fusor]').attr('disabled', desabilitar)
}
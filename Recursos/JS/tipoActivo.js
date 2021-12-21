$(document).ready(function () {
    var tipo;
    desabilitarInputPc(false, true);
    desabilitarInputImpresora(true);
    desabilitarInputProyector(true);
    desabilitarIp(false, true)
    //COMPRUEBA QUE TIPO DE ACTIVO SE SELECIONA
    $('#ActivoTipo').on('change', function () {
        tipo = $(this).val();
        switch (tipo) {
            case '1':
                desabilitarInputPc(false, true);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                desabilitarIp(false, true)
                break;
            case '2':
                desabilitarInputPc(false, true);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                desabilitarIp(false, true)
                break;
            case '3':
                desabilitarInputPc(true);
                desabilitarInputImpresora(false, true);
                desabilitarInputProyector(true);
                desabilitarIp(false, true)
                break;
            case '4':
                desabilitarInputPc(true);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(false, true);
                desabilitarIp(true, false)
                break;
            default:
                desabilitarInputPc(false, true);
                desabilitarInputImpresora(true);
                desabilitarInputProyector(true);
                desabilitarIp(false, true)
                break
        }
    });
});

function desabilitarInputPc(desabilitar, requerido) {
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
    $('input[name=Procesador]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=Generacion]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=Ram]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=TipoRam]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=DiscoDuro]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=CapacidadD1]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=DiscoDuro2]').attr('disabled', desabilitar)
    $('input[name=CapacidadD2]').attr('disabled', desabilitar)
    $('input[name=Office]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=SO]').attr({'disabled': desabilitar, 'required': requerido})
}

function desabilitarInputProyector(desabilitar, requerido) {
    if (desabilitar) {
        $('input[name=HorasUso]').addClass('desabilitado');
        $('input[name=HoraEco]').addClass('desabilitado');
    } else {
        $('input[name=HorasUso]').removeClass('desabilitado');
        $('input[name=HoraEco]').removeClass('desabilitado');
    }
    $('input[name=HorasUso]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=HoraEco]').attr({'disabled': desabilitar, 'required': requerido})
}

function desabilitarInputImpresora(desabilitar, requerido) {
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
    $('input[name=TonerN]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=TonerM]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=TonerC]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=TonerA]').attr({'disabled': desabilitar, 'required': requerido})
    $('input[name=tambor]').attr({'disabled': desabilitar})
    $('input[name=fusor]').attr({'disabled': desabilitar})
}

function desabilitarIp(desabilitar, requerido){
    if(desabilitar){
        $('input[name=ip').addClass('desabilitado');
    }else{
        $('input[name=ip]').removeClass('desabilitado');
    }
    $('input[name=ip]').attr({'disabled': desabilitar, 'required': requerido})
}
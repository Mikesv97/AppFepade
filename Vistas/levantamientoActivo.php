<?php
include('layout/header.php');
include('layout/navbar.php');

$usuario = $_SESSION["usuario"]["nombre"];
$idUSuario = $_SESSION["usuario"]["id"];
?>

<!-- Cargamos Quagga y luego nuestro script -->
<link href="../recursos/css/nuevoUsuario.css" rel="stylesheet">
<script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>
<script src="../Recursos/JS/lavantamientoActivo.js"></script>
<script src="../Recursos/JS/inventario.js"></script>

<style>
    #contenedor video {
        max-width: 100%;
        width: 100%;
    }

    #contenedor {
        max-width: 100%;
        position: relative;
    }

    canvas {
        max-width: 100%;
    }

    canvas.drawingBuffer {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <a href="" id="inicioFormTipoAct"></a>
        <!--barra top -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $usuario; ?>!</h4>
                    <p class="mb-0 rol">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
                    <a href="" id="inicioForm"></a>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tipo de activo</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--cuerpo form -->
        <div class="row page-titles mx-0 justify-content-center">
            <div class="col-sm-6 p-md-0">
                <div class="text-center">
                    <div class="vistaTitulo">
                        <h1 class="text-gray-900 my-2 mb-4">Levantamiento De Activo</h1>
                    </div>
                </div>

                <button type="button" class="btn btn-dark mb-5 ml-4" data-toggle="collapse" href="#mostrarEscaneo" aria-controls="mostrarEscaneo" id="verEscaneo">
                    Escanear codigo de barra
                </button>

                <div class="col-xl-12 col-xxl-12 collapse" id="mostrarEscaneo">
                    <p id="resultado">Aquí aparecerá el código</p>
                    <div id="contenedor"></div>
                </div>

                <form id="frmInvenAct" class="my-4" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtCodigoBarra">Codígo de barra*</label>
                            <input type="text" class="form-control" id="txtCodigoBarra" name="txtCodigoBarra" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fechaCodBarra">Fecha*</label>
                            <input id="fechaCodBarra" type="date" name="fechaCodBarra" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="alertError my-2" role="alert" id="lbError"></p>
                    </div>
                    <div class="col-md-4 my-3 respMr">
                        <button type="submit" class="outLineRed btn" id="btnInsertar" name="btnInsertarCodBarra">Ingresar</button>
                    </div>
                    <div class="col-md-4 my-3 respMr">
                        <button type="button" class="outLineRed btn" id="btnCancelar" name="btnCancelar">Cancelar</button>
                    </div>
                </form>


            </div>
        </div>
        <!-- fin cuerpo form -->

    </div>
</div>



<?php
include('layout/footer.php');
?>
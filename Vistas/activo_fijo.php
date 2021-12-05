<?php
include('layout/header.php');
include('layout/navbar.php');
?>
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $_SESSION["usuario"]["nombre"]; ?>!</h4>
                    <p class="mb-0">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ingreso de activo nuevo</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" id="step-form-horizontal" class="step-form-horizontal">
                            <div>
                                <h4>Informacion de activo</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="number" name="referencia" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Codigo Contabilidad*</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Codigo para proyectos*</label>
                                                <input type="text" name="codProyectos" class="form-control" placeholder="123456">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Numero de serie*</label>
                                                <input type="text" name="numSerie" class="form-control" placeholder="123456">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Codigo Automatico*</label>
                                                <input type="text" name="codAutomatico" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label for="party">Fecha de adquisicion</label>
                                                <input id="party" type="datetime-local" name="fechaAdq" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Numero de factura*</label>
                                                <input type="text" name="numFactura" class="form-control" placeholder="123456">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Tipo de activo*</label>
                                                <select class="form-control" name="tipo" required>
                                                    <option selected></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">IP*</label>
                                                <input type="text" name="ip" class="form-control" placeholder="192.168.137.1" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Descripcion del activo</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Usuario*</label>
                                                <input type="number" name="usuario" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Modelo*</label>
                                                <input type="text" name="modelo" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Departamento*</label>
                                                <select class="form-control" name="departamento" required>
                                                    <option selected></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">F.F.</label>
                                                <select class="form-control" name="ff" required>
                                                    <option selected></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Area</label>
                                                <select class="form-control" name="area" required>
                                                    <option selected></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Descripcion de activo*</label>
                                                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Equipo de computo</h4>
                                <section>
                                <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Procesador*</label>
                                                <input type="number" name="procesador" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Generacion*</label>
                                                <input type="text" name="generacion" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">RAM*</label>
                                                <input type="number" name="ram" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Tipo de RAM*</label>
                                                <input type="text" name="tipoRam" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Disco Duro*</label>
                                                <input type="number" name="disco" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Sistema Operativo*</label>
                                                <input type="text" name="sistema" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Office*</label>
                                                <input type="number" name="office" class="form-control" placeholder="12345678" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Otros datos*</label>
                                                <input type="text" name="otros" class="form-control" placeholder="123456" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <button type="submit" value="MANDAR"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../Recursos/JS/scriptPlantilla/activoFijo.js"></script>
<!--**********************************
            Content body end
        ***********************************-->
<?php
include('layout/footer.php');
?>
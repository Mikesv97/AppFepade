 <?php
    include('layout/header.php');
    include('layout/navbar.php');
 ?>
   <link href="../recursos/css/rolesPermisos.css" rel="stylesheet">
   <script src="../Recursos/JS/rolesPermisos.js"></script>
 <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                        <a href="" id="inicioForm"></a>
                            <h4>Bienvenido <?=$_SESSION["usuario"]["nombre"];?>!</h4>
                            <p class="mb-0">Rol: <?=$_SESSION["usuario"]["rol"];?></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Roles y permisos</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row page-titles mx-0">
                    <div class="col-md-6 p-md-0 mx-auto">
                        
                        <h2 class="text-center mb-3">Roles del sistema</h2>
                         <form id="frmRoles">
                            <div class="form-group">
                                <input type="number" id="txtId" hidden>
                                <label for="exampleInputEmail1"><strong>Nombre del rol</strong></label>
                                <input type="text" class="form-control" id="txtNombreRol" maxlength="12" name="txtNombreRol"  placeholder="Nombre del rol max (12 caracteres)" required>
                            </div>
                            <div class="form-group">
                                <label for="txtDescRol"><strong>Descripción del rol</strong></label>
                                <textarea class="form-control" id="txtDescRol" name="txtDescRol" maxlength="255" placeholder="Descripcioón de rol max (255 caracteres)" required></textarea>
                            </div>
                            <div class="col-md-12"><p class="alertError my-2" role="alert" id="labelError"></p></div>
                            <label for="grupoCheckBox"><strong>Selecciona las acciones que tendrá este rol en el sistema</strong></label>
                            <div class="form-check" id="grupoCkbAcciones">
                            <ul id="grupoCkbAcciones">

                                </ul>
                            </div>
                            <label class="my-3" for="grupoCheckBox"><strong>Selecciona el menú al que tendrá acceso este rol en el sistema</strong></label>
                            <div class="form-check" >
                                <ul id="grupoCkbMenu">

                                </ul>
                            </div>
                            <button type="submit" class="btnLogin my-4 btn btn-primary" id="btnIngresar">Ingresar</button>
                            <button type="button" class="btnLogin my-4 btn btn-primary" id="btnGuardar">Guardar</button>
                         </form>

                         <!--TABLA ROLES-->
                         <div class="my-4 table-responsive">
                            <table id="tblRoles" class='table table-striped dt-responsive nowrap' style='width:100%;'>
                                <thead>
                                    <tr>
                                        <th>Rol id</th>
                                        <th>Nombre rol</th>
                                        <th>Descripción</th>
                                        <th>Ver más detalles</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="borderIzq offset-md-1 col-md-5">
                        <div class="ml">
                        <h2 class="text-center">Menú del sistema</h2>
                         <form id="frmRoles">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre del menú</label>
                                <input type="text" class="form-control" id="txtNombreRol" maxlength="12" name="txtNombreRol"  placeholder="Nombre del rol max (12 caracteres)">
                            </div>
                            <button type="submit" class="btnLogin my-2 btn btn-primary">Ingresar</button>
                         </form>

                         <!--TABLA ROLES-->
                         <div class="table-responsive">
                            <table id="tblRoles" class='table table-striped dt-responsive nowrap'>
                                <thead>
                                    <tr>
                                        <th>Menú id</th>
                                        <th>Nombre menú</th>
                                        <th>Dirección web</th>
                                        <th>Contenedor padre</th>
                                        <th>Ver más detalles</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        <?php
    include('layout/footer.php');
 ?>
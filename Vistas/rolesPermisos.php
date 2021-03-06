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
                    <div class="col-md-5 p-md-0 mx-auto">
                        
                        <h2 class="text-center mb-5 text-gray-900 my-4">Roles del sistema</h2>
                         <form id="frmRoles">
                            <div class="form-group">
                                <input type="number" id="txtId" hidden>
                                <label><strong>Nombre del rol</strong></label>
                                <input type="text" class="form-control" id="txtNombreRol" maxlength="12" name="txtNombreRol"  placeholder="Nombre del rol max (12 caracteres)" required>
                            </div>
                            <div class="form-group">
                                <label for="txtDescRol"><strong>Descripci??n del rol</strong></label>
                                <textarea class="form-control" id="txtDescRol" name="txtDescRol" maxlength="255" placeholder="Descripcio??n de rol max (255 caracteres)" required></textarea>
                            </div>
                            <div class="col-md-12"><p class="alertError my-2" role="alert" id="labelError"></p></div>
                            <label for="grupoCheckBox"><strong>Selecciona las acciones que tendr?? este rol en el sistema</strong></label>
                            <div class="form-check" id="grupoCkbAcciones">
                            <ul id="grupoCkbAcciones">

                                </ul>
                            </div>
                            <label class="my-3" for="grupoCheckBox"><strong>Selecciona el men?? al que tendr?? acceso este rol en el sistema</strong></label>
                            <div class="form-check" >
                                <ul id="grupoCkbMenu">

                                </ul>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="outLineRed my-3 btn" id="btnIngresar">Ingresar</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="outLineRed my-3 btn" id="btnGuardar">Guardar</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="my-3 mb-3 outLineRed btn" id="btnCancelar">Cancelar</button>
                            </div>
                         </form>

                         <!--TABLA ROLES-->
                         <div class="my-4 table-responsive">
                            <table id="tblRoles" class='table table-striped dt-responsive nowrap' style='width:100%;'>
                                <thead>
                                    <tr>
                                        <th>Rol id</th>
                                        <th>Nombre rol</th>
                                        <th>Descripci??n</th>
                                        <th>Ver m??s detalles</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="borderIzq  col-md-6">
                        <div class="ml">
                        <h2 class="text-center text-gray-900 my-4 mb-5">Men?? del sistema</h2>
                        <p class="advertensia">
                            <spam class="msjRed">Importante:</spam> al ingresar un nuevo men?? este no aparecer?? reflejado en las 
                            opciones de navegaci??n de la web, <spam class="msjRed">debes actualizar el o los roles</spam> que podr??n
                            acceder a este nuevo men?? para que salga reflejado cuando se inicie sesi??n 
                            con dicho rol.
                        </p>
                         <form id="frmMenu">
                            <div class="form-group">
                            <input type="number" id="txtIdMenu" hidden>
                                <label><strong>Nombre del men??</strong></label>
                                <input type="text" class="mn-2 form-control" id="txtNombreMenu" maxlength="50" name="txtNombreMenu"  placeholder="Nombre del men?? max (50 caracteres)" required>
                                <label class="my-1"><strong>Direcci??n a la que apunta</strong></label>
                                <input type="text" class="form-control" id="txtDireccionWeb" maxlength="255" name="txtDirecci??nWeb"  placeholder="https://www.direccion.com  ||  nombre.extensi??n" required>
                                <label class="my-1"><strong>Men?? padre</strong></label>
                                <input type="text" class="form-control" id="txtMenuPadre" maxlength="50" name="txtMenuPadre"  placeholder="Activos, reportes, usuarios y roles, etc" required>
                                <small class="my-1"><strong>Para que el men?? est?? fuera de alg??n contenedor, en<spam class="msjRed"> contenedor padre </spam> debes ingresar <spam class="msjRed">Global</spam>
                                de esta forma el men?? aparecer?? afuera sin contenedor.</strong></small>
                            </div>
                            <div class="col-md-12"><p class="alertError my-2 mb-2" role="alert" id="labelErrorMenu"></p></div>
                            <div class="col-md-4">
                                <button type="submit" id="btnIngresarMenu" class="outLineRed my-3 btn btn-primary">Ingresar</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="btnGuardarMenu" class="outLineRed my-3 btn btn-primary">Guardar</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="outLineRed btn my-3 mb-3" id="btnCancelarMenu">Cancelar</button>  
                            </div>
                         </form>

                         <!--TABLA ROLES-->
                         <div class="table-responsive">
                            <table id="tblMenus" class='table table-striped dt-responsive nowrap'>
                                <thead>
                                    <tr>
                                        <th>Men?? id</th>
                                        <th>Nombre men??</th>
                                        <th>Direcci??n web</th>
                                        <th>Contenedor padre</th>
                                        <th>Ver m??s detalles</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
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
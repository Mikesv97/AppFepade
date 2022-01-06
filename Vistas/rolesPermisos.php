 <?php
    session_start();
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
                        
                        <h2 class="text-center mb-3">Roles del sistema</h2>
                         <form id="frmRoles">
                            <div class="form-group">
                                <input type="number" id="txtId" hidden>
                                <label><strong>Nombre del rol</strong></label>
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
                        <h2 class="text-center">Menú del sistema</h2>
                        <p class="advertensia">
                            <spam class="msjRed">Importante:</spam> al ingresar un nuevo menú este no aparecerá reflejado en las 
                            opciones de navegación de la web, <spam class="msjRed">debes actualizar el o los roles</spam> que podrán
                            acceder a este nuevo menú para que salga reflejado cuando se inicie sesión 
                            con dicho rol.
                        </p>
                         <form id="frmMenu">
                            <div class="form-group">
                            <input type="number" id="txtIdMenu" hidden>
                                <label><strong>Nombre del menú</strong></label>
                                <input type="text" class="mn-2 form-control" id="txtNombreMenu" maxlength="50" name="txtNombreMenu"  placeholder="Nombre del menú max (50 caracteres)" required>
                                <label class="my-1"><strong>Dirección a la que apunta</strong></label>
                                <input type="text" class="form-control" id="txtDireccionWeb" maxlength="255" name="txtDirecciónWeb"  placeholder="https://www.direccion.com  ||  nombre.extensión" required>
                                <label class="my-1"><strong>Menú padre</strong></label>
                                <input type="text" class="form-control" id="txtMenuPadre" maxlength="50" name="txtMenuPadre"  placeholder="Activos, reportes, usuarios y roles, etc" required>
                            </div>
                            <div class="col-md-12"><p class="alertError my-2 mb-2" role="alert" id="labelErrorMenu"></p></div>
                            <button type="submit" id="btnIngresarMenu" class="btnLogin my-2 btn btn-primary">Ingresar menú</button>
                            <button type="button" id="btnGuardarMenu" class="btnLogin my-2 btn btn-primary">Guardar</button>
                         </form>

                         <!--TABLA ROLES-->
                         <div class="table-responsive">
                            <table id="tblMenus" class='table table-striped dt-responsive nowrap'>
                                <thead>
                                    <tr>
                                        <th>Menú id</th>
                                        <th>Nombre menú</th>
                                        <th>Dirección web</th>
                                        <th>Contenedor padre</th>
                                        <th>Ver más detalles</th>
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
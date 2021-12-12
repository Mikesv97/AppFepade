<!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
    <a href="index2.html" class="brand-logo">
        <img class="logo-abbr" src="../Recursos/Multimedia/Imagenes/logo.png" alt="">
        <img class="logo-compact" src="../Recursos/Multimedia/Imagenes/logo-text.png" alt="">
        <img class="brand-title" src="../Recursos/Multimedia/Imagenes/logo-text.png" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
            Nav header end
        ***********************************-->

<!--**********************************
            Header start
        ***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <span id="nombreUser"><?= $_SESSION["usuario"]["nombre"]; ?></span>
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="./app-profile.html" class="dropdown-item">
                                <i class="icon-user"></i>
                                <span class="ml-2">Profile </span>
                            </a>
                            <a id="cerrarLog" href="#" class="dropdown-item">
                                <i class="icon-key"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
            Header end ti-comment-alt
        ***********************************-->

<!--**********************************
            Sidebar start
        ***********************************-->
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Menu de navegación</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Activos</span></a>
                <ul aria-expanded="false">
                    <li><a href="activo_fijo.php">Ingresar nuevo activo</a></li>
                    <li><a href="infor_activo_fijo.php">Registro de activo</a></li>
                    <li><a href="#">Registro historial activo</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Usuario y roles</span></a>
                <ul aria-expanded="false">
                    <li><a href="nuevoUsuario.php">Registro de usuarios</a></li>
                </ul>
            </li>
            
        </ul>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
<?php

    if(isset($_SESSION["usuario"]["usuarioNuevo"])){
        if($_SESSION["usuario"]["usuarioNuevo"] ==1){
            header("Location: ../vistas/primerLogin.php");
        }
    }

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('America/El_Salvador'));
    $hora = $Object->format("d-m-Y h:s a"); 
    
?>
<!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
    <a href="home.php" class="brand-logo">
        <img class="logo-abbr" src="../Recursos/Multimedia/Imagenes/imgLogoFepadeHeader.png" alt="">
        
        <img class="brand-title" src="../Recursos/Multimedia/Imagenes/imgTextFepadeHeader.png" alt="">
    </a>

    <div class="nav-control">
        <div id="menuResp"class="hamburger">
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
                </div>
                <script>
                    var idRol ="<?=$_SESSION["usuario"]["id_rol"]?>";
                    var rol ="<?=$_SESSION["usuario"]["rol"]?>";
                </script>
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
<div class="quixnav shodow">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Menu de navegación</li>
            <li id="listaActivos"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Activos</span></a>
                <ul aria-expanded="false" id="subMenuActivos">
                    
                </ul>
            </li>
            <li id="listaUsuarioRoles"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Usuario y roles</span></a>
                <ul aria-expanded="false" id="subMenuUsuarioRol">
                    
                </ul>
            </li>
            <li id="listaResponsable"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Responsables</span></a>
                <ul aria-expanded="false" id="subMenuResp">
                    
                </ul>
            </li>
            <li id="listaReportes"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Reportes</span></a>
                <ul aria-expanded="false" id="subMenuReportes">
                    <li><a href="reportes.php">De activo</a></li>
                    <li><a href="nuevoUsuario.php">Toners</a></li>
                    <li><a href="nuevoUsuario.php">Para revisión de áreas</a></li>
                    <li><a href="nuevoUsuario.php">Para mantenimiento</a></li>
                </ul>
            </li>
            
        </ul>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
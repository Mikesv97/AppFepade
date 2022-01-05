<?php
include('layout/header.php');
include('layout/navbar.php');
?>

<div class="content-body">
    <div class="container-fluid">
    <a href="" id="inicioFormRespon"></a>
        <!--barra top -->
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Activo Responsable</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <p>HOLIS</p>

    </div>
</div>

<?php
include('layout/footer.php');
?>
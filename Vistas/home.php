<?php
include('layout/header.php');
include('layout/navbar.php');
?>

<style>
    .altura {
        height: 100vh;
    }

    @media only screen and (max-width: 699px) {
        .contentIMG{
            max-width: 100%;
        }

        .contentIMG > img{
            width: 100%;
        }

    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <a href="" id="inicioFormRespon"></a>
        <!--barra top -->
        <div class="row shadow page-titles justify-content-center align-items-center altura">
            <div class="col-md-12 py-5 text-center">
                <div class="contentIMG col-md-12">
                    <img src="../Recursos/Multimedia/Imagenes/logoFepadePDF.png" alt="">
                </div>
                <div class="content">
                    <h1 class="my-5">Bienvenido <?= $_SESSION["usuario"]["nombre"]; ?>!</h1>
                    <h3>Rol: <?= $_SESSION["usuario"]["rol"]; ?></h3>
                    <h3>Un gusto tenerte en nuestro equipo</h3>
                </div>
            </div>
        </div>
        <!-- fin barra top -->

    </div>
</div>



<?php
include('layout/footer.php');
?>
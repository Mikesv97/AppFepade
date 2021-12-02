<?php

session_start();
if(!isset($_SESSION["usuario"]["nombre"])){
    header("Location: ../index.php");
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="../recursos/js/homejs.js" ></script>
<h1>BIENVENIDO AL SISTEMA</h1>
<p>
    tu nombre: <?=$_SESSION["usuario"]["nombre"];?><br>
    tu id: <?=$_SESSION["usuario"]["id"];?><br>
    tu correo: <?=$_SESSION["usuario"]["correo"];?><br>
    tu rol: <?=$_SESSION["usuario"]["rol"];?><br>

    <a id="cerrarLog" href="#">SALIR</a>
</p>
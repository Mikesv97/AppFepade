<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../recursos/lib/phpmailer/Exception.php';
require '../recursos/lib/phpmailer/PHPMailer.php';
require '../recursos/lib/phpmailer/SMTP.php';


$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'fepadeactivofijo@gmail.com';                     //SMTP username
    $mail->Password   = 'fepade123';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('fepadesistemaactivo@gmail.com', 'Sistema FEPADE');
    $mail->addAddress('castillo.alan1995@gmail.com');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    $mensaje='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<htm>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Cambio De Contraseña</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>  
<style>
a, h5{
    display: inline-block;
   
}

h5{
    width: auto;
}

a{
    margin-left: 12px;
    width: 200px;
}
</style>
</head>
<body>
<div class="container">
    <h1 class="bg-danger text-white text-center shadow-sm">SOLICITUD DE CAMBIO DE CONTRASEÑA</h1>
    <p class="my-3 h5">Hola se ha solicitado cambio de contraseña en el sistema <span class="bg-danger text-white h6 p-1">ACTIVO FIJO-FEPADE</span></p>
    <p class="h5">
    Tu código de validacion es el : codigo1213213
    </p>
    <p class="bg-danger text-white text-center text-capitalize h5">
    favor no responder este mensaje
    </p>
    <h5 class="h6">Si no has sido tú por favor reportalo:</h5><a class="" href="http://localhost/appfepade/vistas/reportar.html">Reportar</a>
    <img style="width: 100%;" src="https://raw.githubusercontent.com/Mikesv97/AppFepade/main/baner.jpg">
</div>
</body>
</html>';
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'PRUEBA DE CORREO';
    $mail->Body    = $mensaje;
    $mail->AltBody = 'ADICIONAL MENSAJE';

    $mail->send();
    echo 'MENSAJE ENVIADO';
} catch (Exception $e) {
    echo "ERROR: {$mail->ErrorInfo}";
}


?>
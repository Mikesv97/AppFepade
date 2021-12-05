<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../recursos/lib/phpmailer/Exception.php';
require '../recursos/lib/phpmailer/PHPMailer.php';
require '../recursos/lib/phpmailer/SMTP.php';

class SendMail {
    public static function enviarCodCorreo($correo,$codigo){
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
        $mail->setFrom('noreply@gmail.com', 'Sistema FEPADE');
        $mail->addAddress($correo);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        $mensaje='<!DOCTYPE >
        <html>
        <htm>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Cambio De Contraseña</title>
        <style>
        a, h5{
            display: inline-block;
           
        }
        i{
            margin-right: 5px;
            color:#f7d727;
            
        }
        .container{
            width: 90%;
            margin: 0 auto;
        }
        h5{
            width: auto;
        }
        
        a{
            margin-left: 0px;
            width: 200px;
        }
        .titulo{
            background-color: rgba(218, 8, 8, 0.822);
            color: white;
            text-align: center;
            text-shadow: 0 1px 1px hsla(0, 0%, 0%, 0.5);
            box-shadow: 0 1px 1px hsla(0, 0%, 0%, 0.5);
        }
        .contentMsj{
            margin-top: 2em;
            margin-bottom: 2em;
        }
        .spanClas{
            background-color: rgba(226, 13, 13, 0.8);
            text-shadow:0 1px 1px hsla(0, 0%, 0%, 0.5);
            color:white;
            border-radius: 10px;
            padding: 5px;
        }
        .spanCodigo{
            background-color:#f1b72f;
            color: whitesmoke;
            border-radius: 10px;
            padding: 5px;
            text-shadow:0 1px 1px hsla(0, 0%, 0%, 0.5);
           
        }
        a{
                text-decoration: none;
                background-color: rgb(247, 14, 14);
                border-radius: 10px;
                color:white !important;
                padding: 5px;
                text-align: center;
                border:whitesmoke solid 0.5px;
                text-shadow: 0 1px 1px hsla(0, 0%, 0%, 0.5);
                box-shadow: 0 0px 1px hsla(0, 0%, 0%, 0.5);
        }
        a:hover{
            background-color: rgba(207, 20, 20, 0.952);
            transition: all ease-in-out 0.5s;
        }
        h3{
            color:rgba(163, 161, 161, 0.959);
        }
        </style>
        </head>
        <body>
        <div class="container">
            <div>
            <h1 class="titulo">
                <img class="h" src="https://github.com/Mikesv97/AppFepade/blob/main/flecha.png?raw=true">
                SOLICITUD DE CAMBIO DE CONTRASEÑA
            </h1>
            </div>
            <div class="contentMsj">
                <h3 class="">Hola se ha solicitado cambio de contraseña en el sistema <span class="spanClas">ACTIVO FIJO-FEPADE</span></h3>
                <h3 class="">
                Tu código de validacion es el : <span class="spanCodigo"><strong>'.$codigo.'</strong></span>
                </h3>
                <h3 class="">Si no has sido tú por favor reportalo:</h3><a class="" href="http://localhost/appfepade/vistas/reportar.html">Reportar</a>    
            </div>
            <h1 class="titulo"><img class="h" src="https://github.com/Mikesv97/AppFepade/blob/main/flecha.png?raw=true">
                FAVOR NO RESPONDER ESTE MENSAJE
            </h1>
            <img style="width: 100%;" src="https://raw.githubusercontent.com/Mikesv97/AppFepade/main/baner.jpg">
        </div>
        </body>
        </html>';
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'SOLICITUD CAMBIO DE CONTRASEÑA-FEPADE ACTIVO FIJO';
        $mail->Body    = $mensaje;
        //$mail->AltBody = 'ADICIONAL MENSAJE';
    
        return $mail->send();
        
    } catch (Exception $e) {
        echo "ERROR: {$mail->ErrorInfo}";
    }
    }
    
}



?>
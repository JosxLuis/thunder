<?php
function enviar_correo($correo,$nombre,$asunto,$mensaje){
    require_once('lib/phpmailer/class.phpmailer.php');

    $mail = new PHPMailer();

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;

            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';

            //Set the hostname of the mail server
            //$mail->Host = 'smtp.gmail.com'; // CIRG
            /*$mail->Host = 'relay-hosting.secureserver.net';*/
            $mail->Host = 'a2plcpnl0479.prod.iad2.secureserver.net';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission and use 465 for ssl
            $mail->Port = 587; //CIRG
            /*$mail->Port = 25;*/

            //Set the encryption system to use - ssl (deprecated) or tls
          /*$mail->SMTPSecure = 'ssl'; CIRG*/
            $mail->SMTPSecure = 'tls';


            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "contacto@sauberpl.mx";

            //Password to use for SMTP authentication
            $mail->Password = "RUbTF2s@VTzr";

            //Set who the message is to be sent from
            $mail->setFrom('contacto@sauberpl.mx', 'Sauber productos de limpieza');

            //Set an alternative reply-to address

            //Set who the message is to be sent to
            $mail->addAddress($correo, $nombre);

            //Set the subject line
            $mail->Subject = $asunto;

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($mensaje);

            //Replace the plain text body with one created manually
            //$mail->AltBody = 'This is a plain-text message body';

            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                $error = "0-El mensaje no se ha enviado por este error: ".$mail->ErrorInfo;
                return $error;
            } else {
                //$succes = "Enviado";
                $success = "1-El mensaje se ha enviado con éxito";
                return $success;
            }

}
?>
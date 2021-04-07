<?php
session_start();
require 'class.phpmailer.php';
try {
	$mail = new PHPMailer(true); //Nueva instancia, con las excepciones habilitadas
	$body             = '<p>Este es un Mensaje de Prueba</p>';
	$body             = preg_replace('/\\\\/','', $body); //Escapar backslashes
	$mail->IsSMTP();                           // Usamos el metodo SMTP de la clase PHPMailer
	$mail->SMTPAuth   = true;                  // habilitado SMTP autentificación
	$mail->Port       = 25;                    // puerto del server SMTP
	$mail->Host       = "190.9.128.50"; // SMTP server
	$mail->Username   = "cemujica@bolipuertos.gob.ve";     // SMTP server Usuario
	$mail->Password   = "ce12345678";            // SMTP server password
	$mail->From       = "cemujica@bolipuertos.gob.ve"; //Remitente de Correo
	$mail->FromName   = "Maro"; //Nombre del remitente
	$to = "freiteseliesser@hotmail.com"; //Para quien se le va enviar
	$mail->AddAddress($to);
	$mail->Subject  = "Mi primer mensaje con PhpMailer"; //Asunto del correo
	$mail->MsgHTML($body);
	$mail->IsHTML(true); // Enviar como HTML
	$mail->Send();//Enviar
	echo 'El Mensaje a sido enviado.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();//Mensaje de error si se produciera.
}
?>
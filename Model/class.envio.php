<?php	
	class Envio
	{
		// Datos de la cuenta de correo utilizada para enviar vía SMTP
		//private	$smtpHost = "c1370661.ferozo.com";  // Dominio alternativo brindado en el email de alta 
		//private	$smtpUsuario = "info@svaconsultores.com.ar";  // Mi cuenta de correo
		//private	$smtpClave = "Chula1304";  // Mi contraseña
		
		public function enviarAConsultor($nombre, $asun, $email, $mensaje, $emailDest){
		
			// Email donde se enviaran los datos cargados en el formulario de contacto
			$emailDestino = $emailDest;
			$smtpHost = "smtp.gmail.com";  // Dominio alternativo brindado en el email de alta 
			$smtpUsuario = "marconi176@gmail.com";  // Mi cuenta de correo
			$smtpClave = "tetris951";  // Mi contraseña

			$mail = new PHPMailer();
			$mail->IsSMTP();

			$mail->SMTPDebug = 2;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';

			$mail->SMTPAuth = true;
			$mail->Port = 587; 
			$mail->IsHTML(true); 
			$mail->CharSet = "utf-8";

			$mail->Host = $smtpHost; 
			$mail->Username = $smtpUsuario; 
			$mail->Password = $smtpClave;

			$mail->From = $smtpUsuario; // Email desde donde envío el correo.
			$mail->FromName = $nombre;
			$mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario
			$mail->AddReplyTo($email); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
			$mail->Subject = $asun; // Este es el titulo del email.
			$mensajeHtml = nl2br($mensaje);
			$mail->Body = "{$mensajeHtml}"; // Texto del email en formato HTML
			//$mail->AltBody = "{$mensaje}"; // Texto sin formato HTML
			// FIN - VALORES A MODIFICAR //

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$estadoEnvio = $mail->Send();
			
			return $estadoEnvio;
		}	
		
		public function enviarACliente($nombre, $asun, $email, $mensaje){
			
			$smtpHost = "smtp.gmail.com";  // Dominio alternativo brindado en el email de alta 
			$smtpUsuario = "marconi176@gmail.com";  // Mi cuenta de correo
			$smtpClave = "Tetris951";  // Mi contraseña
			
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Port = 587; 
			$mail->IsHTML(true); 
			$mail->CharSet = "utf-8";

			$mail->Host = $smtpHost; 
			$mail->Username = $smtpUsuario; 
			$mail->Password = $smtpClave;

			$mail->From = $smtpUsuario; // Email desde donde envío el correo.
			$mail->FromName = $nombre;
			$mail->AddAddress($email); // Esta es la dirección a donde enviamos los datos del formulario 
			$mail->Subject = $asun; // Este es el titulo del email.
			$mensajeHtml = nl2br($mensaje);
			$mail->Body = "{$mensajeHtml}"; // Texto del email en formato HTML
			//$mail->AltBody = "{$mensaje}"; // Texto sin formato HTML
			// FIN - VALORES A MODIFICAR //

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$estadoEnvio = $mail->Send();
			
			return $estadoEnvio;
		}	
	}
?>	
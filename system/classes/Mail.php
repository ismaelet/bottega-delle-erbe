<?php

include_once(__ROOT__ . '/vendor/PHPMailer/src/Exception.php');
include_once(__ROOT__ . '/vendor/PHPMailer/src/PHPMailer.php');
include_once(__ROOT__ . '/vendor/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {

	//generic query
	static function send($data) {

		$mail = new PHPMailer();

		//SMTP setup
		$mail->SMTPDebug = !empty($data['debugger']);
		$mail->isSMTP();
		$mail->Host = $data['host'] ?? sysData('mail-host');
		$mail->SMTPAuth = true;
		$mail->Username = $data['username'] ?? sysData('mail-username');
		$mail->Password = $data['password'] ?? sysData('mail-passsword');
		$mail->SMTPSecure = $data['secure'] ?? 'ssl';
		$mail->Port = $data['port'] ?? 465;

		//sender
		if (isset($data['from-address']) && isset($data['from-name'])) $mail->setFrom($data['from-address'], $data['from-name']);
		else if (isset($data['from-address'])) $mail->setFrom($data['from-address']);
		else $mail->setFrom($data['username'] ?? sysData('mail-username'));

		//recipient
		$mail->addAddress($data['to']);

		if (isset($data['cc'])) {

			$ccs = (array) $data['cc'];

			foreach ($ccs as $cc) $mail->AddCC($cc);
			
		}

		//reply
		if (isset($data['reply-address']) && isset($data['reply-name'])) $mail->addReplyTo($data['reply-address'], $data['reply-name']);
		else if (isset($data['reply-address'])) $mail->addReplyTo($data['reply-address']);

		//content
		$mail->isHTML(true);
		$mail->Subject = $data['subject'];
		$mail->Body = $data['text'];

		//send
		$mail->Send();

	}

}
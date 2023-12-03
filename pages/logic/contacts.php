<?php

//theme
$this->set('theme_floating', true);

//setup variabiles
$sent = false;
$error = false;

//send mail
if (isset($_POST['submit']) && !$sent) {
	
	$name = trim($_POST['name']);
	$mail = trim($_POST['mail']);
	$msg = trim($_POST['text']);
	
	$serv = explode('@', $mail)[1];
	$serv = explode('.', $serv)[0];
	
	if (!in_array($serv, ['tiscali', 'gmail', 'libero', 'yahoo', 'hotmail', 'icloud', 'outlook'])) $error = 'mail_bad';
	else if (preg_match("/(sexy|bitcoin|wellness|dollars|https|free|business)/i", $msg)) $error = 'word_bad';
	else {

		$message = 'Messaggio da '.$name.' (' . $mail . '):<br/><br/>' . $msg;
		
		$mail_data = [
			'debugger' => false,
			'from-address' => 'postmaster@bottegadelleerbe.com',
			'from-name' => 'Sito Bottega delle Erbe',
			'to' => sysData('cont-mail'),
			'subject' => 'Richiesta informazioni',
			'reply-address' => $mail,
			'text' => $message,
		];

		Mail::send($mail_data);

		$sent = true;

	}
	
}

//store variables
$this->set('sent', $sent);
$this->set('error', $error);
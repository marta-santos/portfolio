<?php
$nome = htmlspecialchars(strip_tags($_POST['nome']));
$texto = htmlspecialchars(strip_tags($_POST['texto']));
$email = htmlspecialchars(strip_tags($_POST['email']));
$mensagem = htmlspecialchars(strip_tags($_POST['texto']));
$refresh = '<meta http-equiv="refresh" content="1; url=index.html" />';
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		echo '<script type="text/javascript">alert("E-mail inv�lido!.")</script>';	
		exit ($refresh);		
	} elseif
		(!filter_var($email, FILTER_SANITIZE_EMAIL))
		{
			echo '<script type="text/javascript">alert("E-mail inv�lido!. Cont�m caracteres n�o permitidos.")</script>';
		exit ($refresh);		
	}
	if ($nome != '' && $email != '' && $texto != '')
	{
		$msg = "<strong>Nome:</strong> $nome<br>";
		$msg .= "<strong>E-mail:</strong> $email<br>";
		$msg .= "<strong>Mensagem:</strong> $mensagem<br>";
		$recipient = "mailcontacto@martasantos.com";
		$subject = "Contato Website";
		$header = "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		$header .= "From: $email\r\n";
		if (mail ($recipient, $subject, $msg, $header))
		{
				echo '<script type="text/javascript">alert("Contato enviado.")</script>';
				exit ($refresh);		
		} else {
				echo '<script type="text/javascript">alert("Problema no envio da mensagem. Por favor tente mais tarde..")</script>';
				exit ($refresh);		
		}
	} else{
			echo '<script type="text/javascript">alert("Por favor preencha todos os campos.")</script>';
		exit ($refresh);		
	}
?>

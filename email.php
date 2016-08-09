
<?php
//Email Functions
function send_email($message,$email) {
	$mail             = new PHPMailer();
 
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mail.designeragents.com"; // SMTP server
	$mail->Port       = 587; 
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	// 1 = errors and messages
	// 2 = messages only
 
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Username   = "btcalert@designeragents.com"; // SMTP account username
	$mail->Password   = "2fast2bs0d";        // SMTP account password
 
	$mail->SetFrom('btcalert@designeragents.com', 'BTC Alert');
	$mail->AddReplyTo("btcalert@designeragents.com",'BTC Alert');
	$mail->Subject    = "Alerts for items over your price floor";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($message);
 
	$address = $email;
	$mail->AddAddress($address, "John Doe");
 
	if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	echo "Message sent!";	
	}
}
?>

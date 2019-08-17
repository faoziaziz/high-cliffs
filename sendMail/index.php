<?php

$msg = "Reservation Information:";
$msg .= "Tanggal : ".date("d M Y", strtotime($date))."<br />";
$msg .= "Time : Time<br />";
$msg .= "Person : People<br />";
$msg .= "PIC Name : Name<br />";
$msg .= "Phone : Phone<br />";

//SEND EMAIL
require_once "mail/Mail.php";
require_once "mail/mime.php";

//- port smtp = 25 / 465(ssl)

$host       = "ssl://smtp.gmail.com";
//$host       = "ssl://mail.marqueeoffices.com";
$port       = "465";
//$username   = "testapp@marqueeoffices.com";
$username   = "lelakiadalahpria@gmail.com";
//$password   = "trukcb10unix!";
$password   = "lelaki123!";
$from       = "nimrotletter@gmail.com";
$to         = "nimsroot@gmail.com";
//$to         = "nimsroot@gmail.com";
$to         .= ",nimsroot@gmail.com"; // OPTIONAL
$subject    = "Reservation - Mangengking";
$headers    = array('From'=>$from,'To'=>$to,'Subject'=>$subject);
$smtp       = Mail::factory('smtp',array ('host'=>$host,'port'=>$port,'auth'=>true,'username'=>$username,'password'=>$password));
$html       = $msg;
$crlf       = "\n";
$mime       = new Mail_mime($crlf);
$mime->setHTMLBody($html);
$body       = $mime->get();
$headers    = $mime->headers($headers);
$mail       =& Mail::factory('mail');
$mail->send($to, $headers, $body);

if (PEAR::isError($mail)) {
	$emailStatus = $mail->getMessage();
	echo "<script>alert('Sorry, Reservation Failed. please Repeat');</script>";
} else {
	$emailStatus = "Sent";
	echo "<script>alert('We have receive your message. Thank you');</script>";
	$URL=base_url();
	echo "<script>location.href='$URL'</script>";
}
?>
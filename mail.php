<?
// Wait a second to simulate a some latency
usleep(500000);

// edit email where contact form is sent
$email_send_to = 'hello@pixelhippie.com';
// edit your domain
$email_recived_from = 'pixelhippie.com';
// edit message for a successfully sent contact form
$success_msj = 'Thanks! Your message has been sent.';
// edit error message
$error_msj = 'Oh no! Error! Try again.';

// Pull out data from contact form
	$name = htmlspecialchars(trim($_POST['name']));
	$email = htmlspecialchars(trim($_POST['email']));
	$message = htmlspecialchars(trim($_POST['message']));
$email_recived_from  = str_replace ('http://', '', $email_recived_from );
$email_recived_from  = str_replace ('www.', '', $email_recived_from );
// setting HTML email function
function sendHTMLemail($HTML,$from,$to,$subject)
{
    $headers = "From: $from\r\n";
	$headers .= "MIME-Version: 1.0\r\n"; 
    $boundary = uniqid("HTMLEMAIL"); 
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode(strip_tags($HTML))); 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode($HTML));
	$contactmail = 'contact@'.$email_recived_from;
	mail($to,$subject,"",$headers,'-f $contactmail');
}

$HTML = '<html>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#99CC00" >
 
<STYLE> 
 .headerTop { background-color:#FFCC66; border-top:0px solid #000000; border-bottom:1px solid #FFFFFF; text-align:center; }
 .adminText { font-size:10px; color:#996600; line-height:200%; font-family:verdana; text-decoration:none; }
 .headerBar { background-color:#FFFFFF; border-top:0px solid #333333; border-bottom:10px solid #FFFFFF; }
 .title { font-size:20px; font-weight:bold; color:#CC6600; font-family:arial; line-height:110%; }
 .subTitle { font-size:11px; font-weight:normal; color:#666666; font-style:italic; font-family:arial; }
 td { font-size:12px; color:#000000; line-height:150%; font-family:trebuchet ms; }
 .sideColumn { background-color:#FFFFFF; border-left:1px dashed #CCCCCC; text-align:left; }
 .sideColumnText { font-size:11px; font-weight:normal; color:#999999; font-family:arial; line-height:150%; }
 .sideColumnTitle { font-size:15px; font-weight:bold; color:#333333; font-family:arial; line-height:150%; }
 .footerRow { background-color:#FFFFCC; border-top:10px solid #FFFFFF; }
 .footerText { font-size:10px; color:#996600; line-height:100%; font-family:verdana; }
 a { color:#FF6600; color:#FF6600; color:#FF6600; }
</STYLE>
 
 
 
<table width="100%" cellpadding="10" cellspacing="0" bgcolor="#99CC00" >
<tr>
<td valign="top" align="center">
 
<table width="600" cellpadding="20" cellspacing="0" bgcolor="#FFFFFF">
<tr>
 
<td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:trebuchet ms;">
 
<p>
<span style="font-size:20px;font-weight:bold;color:#CC6600;font-family:arial;line-height:110%;">You have a message in your inbox</span><br>
<span style="font-size:11px;font-weight:normal;color:#999999;font-family:arial;line-height:150%;">
	<br />Name: '.$name.'
	<br />Email: '.$email.'
	<br />Message: '.$message.'
</span></td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
';
$subject = "Someone contacted you on ".$email_recived_from;
$from = $email_recived_from.' <contact@'.$email_recived_from.'>';
$to = $email_send_to;
sendHTMLemail($HTML,$from,$to,$subject);

echo $success_msj;
?>
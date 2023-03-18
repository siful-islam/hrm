<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;

class EmailController extends Controller
{
	
	public function SendEmail()
    {
		$to = 'pronab@cdipbd.org';

//sender
$from = 'pronab@gmail.com';
$fromName = 'Pronab';

//email subject
$subject = 'PHP Email with Attachment by Pronab'; 

//attachment file path
//$file = "1237.pdf";

//email body content
$htmlContent = '<h1>PHP Email with Attachment by Pronab</h1>
    <p>This email has sent from PHP script with attachment.</p>';

//header for sender info
$headers = "From: $fromName"." <".$from.">";

//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

//preparing attachment


//send email
$mail = @mail($to, $subject, $message, $headers); 

//email sending status
echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";
		
	}
	
}
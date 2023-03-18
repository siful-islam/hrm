<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Force extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }
    public function build()
    {
		$mail_data = $this->mail_data;
		$view = $mail_data['view'];
		$hr_mail = 'hr_personnel@cdipbd.org';
		//$mail_data['email']
		//return $this->view('notification.'.$view, get_defined_vars())->subject("CDIP HRM Notification System")->to('deep@cdipbd.org')->cc('deepcdip@gmail.com')->bcc('deepshovon@gmail.com');
		return $this->view('notification.'.$view, get_defined_vars())->subject("CDIP HRM Notification System")->to($mail_data['email'])->cc($hr_mail)->bcc('deep@cdipbd.org');
	
    }
}

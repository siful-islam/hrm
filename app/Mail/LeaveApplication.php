<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveApplication extends Mailable
{
    use Queueable, SerializesModels; 
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }
    public function build()
    {
		$mail_data = $this->mail_data;
		//return $this->view('admin.email.leave_application_sub', get_defined_vars())->subject("Leave Application of $mail_data[emp_name]")->to('zislamlaser@gmail.com');
		if($mail_data['sub_supervisor_email'] == '')
		{
			return $this->view('admin.email.leave_application', get_defined_vars())->subject("Leave Application of $mail_data[emp_name]")->to($mail_data['supervisor_email']);
		}
		else{
			return $this->view('admin.email.leave_application_sub', get_defined_vars())->subject("Leave Application of $mail_data[emp_name]")->to($mail_data['sub_supervisor_email']);
		}
    }
}

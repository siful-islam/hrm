<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VisitApplication extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct($v_mail_data)
    {
        $this->v_mail_data = $v_mail_data;
    }
    public function build()
    {
		$v_mail_data = $this->v_mail_data;
		if($v_mail_data['sub_supervisor_email'] == '')
		{
			return $this->view('admin.email.visit_application', get_defined_vars())->subject("Visit Application of $v_mail_data[emp_name]")->to($v_mail_data['supervisor_email']);
		}
		else{
			return $this->view('admin.email.visit_application_sub', get_defined_vars())->subject("Visit Application of $v_mail_data[emp_name]")->to($v_mail_data['sub_supervisor_email']);
		}
    }
}

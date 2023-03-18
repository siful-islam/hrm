<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data; 
    }
    public function build()
    {
		$mail_data = $this->mail_data;
		return $this->view('admin.email.booking_mail', get_defined_vars())
		/* ->attach(('attachments/attach_ment_tran/'.$mail_data['attachment']), [
                        'as' => $mail_data['attachment']
                    ]) */
		->subject($mail_data['mail_subject'])
		->to($mail_data['mail_to']);
		
    }
}
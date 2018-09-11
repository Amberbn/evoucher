<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
// use App\Repository\UserRepository;

class SendEmailChangePassword extends Mailable
{
    use Queueable, SerializesModels;

    
    // protected $userRepository;
    public $user;
    // public $usetrId
    // public $createdBy;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        // $this->userRepository = new UserRepository;
        $this->user = $user;
        // $this->userId = $userId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $user = $this->userRepository->getAllUser();
        $voucher = $this->voucher;

        // $userName =  $user->user_name
        // $password = $user->password;
        // $email
        // $createdBy = $this->createdBy;


        $name = env('MAIL_FROM_NAME');
        $emailfrom = env('MAIL_FROM_ADDRESS');
        $subject = "Change Password";
        $emailSendTo = $user->user_name;

        $content = "Change password";
        // $userId = $userId->user_id;
        $userUrl = "http://localhost:8000/chage-password/";
        $emailContent = $content . $userUrl;

        return $this->view('emails.email')
            ->from($emailfrom, $name)
            ->replyTo($emailfrom, $name)
            ->subject($subject)
            ->with([
                'content' => $content,
                'redeem_url' => $userUrl,
            ]);
    }
}

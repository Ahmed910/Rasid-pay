<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $token;

    /**
    * Create a notification instance.
    *
    * @param  string  $token
    * @return void
    */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
    * Get the notification's channels.
    *
    * @param  mixed  $notifiable
    * @return array|string
    */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
    * Get the notification message.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\MessageBuilder
    */
    public function toMail($notifiable)
    {
        $url = route('dashboard.passwords.reset.email',$this->token) . "?email=" . urlencode($notifiable->email);
        return (new MailMessage)
             ->subject('استعادة كلمة المرور')
             ->view('dashboard.email.password_reset',compact('url'));
    }

}

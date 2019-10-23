<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Email;

class NotifyEmails extends Notification
{
    use Queueable;
    
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->email->user_id,
            'subject' => $this->email->subject,
            'email_id' => $this->email->id,
            
        ];
    }
    
    /**
     * Получить представление уведомления в виде письма.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


//        $greeting = sprintf('Hello %s!', $notifiable->name);
// 
//        return (new MailMessage)
//                    ->subject('Yours Faithfully')
//                    ->greeting($greeting)
//                    ->salutation('Yours Faithfully')
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//        return (new Mailable($this->invoice))->to($this->user->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
           'email' => $this->email
        ];
    }
}

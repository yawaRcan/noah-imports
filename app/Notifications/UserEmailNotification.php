<?php

namespace App\Notifications;

use App\Traits\SmtpTrait;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage; 

class UserEmailNotification extends Notification  implements ShouldQueue
{
    use Queueable, SmtpTrait;

    protected $data;

    protected $shortCodes;

    protected $subject;


    /**
     * Create a new notification instance.
     */
    public function __construct( $subject = null , $data = null , $shortCodes = [])
    {
        $this->data = $data;
        
        $this->shortCodes = $shortCodes; 

        $this->subject = $subject; 

       
        $this->setMailConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $body = shortCodeBodyReplacer( $this->data->body , $this->shortCodes , $notifiable );

        return (new MailMessage)
                ->subject((isset($this->subject)) ? $this->subject : $this->data->subject )
                ->view('admin.emails.email.custom',['body' => $body]); // Pass any necessary data to the view
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */ 
    public function toArray($notifiable)
    {
        return $notifiable->toArray();
    }
}

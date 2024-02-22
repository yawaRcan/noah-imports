<?php

namespace App\Notifications;

use App\Traits\SmtpTrait;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage; 

class OrderNotification extends Notification  implements ShouldQueue
{
    use Queueable, SmtpTrait;

    protected $data;
    
    protected $shortCodes;


    /**
     * Create a new notification instance.
     */
    public function __construct($data = null , $shortCodes = [])
    { 
        
        $this->data = $data;
        
        $this->shortCodes = $shortCodes; 
       
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
                ->subject($this->data->subject)
                ->view('admin.emails.email.custom',['body' => $body]); // Pass any necessary data to the view
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

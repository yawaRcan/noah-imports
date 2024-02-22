<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\User;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeActivatedUserByAdminNotification extends Notification
{
    use Queueable;
    protected $template;

    protected $user;
    
    protected $shortCodes;

    /**
     * Create a new notification instance.
     */
    public function __construct(EmailTemplate $template = null , $shortCodes = [],$user = null)
    {
        
        $this->user = $user;

        $this->template = $template;
        
        $this->shortCodes = $shortCodes; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return  [
            'data' => $this->user->toArray(),
            'type' => 'User' ,
            'created_by' => 1 ,
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\SmtpTrait;

class UpdateOrderNotification extends Notification
{
    use Queueable, SmtpTrait;

    protected $order;

    protected $template;
    
    protected $shortCodes;

    public function __construct(EmailTemplate $template = null , $shortCodes = [],Order $order = null)
    {
        $this->order = $order;

        $this->template = $template;
        
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
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $body = shortCodeBodyReplacer( $this->template->body , $this->shortCodes , $notifiable );

        return (new MailMessage)
                ->subject($this->template->subject)
                ->view('admin.emails.email.custom',['body' => $body]); // Pass any necessary template to the view
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return  [
            'data' => $this->order->toArray(),
            'type' => 'Purchases' ,
            'created_by' => 1 ,
        ];
    }
}

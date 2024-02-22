<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Traits\SmtpTrait;

class ChangePasswordNotification extends Notification
{
    use Queueable, SmtpTrait;

    protected $user;

    protected $template;

    protected $shortCodes;

    /**
     * Create a new notification instance.
     */
    public function __construct(EmailTemplate $template = null, $shortCodes = [], $notifiable = null)
    {
        $this->user = $notifiable;

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

        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $body = shortCodeBodyReplacer($this->template->body, $this->shortCodes, $notifiable);
        return (new MailMessage)
            ->subject($this->template->subject)
            ->view('admin.emails.email.custom', ['body' => $body]); // Pass any necessary template to the view
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => $this->user->toArray(),
            'type' => 'Account',
            'created_by' => 1,
        ];
    }
}

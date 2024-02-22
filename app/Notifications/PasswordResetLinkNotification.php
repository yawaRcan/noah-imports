<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\EmailTemplate;
use App\Traits\SmtpTrait;

class PasswordResetLinkNotification extends Notification
{
    use Queueable, SmtpTrait;

    /**
     * Create a new notification instance.
     */
    protected $template;
    protected $user;
    protected $shortCodes;
    public function __construct(EmailTemplate $template = null, $shortCodes = [], $user = null)
    {
        $this->template = $template;
        $this->user = $user;
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
            ->view('admin.emails.email.custom', ['body' => $body]);

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

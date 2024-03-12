<?php

namespace App\Jobs;

use App\Events\UserCreated;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRegMailToAdmins implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $template;
    protected $shortCodes;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user, array $shortCodes)
    {
        $this->user = $user;
        $this->shortCodes = $shortCodes;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = Admin::all();
        $template = EmailTemplate::where('slug', 'Notify_admin_onUser_Reg')->first();
        // $this->shortCodes['adminName'] = $admins->first_name . ' ' . $admins->last_name;
        // $event = event(new UserCreated($template, $this->shortCodes, $this->user, $admins, 'NotifyAdminOnUserCreation'));
        foreach ($admins as $admin) {
            $this->shortCodes['adminName'] = $admin->first_name . ' ' . $admin->last_name;
            $event = event(new UserCreated($template, $this->shortCodes, $this->user, $admin, 'NotifyAdminOnUserCreation'));
        }
    }
}

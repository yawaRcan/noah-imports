<?php

namespace App\Jobs;

use App\Events\UserCreated;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdminRegMailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $regAdmin;
    protected $shortCodes;
    public function __construct(Admin $user, array $shortCodes)
    {
        $this->regAdmin = $user;
        $this->shortCodes = $shortCodes;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $admins = Admin::where('email', '!=', $this->regAdmin->email)->get();

        $template = EmailTemplate::where('slug', 'Notify_admin_onAdmin_Reg')->first();

        if ($template) {
            foreach ($admins as $admin) {
              $event =  event(new UserCreated($template, $this->shortCodes, $this->regAdmin, $admin, 'NotifyAdminOnUserCreation'));
            }
        }
    }
}

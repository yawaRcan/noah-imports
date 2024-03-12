<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Events\UserEvent;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // $request->user()->sendEmailVerificationNotification();
        $template = EmailTemplate::where('slug', 'verification-mail')->first();

        if ($template) {
            $user = $request->user();
            $verificationUrl = $this->verificationUrl($user);
            $shortCodes = [
                'VERIFY_URL' => $verificationUrl
            ];

            //Send notification to user
            event(new UserEvent($template, $shortCodes, $user, $user, 'RegisterUser'));

        }

        return back()->with('status', 'verification-link-sent');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Events\PasswordReset;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '700M');
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $admin = User::where('email', $request->email)->first();
        if ($request->email == isset($admin->email)) {
            $token = Password::getRepository()->create($admin);
            $resetUrl = route('password.reset', ['token' => $token, 'email' => $admin->email]);
            $template = EmailTemplate::where('slug', 'password-reset')->first();
            if ($template) {
                $shortCodes = [
                    'reset_url' => $resetUrl,
                    'name' => $admin->username,
                    'email' => $admin->email,
                    'IP' => $request->ip()
                ];
                //Send notification to user
                event(new PasswordReset($template, $shortCodes, $admin, 'PasswordReset'));
                return back()->withInput($request->only('email'));
            } else {

                $notify = [
                    'error' => "Something went wrong",
                ];
                return back()->withErrors($notify);
            }
        } else {

            return back()->withInput($request->only('email'))->withErrors(['email' => __("email not found")]);
        }
    }
}

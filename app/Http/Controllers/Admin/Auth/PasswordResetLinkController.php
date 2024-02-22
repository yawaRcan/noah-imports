<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Events\PasswordReset;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '700M');
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if ($request->email == isset($admin->email)) {
            $token = Password::getRepository()->create($admin);
            $resetUrl = route('password.reset', ['token' => $token, 'email' => $admin->email]);
            $template = EmailTemplate::where('slug', 'password-reset')->first();
            if ($template) {
                $shortCodes = [
                    'reset_url' => $resetUrl,
                    'name' => $admin->username,
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











        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.



        // $status = Password::broker('admins')->sendResetLink(
        //     $request->only('email')
        // );

        // return $status == Password::RESET_LINK_SENT
        //     ? back()->with('status', __($status))
        //     : back()->withInput($request->only('email'))
        //         ->withErrors(['email' => __($status)]);
    }
}

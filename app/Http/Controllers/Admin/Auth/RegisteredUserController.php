<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Events\UserEvent;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'unique:' . Admin::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = Admin::create([
            'branch_id' => $request->branch_id,
            'country_id' => $request->country_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'initial_country' => $request->initial_country,
            'country_code' => $request->country_code,
            'status' => 1,
            'gender' => 1,
            'theme' => 2,
        ]);

        // event(new Registered($user));
        $template = EmailTemplate::where('slug', 'registration-user')->first();
        $template2 = EmailTemplate::where('slug', 'admin-registeration')->first();

        if ($template) {
            $verificationUrl = $this->verificationUrl($user);
            $shortCodes = [
                'VERIFY_URL' => $verificationUrl,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'password' => $request->password,
                'image'=>$request->image,
                'phone'=>$request->phone
            ];
            //Send notification to user 	admin-registeration
            event(new UserEvent($template, $shortCodes, $user, $user, 'RegisterUser'));
        }
        if ($template2) {
            $shortCodes = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'password' => $request->password,
                'image'=>$request->image,
                'phone'=>$request->phone
            ];
            event(new UserEvent($template2, $shortCodes, $user, $user, 'RegisterUser'));
        }

        Auth::guard('admin')->login($user);

        return redirect(RouteServiceProvider::Admin);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
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

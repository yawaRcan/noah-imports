<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Events\UserEvent;
use App\Events\UserCreated;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    // Function to get the client IP address
    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $id = User::orderBy('id', 'desc')->pluck('id')->first();

        if ($id) {
            $id = $id + 1;
        } else {
            $id = 1;
        }

        $dob = $request->year . '-' . $request->month . '-' . $request->day;
        $user = User::create([
            'country_id' => $request->country_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->contact_no,
            'customer_no' => general_setting('setting')->customer_no . $id,
            'initial_country' => $request->initial_country,
            'country_code' => $request->country_code,
            'status' => 0,
            'gender' => 1,
            'lang' => 'english',
            'theme' => 2,
            'role' => 4,
            'ip' => $this->get_client_ip(),
            'dob' => $dob,
            'ref_no' => 123,
            'invite_no' => 123,
        ]);
        // event(new Registered($user));
        $template = EmailTemplate::where('slug', 'registration-user')->first();


        if ($template) {

            $verificationUrl = $this->verificationUrl($user);
            $shortCodes = [
                'email' => $user->email,
                'password' => $request->password,
                'VERIFY_URL' => $verificationUrl
            ];
            // return $this->verificationUrl($user);

            //Send notification to user
            $admin = Admin::first();
            // $event= event(new UserCreated($template , $shortCodes, $user, $admin, 'RegisterUser'));
            $event = event(new UserEvent($template, $shortCodes, $user, $user, 'RegisterUser'));

        }


        $view = view('auth.ajax.register-modal')->render();
        $notify = [
            'success' => "Successfully registered.",
            'html' => $view,
        ];
        return $notify;
        // Auth::login($user);

        // if (Auth::check()) {
        //     $user = Auth::guard('web')->user();

        // }
        //else{
        //     $notify = [
        //         'error' => "something went wrong contact your admin.",  
        //     ]; 
        //     return $notify;
        // }

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

<?php

namespace App\Traits;

use App\Models\Setting;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;

trait SmtpTrait
{
    
    public function setMailConfigs()
    {
        $Setting = Setting::first();    
       

        if (\config('app.env') !== 'development') {
            Config::set('mail.driver', $Setting->smtp->mail_driver);
            Config::set('mail.host', $Setting->smtp->host);
            Config::set('mail.port', $Setting->smtp->port);
            Config::set('mail.username', $Setting->smtp->username);
            Config::set('mail.password', $Setting->smtp->password);
            Config::set('mail.encryption', $Setting->smtp->mail_encryption);
            Config::set('mail.from.name', $Setting->configuration->site_name);
            Config::set('mail.from.address', $Setting->smtp->email);
        } 
       
        Config::set('app.name', $Setting->configuration->site_name);

        if (($Setting->configuration->site_name) && !is_null($Setting->company->logo)) {
            Config::set('app.logo', asset('storage/assets/company/logo'));

        } elseif (!is_null($Setting->company->logo)) {
            Config::set('app.logo', asset('storage/assets/company/logo'));
        } else {
            Config::set('app.logo', asset('assets/images/logo-icon.png'));
        }

        (new MailServiceProvider(app()))->register();
      
    }
}
<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\DB;


trait CoreEmailSetting {

    public function setEmailBySetting(){
        $email_settings = DB::table('settings')->select('payload')->where(['group' => 'email', 'name' => 'email'])->first();
        $email_setting = json_decode($email_settings->payload);
        if(isset($email_setting->config_email)){
            $setting = $email_setting->config_email;
            $random_email_setting = $setting[array_rand($setting, 1)];
            config([
                "mail.mailers" => $random_email_setting->mailer,
                "mail.mailers.$random_email_setting->mailer.transport" => $random_email_setting->mailer,
                "mail.mailers.$random_email_setting->mailer.host" => $random_email_setting->mail_host,
                "mail.mailers.$random_email_setting->mailer.port" => $random_email_setting->mail_port,
                "mail.mailers.$random_email_setting->mailer.username" => $random_email_setting->username,
                "mail.mailers.$random_email_setting->mailer.password" => $random_email_setting->password,
                "mail.mailers.$random_email_setting->mailer.encryption" => $random_email_setting->mail_encryption,
                "mail.mailers.$random_email_setting->mailer.from.address" => $random_email_setting->mail_from_address,
                "mail.mailers.$random_email_setting->mailer.from.name" => $random_email_setting->mail_from_name
            ]);
        }

    }

}

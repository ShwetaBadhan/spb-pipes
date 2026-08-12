<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantAdminWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $tenantName;
    public $tenantDomain;
    public $loginUrl;
    public $email;
    public $password;

    public function __construct($tenantName, $tenantDomain, $loginUrl, $email, $password)
    {
        $this->tenantName = $tenantName;
        $this->tenantDomain = $tenantDomain;
        $this->loginUrl = $loginUrl;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Welcome to ' . $this->tenantName . ' - Your Admin Login Credentials')
                    ->view('central.emails.tenant-admin-welcome');
    }
}

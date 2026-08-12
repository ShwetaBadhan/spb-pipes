<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;

class CentralAdminResetPassword extends BaseResetPassword
{
    protected function resetUrl($notifiable): string
    {
        return url(route('central.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}

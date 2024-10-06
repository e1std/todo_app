<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Mail;

class EmailNotificationStrategy implements NotificationStrategyInterface
{
    public function send($recipient, $message)
    {
        Mail::to($recipient)->send($message);
    }
}

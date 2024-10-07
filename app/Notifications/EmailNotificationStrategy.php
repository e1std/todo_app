<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Mail;

class EmailNotificationStrategy implements NotificationStrategyInterface
{
    /**
     * Send an email notification.
     *
     * @param string $recipient The recipient's email address.
     * @param mixed $message The message to be sent.
     * @return void
     */
    public function send($recipient, $message)
    {
        // Use the Mail facade to send the email to the recipient
        Mail::to($recipient)->send($message);
    }
}

<?php

namespace App\Notifications;

interface NotificationStrategyInterface
{
    /**
     * Send a notification.
     *
     * @param string $recipient The recipient's contact information.
     * @param mixed $message The message to be sent.
     * @return void
     */
    public function send($recipient, $message);
}

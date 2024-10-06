<?php

namespace App\Notifications;

interface NotificationStrategyInterface
{
    public function send($recipient, $message);
}

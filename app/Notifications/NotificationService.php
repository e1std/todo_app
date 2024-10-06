<?php

namespace App\Notifications;

class NotificationService
{
    protected $strategy;

    public function __construct(NotificationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }
    public function sendNotification($recipient, $message)
    {
        $this->strategy->send($recipient, $message);
    }
}

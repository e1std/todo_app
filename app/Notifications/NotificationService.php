<?php

namespace App\Notifications;

class NotificationService
{
    protected $strategy;

    /**
     * Constructor to initialize the notification strategy.
     *
     * @param NotificationStrategyInterface $strategy The notification strategy to use.
     */
    public function __construct(NotificationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }
    /**
     * Send a notification using the specified strategy.
     *
     * @param string $recipient The recipient's contact information.
     * @param mixed $message The message to be sent.
     * @return void
     */
    public function sendNotification($recipient, $message)
    {
        // Use the strategy to send the notification
        $this->strategy->send($recipient, $message);
    }
}

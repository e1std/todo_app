<?php

namespace App\Notifications;

class NotificationFactory
{
    /**
     * Create a notification strategy based on the given type.
     *
     * @param string $type The type of notification strategy to create.
     * @return NotificationStrategyInterface The created notification strategy.
     */
    public static function create($type)
    {
        switch ($type) {
            case 'sms':
                // Return an instance of SmsNotificationStrategy for SMS notifications
            return new SmsNotificationStrategy();
            case 'email':
            default:
            // Return an instance of EmailNotificationStrategy for email notifications

        return new EmailNotificationStrategy();
        }
    }
}

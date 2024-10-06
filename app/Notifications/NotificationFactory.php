<?php

namespace App\Notifications;

class NotificationFactory
{
    public static function create($type)
    {
        switch ($type) {
            case 'sms':
                return new SmsNotificationStrategy();
            case 'email':
            default:
                return new EmailNotificationStrategy();
        }
    }
}

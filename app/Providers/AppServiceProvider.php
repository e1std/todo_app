<?php

namespace App\Providers;

use App\Notifications\EmailNotificationStrategy;
use App\Notifications\NotificationService;
use App\Notifications\SmsNotificationStrategy;
use App\Notifications\NotificationContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register a singleton instance of NotificationService
        $this->app->singleton(NotificationService::class, function ($app) {
            // Get the notification strategy from the configuration
            $strategy = config('notification.strategy');

            // Determine the strategy instance based on the configuration
            switch ($strategy) {
                case 'sms':
                // Use SmsNotificationStrategy for SMS notifications
                $strategyInstance = new SmsNotificationStrategy();
                    break;
                case 'email':
                default:
                    // Use EmailNotificationStrategy for email notifications
                    $strategyInstance = new EmailNotificationStrategy();
                    break;
            }

            return new NotificationService($strategyInstance);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

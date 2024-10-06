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
        $this->app->singleton(NotificationService::class, function ($app) {
            $strategy = config('notification.strategy');

            switch ($strategy) {
                case 'sms':
                    $strategyInstance = new SmsNotificationStrategy();
                    break;
                case 'email':
                default:
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

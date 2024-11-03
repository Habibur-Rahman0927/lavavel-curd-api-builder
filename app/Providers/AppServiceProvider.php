<?php

namespace App\Providers;

use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\PingCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Health::checks([
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(70)
                ->failWhenUsedSpaceIsAbovePercentage(90),
            DatabaseCheck::new(),
            EnvironmentCheck::new(),
            DebugModeCheck::new(),
            PingCheck::new()->url('https://google.com')
            ->name('Is Google reachable?'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

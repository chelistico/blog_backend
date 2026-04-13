<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set custom temp directory to avoid permission issues with /tmp
        $tempDir = storage_path('temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }
        
        // Override sys_temp_dir for Filament exports
        putenv('TMPDIR=' . $tempDir);
        putenv('TEMPDIR=' . $tempDir);
        putenv('TMP=' . $tempDir);
    }
}

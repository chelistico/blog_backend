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

        // Configure request logging for debugging Filament/Livewire issues
        $this->configureRequestLogging();
    }

    /**
     * Configure request logging for better debugging of Filament issues.
     * 
     * This helps identify session/authentication issues without compromising security.
     */
    private function configureRequestLogging(): void
    {
        // Only enable detailed request logging in development or when debugging
        if (!app()->environment('production') || env('DEBUG_ADMIN_REQUESTS', false)) {
            try {
                \Illuminate\Support\Facades\Log::info('Application started', [
                    'environment' => app()->environment(),
                    'debug_enabled' => config('app.debug'),
                ]);
            } catch (\Exception $e) {
                // Silently fail if logging isn't available
            }
        }
    }
}

<?php

namespace NajmulHasan\BlockCodePreventer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class BlockCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge your package configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blockcode.php',
            'blockcode'
        );
    }

    public function boot()
    {
        // Publishes the configuration file to the Laravel application
        $this->publishes([
            __DIR__ . '/../config/blockcode.php' => config_path('blockcode.php'),
        ], 'config');

        // Monitor and protect files
        $this->protectFiles();
    }

    protected function protectFiles()
    {
        $protectedFiles = config('blockcode.protected_files', []);

        foreach ($protectedFiles as $file) {
            // Check if the file exists
            if (File::exists($file)) {
                $originalContent = File::get($file);

                // Example: Ensure original content is written when the application boots
                File::put($file, $originalContent);
            }
        }
    }
}

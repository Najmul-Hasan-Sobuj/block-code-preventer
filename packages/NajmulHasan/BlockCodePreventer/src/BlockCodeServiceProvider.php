<?php

namespace NajmulHasan\BlockCodePreventer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class BlockCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any bindings or configurations here
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/blockcode.php' => config_path('blockcode.php'),
        ], 'config');

        // Load your custom functionalities
        $this->monitorFiles();
    }

    protected function monitorFiles()
    {
        $protectedFiles = config('blockcode.protected_files');

        foreach ($protectedFiles as $file) {
            if (File::exists($file)) {
                $originalContent = File::get($file);

                // Ensure original content is written when the application boots
                File::put($file, $originalContent);
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class OptimizeProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear and optimize common Laravel caches including Filament. Also deletes Laravel logs.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running optimization commands...');

        $commands = [
            'view:clear',
            'route:clear',
            'config:clear',
            'cache:clear',
            'filament:optimize',
        ];

        foreach ($commands as $command) {
            $this->call($command);
        }

        $logPath = storage_path('logs');
        $deleted = 0;

        foreach (File::glob($logPath . '/*.log') as $file) {
            File::delete($file);
            $deleted++;
        }

        $this->info("Deleted $deleted log file(s).");
        $this->info('All done! Laravel project optimized.');
    }
}

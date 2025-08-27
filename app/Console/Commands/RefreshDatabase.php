<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * --force flag will be forwarded to migrate:fresh when in production
     */
    protected $signature = 'app:refresh-db {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     */
    protected $description = 'Drop all tables and run all migrations afresh, then seed the database.';

    public function handle(): int
    {
        $this->warn('This will DROP all tables, run migrations, and then seed the database.');

        if (app()->environment('production') && ! $this->option('force')) {
            if (! $this->confirm('You are in production. Do you really wish to continue?')) {
                $this->info('Aborted.');
                return self::SUCCESS;
            }
        }

        // Optional: reset permission cache if Spatie Permission is installed
        try {
            $this->callSilent('permission:cache-reset');
        } catch (Throwable $e) {
            // command not available; ignore
        }

        // Run migrate:fresh with --seed
        $params = ['--seed' => true];
        if ($this->option('force')) {
            $params['--force'] = true;
        }

        $this->line('Running migrate:fresh --seed ...');
        $exit = $this->call('migrate:fresh', $params);

        if ($exit !== 0) {
            $this->error('migrate:fresh failed. Check the error above.');
            return $exit;
        }

        $this->info('Database refreshed and seeded successfully. ✅');

        return self::SUCCESS;
    }
}

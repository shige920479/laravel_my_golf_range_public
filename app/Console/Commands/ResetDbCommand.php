<?php

namespace App\Console\Commands;

// use App\Constants\Common;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResetDbCommand extends Command
{

    protected $signature = 'app:reset-db-command';
    protected $description = 'Migrate fresh and seed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // throw new \Exception('mygolf slack-test exception');
            // Artisan::call('migrate:fresh --seed --force');

            Http::retry(3, 200)
                ->timeout(5)
                ->asJson()
                ->post(env('SLACK_WEBHOOK_URL'), [
                    'text' => "*Laravel MyGolfRange Reset Report*\n" . "Status: ✅ SUCCESS\n"
                ]);
            
            return Command::SUCCESS;

        } catch (\Throwable $e) {

            Log::error('Reset DB error: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            Http::retry(3, 200)
                ->timeout(5)
                ->asJson()
                ->post(env('SLACK_WEBHOOK_URL'), [
                    'text' => 
                        "*Laravel MyGolfRange Reset Report*\n" .
                        "Status: ⚠️ WARNINGS / ERRORS\n" .
                        "```{$e->getMessage()}```"
                ]);
            
            return Command::FAILURE;
        }
    }
}

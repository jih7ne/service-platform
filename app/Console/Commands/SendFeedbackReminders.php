<?php

namespace App\Console\Commands;

use App\Jobs\SendFeedbackReminderJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendFeedbackReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feedback:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer les rappels de feedback aux clients et intervenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de l\'envoi des rappels de feedback...');
        
        try {
            // Dispatcher le job pour traiter les rappels
            SendFeedbackReminderJob::dispatch();
            
            $this->info('Job de rappel de feedback dispatché avec succès !');
            
            Log::info('Commande de rappel de feedback exécutée manuellement');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi des rappels: ' . $e->getMessage());
            
            Log::error('Erreur dans la commande de rappel de feedback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return 1;
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBabysitterRegistrationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $babysitter;

    /**
     * Create a new job instance.
     */
    public function __construct($babysitter)
    {
        $this->babysitter = $babysitter;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Récupérer tous les administrateurs depuis la table admins
            $admins = Admin::all();

            if ($admins->isEmpty()) {
                Log::warning('Aucun administrateur trouvé dans la table admins pour la notification de babysitter', [
                    'babysitter_id' => $this->babysitter->idUser
                ]);
                return;
            }

            // Envoyer l'email à chaque administrateur
            foreach ($admins as $admin) {
                Mail::send('emails.admin.babysitter-registered', [
                    'babysitter' => $this->babysitter,
                    'admin' => $admin
                ], function ($message) use ($admin) {
                    $message->to($admin->emailAdmin)
                        ->subject('Nouvelle inscription babysitter - ' . $this->babysitter->nom . ' ' . $this->babysitter->prenom)
                        ->from('noreply@helpora.com', 'Helpora');
                });

                Log::info('Email de notification babysitter envoyé à l\'administrateur', [
                    'admin_email' => $admin->emailAdmin,
                    'babysitter_id' => $this->babysitter->idUser,
                    'babysitter_name' => $this->babysitter->nom . ' ' . $this->babysitter->prenom
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de notification babysitter', [
                'babysitter_id' => $this->babysitter->idUser,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

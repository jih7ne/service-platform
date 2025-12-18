<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Feedback as FeedbackModel;

class DebugFeedback extends Command
{
    protected $signature = 'feedback:debug';
    protected $description = 'Debug feedback moyenne issue';

    public function handle()
    {
        $this->info("=== DEBUG FEEDBACK MOYENNE ===\n");

        // 1. Vérifier la structure de la table feedbacks
        $this->info("1. Structure de la table feedbacks:");
        $columns = DB::select("DESCRIBE feedbacks");
        foreach ($columns as $column) {
            $this->line("- {$column->Field}: {$column->Type} (Default: {$column->Default})");
        }
        $this->line("");

        // 2. Lister tous les feedbacks avec leurs valeurs
        $this->info("2. Tous les feedbacks dans la base:");
        $feedbacks = DB::table('feedbacks')->get();
        
        if ($feedbacks->isEmpty()) {
            $this->warn("Aucun feedback trouvé dans la base de données");
            return 0;
        }
        
        foreach ($feedbacks as $feedback) {
            $this->line("ID: {$feedback->idFeedBack} | Auteur: {$feedback->idAuteur} | Cible: {$feedback->idCible}");
            $this->line("  Ponctualité: {$feedback->ponctualite} | Professionnalisme: {$feedback->credibilite}");
            $this->line("  Sympathie: {$feedback->sympathie} | Communication: {$feedback->qualiteTravail}");
            $this->line("  Propreté: {$feedback->proprete} | MOYENNE: {$feedback->moyenne}");
            $this->line("  Date: {$feedback->dateCreation}");
            $this->line("");
        }

        // 3. Calculer manuellement la moyenne pour vérifier
        $this->info("3. Calcul manuel des moyennes:");
        foreach ($feedbacks as $feedback) {
            $manualAvg = ($feedback->ponctualite + $feedback->credibilite + 
                          $feedback->sympathie + $feedback->qualiteTravail + 
                          $feedback->proprete) / 5;
            
            $this->line("Feedback {$feedback->idFeedBack}:");
            $this->line("  - Valeurs: {$feedback->ponctualite} + {$feedback->credibilite} + {$feedback->sympathie} + {$feedback->qualiteTravail} + {$feedback->proprete}");
            $this->line("  - Calcul manuel: {$manualAvg}");
            $this->line("  - Valeur stockée: {$feedback->moyenne}");
            $this->line("  - Différence: " . abs($manualAvg - $feedback->moyenne));
            $this->line("");
        }

        // 4. Vérifier le dernier feedback créé
        $this->info("4. Dernier feedback créé:");
        $lastFeedback = $feedbacks->last();
        $this->line("ID: {$lastFeedback->idFeedBack}");
        $this->line("Moyenne stockée: {$lastFeedback->moyenne}");
        $this->line("Type de la moyenne: " . gettype($lastFeedback->moyenne));
        
        // Vérification avec le modèle
        $modelFeedback = FeedbackModel::find($lastFeedback->idFeedBack);
        $this->line("Moyenne via modèle: {$modelFeedback->moyenne}");
        $this->line("Type via modèle: " . gettype($modelFeedback->moyenne));

        $this->info("=== FIN DU DEBUG ===");
        return 0;
    }
}
        
        $this->line("");
    }
}


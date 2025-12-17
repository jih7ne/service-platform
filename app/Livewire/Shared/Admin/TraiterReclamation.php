<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use App\Models\Shared\Reclamation;
use App\Mail\Admin\ReclamationResponse;
use Illuminate\Support\Facades\Mail;

class TraiterReclamation extends Component
{
    public $reclamationId;
    public $reclamation;
    public $reponse = '';

    protected $rules = [
        'reponse' => 'required|min:10|max:2000',
    ];

    protected $messages = [
        'reponse.required' => 'La réponse est obligatoire.',
        'reponse.min' => 'La réponse doit contenir au moins 10 caractères.',
        'reponse.max' => 'La réponse ne peut pas dépasser 2000 caractères.',
    ];

    public function mount($id)
    {
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }

        $this->reclamationId = $id;
        $this->reclamation = Reclamation::with(['auteur', 'cible'])
            ->findOrFail($id);
    }

    public function envoyerReponse()
    {
        $this->validate();

        try {
            // Envoyer l'email au client
            Mail::to($this->reclamation->auteur->email)
                ->send(new ReclamationResponse(
                    $this->reclamation,
                    $this->reponse
                ));

            // Mettre à jour le statut de la réclamation à "résolue"
            $this->reclamation->update([
                'statut' => 'resolue', // ou 'résolue' selon votre base de données
                'dateResolution' => now(), // si vous avez ce champ
            ]);

            session()->flash('success', 'La réponse a été envoyée avec succès et la réclamation a été marquée comme résolue.');
            
            return redirect()->route('admin.reclamations.details', ['id' => $this->reclamationId]);

        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'envoi de la réponse: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.shared.admin.traiter-reclamation', [
            'reclamation' => $this->reclamation,
        ]);
    }
}
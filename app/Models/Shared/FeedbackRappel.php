<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class FeedbackRappel extends Model
{
    protected $table = 'feedback_rappels';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'idDemande',
        'idClient',
        'idIntervenant',
        'type_destinataire',
        'rappel_number',
        'date_envoi',
        'prochain_rappel',
        'feedback_fourni',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'prochain_rappel' => 'datetime',
        'feedback_fourni' => 'boolean',
    ];

    // Relations
    public function demande()
    {
        return $this->belongsTo(DemandeIntervention::class, 'idDemande');
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'idClient');
    }

    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idIntervenant');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('feedback_fourni', false);
    }

    public function scopeForClient($query)
    {
        return $query->where('type_destinataire', 'client');
    }

    public function scopeForIntervenant($query)
    {
        return $query->where('type_destinataire', 'intervenant');
    }

    public function scopeDueForReminder($query)
    {
        return $query->where('prochain_rappel', '<=', now());
    }

    /**
     * Vérifier si un feedback existe déjà pour cette demande et ce type d'utilisateur
     */
    public function hasFeedback()
    {
        if ($this->type_destinataire === 'client') {
            return \App\Models\Babysitting\FeedbackBabysitter::where('idDemande', $this->idDemande)
                ->where('idClient', $this->idClient)
                ->exists();
        } else {
            return \App\Models\Babysitting\FeedbackBabysitter::where('idDemande', $this->idDemande)
                ->where('idBabysitter', $this->idIntervenant)
                ->exists();
        }
    }
}

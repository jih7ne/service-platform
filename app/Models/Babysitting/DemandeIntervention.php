<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DemandeIntervention extends Model
{
    protected $table = 'demandes_intervention';
    protected $primaryKey = 'idDemande';
    
    public $timestamps = false; // Désactiver created_at et updated_at
    
    protected $fillable = [
        'dateDemande',
        'dateSouhaitee',
        'heureDebut',
        'heureFin',
        'statut',
        'raisonAnnulation',
        'lieu',
        'note_speciales',
        'idIntervenant',
        'idClient',
        'idService',
    ];

    protected $casts = [
        'dateDemande' => 'datetime',
        'dateSouhaitee' => 'date',
        'heureDebut' => 'datetime:H:i',
        'heureFin' => 'datetime:H:i',
    ];

    // Relations
    public function intervenant()
    {
        return $this->belongsTo(\App\Models\Shared\Intervenant::class, 'idIntervenant');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'idClient');
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class, 'idService');
    }

    public function enfants()
    {
        return $this->hasMany(Enfant::class, 'idDemande');
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeValidee($query)
    {
        return $query->where('statut', 'validée');
    }

    public function scopeRefusee($query)
    {
        return $query->where('statut', 'refusée');
    }

    public function scopeAnnulee($query)
    {
        return $query->where('statut', 'annulée');
    }
}

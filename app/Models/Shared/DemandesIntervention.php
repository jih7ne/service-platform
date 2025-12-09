<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class DemandesIntervention extends Model
{
    protected $table = 'demandes_intervention';
    protected $primaryKey = 'idDemande';

    public $timestamps = false; // migration has no timestamps

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
        'idService'
    ];

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'idClient', 'idUser');
    }

    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idIntervenant', 'idIntervenant');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'idService', 'idService');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'idDemande', 'idDemande');
    }

    public function facture()
    {
        return $this->hasOne(Facture::class, 'idDemande', 'idDemande');
    }
}

<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;
use App\Models\PetKeeping\Animal;

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
    protected $casts = [
        'dateDemande' => 'datetime',
        'dateSouhaitee' => 'date',
        'heureDebut' => 'datetime:H:i',
        'heureFin' => 'datetime:H:i',
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

    public function animals()
    {
        return $this->belongsToMany(
            Animal::class,      // Related model
            'animal_demande',   // Pivot table
            'idDemande',        // FK on pivot referencing demandes_intervention
            'idAnimal',         // FK on pivot referencing animals
            'idDemande',        // Local key on demandes_intervention
            'idAnimale'         // Local key on animals table
        );
    }
}

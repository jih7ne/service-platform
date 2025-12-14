<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\PetKeeping\Animal; // On importe votre modèle Animal

class DemandeIntervention extends Model
{
    protected $table = 'demandes_intervention';
    protected $primaryKey = 'idDemande';
    public $timestamps = false; 

    protected $fillable = [
        'dateDemande', 'dateSouhaitee', 'heureDebut', 'heureFin', 
        'statut', 'idIntervenant', 'idClient', 'idService', 'lieu'
    ];

    protected $casts = [
        'dateSouhaitee' => 'date',
        'dateDemande' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'idClient', 'idUser');
    }

    // Relation inverse vers Animal
    public function animal()
    {
        return $this->hasOne(Animal::class, 'idDemande', 'idDemande');
    }

    // Calcul du prix (accesseur)
    public function getPrixAttribute()
    {
        if($this->heureDebut && $this->heureFin) {
            $hours = Carbon::parse($this->heureDebut)->diffInHours(Carbon::parse($this->heureFin));
            return max($hours * 120, 300); 
        }
        return 480; 
    }
}
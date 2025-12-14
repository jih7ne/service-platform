<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    protected $table = 'disponibilites';
    protected $primaryKey = 'idDispo';
    
    protected $fillable = [
        'heureDebut',
        'heureFin',
        'jourSemaine',
        'est_reccurent',
        'date_specifique',
        'idIntervenant',
    ];

    protected $casts = [
        'heureDebut' => 'datetime:H:i',
        'heureFin' => 'datetime:H:i',
        'est_reccurent' => 'boolean',
        'date_specifique' => 'date',
    ];

    // Relations
    public function intervenant()
    {
        return $this->belongsTo(\App\Models\Shared\Intervenant::class, 'idIntervenant');
    }

    // Scopes
    public function scopePourJour($query, $jour)
    {
        return $query->where('jourSemaine', $jour);
    }

    public function scopeRecurrent($query)
    {
        return $query->where('est_reccurent', true);
    }

    public function scopeSpecifique($query)
    {
        return $query->where('est_reccurent', false);
    }

    public function scopeDisponibleEntre($query, $heureDebut, $heureFin)
    {
        return $query->where('heureDebut', '<=', $heureDebut)
                    ->where('heureFin', '>=', $heureFin);
    }

    // Accessors
    public function getPlageHoraireAttribute()
    {
        return $this->heureDebut->format('H:i') . '-' . $this->heureFin->format('H:i');
    }

    public function getJourFormattedAttribute()
    {
        $jours = [
            'Lundi' => 'lundi',
            'Mardi' => 'mardi', 
            'Mercredi' => 'mercredi',
            'Jeudi' => 'jeudi',
            'Vendredi' => 'vendredi',
            'Samedi' => 'samedi',
            'Dimanche' => 'dimanche'
        ];
        
        return $jours[$this->jourSemaine] ?? strtolower($this->jourSemaine);
    }
}

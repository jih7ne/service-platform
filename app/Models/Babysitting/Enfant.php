<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    protected $table = 'enfants';
    protected $primaryKey = 'idEnfant';
    
    public $timestamps = false; // Désactiver created_at et updated_at
    
    protected $fillable = [
        'nomComplet',
        'dateNaissance',
        'besoinsSpecifiques',
        'idDemande',
    ];

    protected $casts = [
        'dateNaissance' => 'date',
    ];

    // Relations
    public function demande()
    {
        return $this->belongsTo(DemandeIntervention::class, 'idDemande');
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->dateNaissance->age;
    }

    // Scopes
    public function scopeParAge($query, $minAge = null, $maxAge = null)
    {
        if ($minAge) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) >= ?', [$minAge]);
        }
        if ($maxAge) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) <= ?', [$maxAge]);
        }
        return $query;
    }
}

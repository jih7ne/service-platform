<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'idService';

    protected $fillable = [
        'nomService',
        'description',
        'statut'
    ];

    public function demandes()
    {
        return $this->hasMany(DemandesIntervention::class, 'idService', 'idService');
    }

    public function intervenants()
    {
        return $this->belongsToMany(Intervenant::class, 'offres_services', 'idService', 'idIntervenant');
    }
}

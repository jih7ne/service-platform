<?php

namespace App\Models\SoutienScolaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Niveau extends Model
{
    public $timestamps = false;
    
    protected $table = 'niveaux';
    protected $primaryKey = 'id_niveau';

    protected $fillable = [
        'nom_niveau',
        'description',
    ];

    /**
     * Relation avec les services professeurs
     */
    public function servicesProf(): HasMany
    {
        return $this->hasMany(ServiceProf::class, 'niveau_id', 'id_niveau');
    }
}

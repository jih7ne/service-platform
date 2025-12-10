<?php

namespace App\Models\SoutienScolaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    public $timestamps = false;
    
    protected $table = 'matieres';
    protected $primaryKey = 'id_matiere';

    protected $fillable = [
        'nom_matiere',
        'description',
    ];

    /**
     * Relation avec les services professeurs
     */
    public function servicesProf(): HasMany
    {
        return $this->hasMany(ServiceProf::class, 'matiere_id', 'id_matiere');
    }
}

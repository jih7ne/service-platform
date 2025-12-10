<?php

namespace App\Models\SoutienScolaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceProf extends Model
{
    public $timestamps = false;
    
    protected $table = 'services_prof';
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'titre',
        'description',
        'prix_par_heure',
        'status',
        'type_service',
        'professeur_id',
        'matiere_id',
        'niveau_id',
    ];

    protected $casts = [
        'prix_par_heure' => 'double',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime',
    ];

    /**
     * Relation avec le professeur
     */
    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class, 'professeur_id', 'id_professeur');
    }

    /**
     * Relation avec la matière
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class, 'matiere_id', 'id_matiere');
    }

    /**
     * Relation avec le niveau
     */
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class, 'niveau_id', 'id_niveau');
    }

    /**
     * Relation avec les demandes professeurs
     */
    public function demandesProf(): HasMany
    {
        return $this->hasMany(DemandeProf::class, 'service_prof_id', 'id_service');
    }
}

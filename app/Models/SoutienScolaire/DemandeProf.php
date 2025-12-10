<?php

namespace App\Models\SoutienScolaire;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\DemandesIntervention;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeProf extends Model
{
    public $timestamps = false;
    
    protected $table = 'demandes_prof';
    protected $primaryKey = 'id_demande_prof';

    protected $fillable = [
        'montant_total',
        'service_prof_id',
        'demande_id',
    ];

    protected $casts = [
        'montant_total' => 'double',
    ];

    /**
     * Relation avec le service professeur
     */
    public function serviceProf(): BelongsTo
    {
        return $this->belongsTo(ServiceProf::class, 'service_prof_id', 'id_service');
    }

    /**
     * Relation avec la demande d'intervention
     */
    public function demandeIntervention(): BelongsTo
    {
        return $this->belongsTo(DemandesIntervention::class, 'demande_id', 'idDemande');
    }
}

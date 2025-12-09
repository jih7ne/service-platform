<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $table = 'factures';
    protected $primaryKey = 'idFacture';

    public $timestamps = false;

    protected $fillable = [
        'montantTotal',
        'numFacture',
        'idDemande'
    ];

    public function demande()
    {
        return $this->belongsTo(DemandesIntervention::class, 'idDemande', 'idDemande');
    }
}

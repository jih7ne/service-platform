<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OffreService extends Pivot
{
    protected $table = 'offres_services';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idIntervenant',
        'idService',
        'statut'
    ];
}

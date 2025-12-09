<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class OptionSuppPetKeepingClient extends Model
{
    protected $table = 'options_supp_petkeeping_client';
    protected $primaryKey = 'idOptionSuppClient';

    protected $fillable = [
        'idDemande',
        'idPetKeeper',
        'nomOption',
        'description',
        'categorieOption',
        'prix_supp',
    ];


    public const CATEGORIES = [
        'GROOMING','WALKING','TRAINING','MEDICATION',
        'PLAYTIME','PHOTO_UPDATES','PICKUP_DROPOFF'
    ];


    public function petKeeper()
    {
        return $this->belongsTo(PetKeeper::class, 'idPetKeeper', 'idPetKeeper');
    }

    public function demande()
    {
        return $this->belongsTo(\App\Models\Shared\DemandesIntervention::class, 'idDemande', 'idDemande');
    }
}

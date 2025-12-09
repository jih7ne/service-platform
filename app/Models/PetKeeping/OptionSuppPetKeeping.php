<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class OptionSuppPetKeeping extends Model
{
    protected $table = 'options_supp_petkeeping';
    protected $primaryKey = 'idOptionSupp';

    protected $fillable = [
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
}

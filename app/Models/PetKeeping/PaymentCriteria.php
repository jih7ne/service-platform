<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class PaymentCriteria extends Model
{
    protected $table = 'payment_criteria';
    protected $primaryKey = 'idPaymentCriteria';

    protected $fillable = [
        'idPetKeeper',
        'criteria',
        'description',
        'base_price',
    ];

    public const CRITERIA = [
        'PER_HOUR','PER_DAY','PER_NIGHT','PER_VISIT','PER_WALK',
        'PER_PET','PER_SPECIES','PER_WEIGHT','PER_SERVICE','PER_DISTANCE'
    ];

    public function petKeeper()
    {
        return $this->belongsTo(PetKeeper::class, 'idPetKeeper', 'idPetKeeper');
    }
}

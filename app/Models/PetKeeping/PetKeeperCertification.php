<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class PetKeeperCertification extends Model
{
    protected $table = 'petkeeper_certifications';
    protected $primaryKey = 'idCertification';

    protected $fillable = [
        'idPetKeeper',
        'certification',
        'document',
    ];

    public function petKeeper()
    {
        return $this->belongsTo(PetKeeper::class, 'idPetKeeper', 'idPetKeeper');
    }
}

<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class PetKeeper extends Model
{
    protected $table = 'petkeepers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idPetKeeper',
        'nombres_services_demandes',
        'specialite',
        'statut',
    ];

    public function intervenant()
    {
        return $this->belongsTo(\App\Models\Shared\Intervenant::class, 'idPetKeeper', 'idIntervenant');
    }

    public function certifications()
    {
        return $this->hasMany(PetKeeperCertification::class, 'idPetKeeper', 'idPetKeeper');
    }

    public function paymentCriteria()
    {
        return $this->hasMany(PaymentCriteria::class, 'idPetKeeper', 'idPetKeeper');
    }

    public function optionsSupp()
    {
        return $this->hasMany(OptionSuppPetKeeping::class, 'idPetKeeper', 'idPetKeeper');
    }
}

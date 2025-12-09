<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $table = 'localisations';
    protected $primaryKey = 'idLocalisation';

    protected $fillable = [
        'latitude',
        'longitude',
        'ville',
        'adresse',
        'idUser'
    ];

    public function user()
    {
        return $this->belongsTo(Utilisateur::class, 'idUser', 'idUser');
    }
}

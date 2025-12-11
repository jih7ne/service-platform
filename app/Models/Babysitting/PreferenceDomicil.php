<?php
// App/Models/Babysitting/PreferenceDomicil.php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class PreferenceDomicil extends Model
{
    protected $table = 'preference_domicils';
    protected $primaryKey = 'idDomicil';
    
    protected $fillable = [
        'domicil',
    ];

    public function babysitters()
    {
        return $this->belongsToMany(
            Babysitter::class,
            'choisir_domicils',
            'idDomicil',
            'idBabysitter'
        );
    }
}

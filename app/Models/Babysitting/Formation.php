<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $table = 'formations';
    protected $primaryKey = 'idFormation';
    public $timestamps = false;
    
    protected $fillable = ['formation'];

    public function babysitters()
    {
        return $this->belongsToMany(
            Babysitter::class,
            'choisir_formations',
            'idFormation',
            'idBabysitter'
        );
    }
}
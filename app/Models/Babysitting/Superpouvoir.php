<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class Superpouvoir extends Model
{
    protected $table = 'superpouvoirs';
    protected $primaryKey = 'idSuperpouvoir';
    public $timestamps = false;
    
    protected $fillable = ['superpouvoir'];

    public function babysitters()
    {
        return $this->belongsToMany(
            Babysitter::class,
            'choisir_superpourvoirs',
            'idSuperpouvoir',
            'idBabysitter'
        );
    }
}
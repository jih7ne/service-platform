<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class CategorieEnfant extends Model
{
    protected $table = 'categorie_enfants';
    protected $primaryKey = 'idCategorie';
    
    protected $fillable = ['categorie'];

    public function babysitters()
    {
        return $this->belongsToMany(
            Babysitter::class,
            'choisir_categories',
            'idCategorie',
            'idBabysitter'
        );
    }
}
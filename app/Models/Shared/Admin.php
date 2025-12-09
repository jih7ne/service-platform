<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'idAdmin';

    protected $fillable = [
        'emailAdmin',
        'passwordAdmin',
    ];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'idAdmin', 'idAdmin');
    }

    public function intervenants()
    {
        return $this->hasMany(Intervenant::class, 'idAdmin', 'idAdmin');
    }
}

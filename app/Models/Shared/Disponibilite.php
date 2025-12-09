<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    protected $table = 'disponibilites';
    protected $primaryKey = 'idDispo';
    public $timestamps = false;

    protected $fillable = [
        'heureDebut',
        'heureFin',
        'jourSemaine',
        'est_reccurent',
        'date_specifique',
        'idIntervenant'
    ];

    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idIntervenant', 'idIntervenant');
    }
}

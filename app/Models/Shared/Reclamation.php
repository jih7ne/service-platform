<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $table = 'reclamantions';
    protected $primaryKey = 'idReclamation';

    public $timestamps = false;

    protected $fillable = [
        'idCible',
        'idAuteur',
        'idFeedback',
        'statut',
        'preuves',
        'sujet',
        'dateCreation',
        'description',
        'priorite'
    ];

    public function auteur()
    {
        return $this->belongsTo(Utilisateur::class, 'idAuteur', 'idUser');
    }

    public function cible()
    {
        return $this->belongsTo(Utilisateur::class, 'idCible', 'idUser');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'idFeedback', 'idFeedBack');
    }
}

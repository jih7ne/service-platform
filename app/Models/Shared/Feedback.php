<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $primaryKey = 'idFeedBack';

    public $timestamps = false;

    protected $fillable = [
        'idAuteur',
        'idCible',
        'typeAuteur',
        'commentaire',
        'credibilite',
        'sympathie',
        'ponctualite',
        'proprete',
        'qualiteTravail',
        'estVisible',
        'dateAffichage',
        'dateCreation',
        'idDemande'
    ];

    public function auteur()
    {
        return $this->belongsTo(Utilisateur::class, 'idAuteur', 'idUser');
    }

    public function cible()
    {
        return $this->belongsTo(Utilisateur::class, 'idCible', 'idUser');
    }

    public function demande()
    {
        return $this->belongsTo(DemandesIntervention::class, 'idDemande', 'idDemande');
    }
}
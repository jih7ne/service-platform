<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    // C'est cette ligne qui corrige l'erreur 500
    protected $table = 'feedbacks'; 

    protected $primaryKey = 'idFeedBack';
    public $timestamps = false;

    protected $fillable = ['idAuteur', 'idCible', 'commentaire', 'qualiteTravail', 'dateCreation'];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'idAuteur', 'idUser');
    }
}
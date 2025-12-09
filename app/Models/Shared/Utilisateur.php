<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateur extends Model
{
    use SoftDeletes;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUser';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'statut',
        'role',
        'note',
        'photo',
        'nbrAvis',
        'dateNaissance',
        'idAdmin'
    ];

    

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'idAdmin', 'idAdmin');
    }

    public function intervenant()
    {
        return $this->hasOne(Intervenant::class, 'idIntervenant', 'idUser');
    }

    public function localisations()
    {
        return $this->hasMany(Localisation::class, 'idUser', 'idUser');
    }

    public function demandesClient()
    {
        return $this->hasMany(DemandesIntervention::class, 'idClient', 'idUser');
    }

    public function feedbacksRecus()
    {
        return $this->hasMany(Feedback::class, 'idCible', 'idUser');
    }

    public function feedbacksEnvoyes()
    {
        return $this->hasMany(Feedback::class, 'idAuteur', 'idUser');
    }

    public function reclamationsRecues()
    {
        return $this->hasMany(Reclamation::class, 'idCible', 'idUser');
    }

    public function reclamationsEnvoyees()
    {
        return $this->hasMany(Reclamation::class, 'idAuteur', 'idUser');
    }
}

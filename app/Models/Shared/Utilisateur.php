<?php

namespace App\Models\Shared;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Utilisateur extends Authenticatable
{
   use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUser';
    

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'dateNaissance' => 'date',
        'note' => 'float',
        'nbrAvis' => 'integer',
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
    protected static function newFactory()
    {
        return \Database\Factories\UtilisateurFactory::new();
    }
}
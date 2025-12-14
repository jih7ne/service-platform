<?php

namespace App\Models\Shared;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervenant extends Model
{
       use HasFactory; 
    protected $table = 'intervenants';
    protected $primaryKey = 'id';

    protected $fillable = [
        'statut',
        'idIntervenant',
        'idAdmin',
    ];
protected static function newFactory()
    {
        return \Database\Factories\IntervenantFactory::new();
    }
    public function user()
    {
        return $this->belongsTo(Utilisateur::class, 'IdIntervenant', 'idUser');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'IdIntervenant', 'idUser');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'idAdmin', 'idAdmin');
    }

    public function demandes()
    {
        return $this->hasMany(DemandesIntervention::class, 'idIntervenant', 'idIntervenant');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'offres_services', 'idIntervenant', 'idService', 'IdIntervenant', 'idService');
    }

    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class, 'idIntervenant', 'idIntervenant');
    }

    public function babysitter()
    {
        return $this->hasOne(\App\Models\Babysitting\Babysitter::class, 'idBabysitter', 'IdIntervenant');
    }
}

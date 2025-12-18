<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;
use App\Models\shared\Intervenant;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;
use App\Models\Babysitting\Disponibilite;
use App\Models\Babysitting\DemandeIntervention;

class Babysitter extends Model
{
    public $timestamps = false;
    
    protected $table = 'babysitters';
    protected $primaryKey = 'idBabysitter';
    
    protected $fillable = [
        'idBabysitter',
        'prixHeure',
        'expAnnee',
        'langues',
        'procedeJuridique',
        'coprocultureSelles',
        'certifAptitudeMentale',
        'radiographieThorax',
        'maladies',
        'estFumeur',
        'mobilite',
        'possedeEnfant',
        'permisConduite',
        'description',
        'niveauEtudes',
        'preference_domicil'
    ];

    protected $casts = [
        'estFumeur' => 'boolean',
        'mobilite' => 'boolean',
        'possedeEnfant' => 'boolean',
        'permisConduite' => 'boolean',
    ];

    // Relations
    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idBabysitter', 'IdIntervenant');
    }

    public function utilisateur()
    {
        return $this->belongsTo(\App\Models\Shared\Utilisateur::class, 'idBabysitter', 'idUser')->where('role', 'intervenant');
    }

    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class, 'idIntervenant', 'idBabysitter');
    }

    public function demandes()
    {
        return $this->hasMany(DemandeIntervention::class, 'idIntervenant', 'idBabysitter');
    }


    public function superpouvoirs()
    {
        return $this->belongsToMany(
            Superpouvoir::class,
            'choisir_superpourvoirs',
            'idBabysitter',
            'idSuperpouvoir'
        );
    }

    public function formations()
    {
        return $this->belongsToMany(
            Formation::class,
            'choisir_formations',
            'idBabysitter',
            'idFormation'
        );
    }

    public function categoriesEnfants()
    {
        return $this->belongsToMany(
            CategorieEnfant::class,
            'choisir_categories',
            'idBabysitter',
            'idCategorie'
        );
    }

    public function experiencesBesoinsSpeciaux()
    {
        return $this->belongsToMany(
            ExperienceBesoinSpeciaux::class,
            'choisir_experiences',
            'idBabysitter',
            'idExperience'
        );
    }

        // Accesseurs pour gérer les différents formats de données
    
    /**
     * Getter pour les langues - gère les différents formats
     */
    public function getLanguesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // Si c'est déjà un array (depuis le cast), retourner tel quel
        if (is_array($value)) {
            return $value;
        }

        // Essayer de décoder comme JSON
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Essayer de décoder une deuxième fois (cas du double-encodage)
        if (is_string($decoded)) {
            $doubleDecoded = json_decode($decoded, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                return $doubleDecoded;
            }
        }

        // Si c'est une chaîne avec des virgules, la séparer
        if (is_string($value) && strpos($value, ',') !== false) {
            return array_map('trim', explode(',', $value));
        }

        // Retourner en tant qu'array avec un seul élément
        return [$value];
    }

    /**
     * Setter pour les langues
     */
    public function setLanguesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['langues'] = json_encode($value);
        } else {
            $this->attributes['langues'] = $value;
        }
    }

    /**
     * Getter pour les maladies sous forme de liste
     */
    public function getMaladiesListAttribute()
    {
        if (empty($this->maladies)) {
            return [];
        }

        // Si séparé par des virgules ou des points
        $separators = [',', '.', ';', '|'];
        foreach ($separators as $sep) {
            if (strpos($this->maladies, $sep) !== false) {
                return array_filter(array_map('trim', explode($sep, $this->maladies)));
            }
        }

        return [$this->maladies];
    }

    // Scopes
    public function scopeValide($query)
    {
        return $query->whereHas('intervenant', function($q) {
            $q->where('statut', 'VALIDE');
        });
    }

    public function scopeDisponible($query)
    {
        return $query->whereHas('intervenant.disponibilites');
    }

    public function scopeParPrix($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('prixHeure', '>=', $min);
        }
        if ($max) {
            $query->where('prixHeure', '<=', $max);
        }
        return $query;
    }

    public function scopeParExperience($query, $experience)
    {
        return $query->where('expAnnee', $experience);
    }

    public function scopeAvecLangue($query, $langue)
    {
        return $query->where(function($q) use ($langue) {
            $q->where('langues', 'LIKE', "%{$langue}%")
              ->orWhereRaw("JSON_CONTAINS(langues, ?)", [json_encode($langue)]);
        });
    }

    public function getPreferenceDomicilLabelAttribute()
    {
        return match($this->preference_domicil) {
            'domicil_babysitter' => 'Au domicile de la babysitter',
            'domicil_client' => 'Au domicile du client',
            'les_deux' => 'Les deux options',
            default => 'Non spécifié'
        };
    }

    /**
     * Vérifie si la babysitter est disponible aujourd'hui
     */
    public function getEstDisponibleAttribute()
    {
        // Si elle a des disponibilités, on considère qu'elle est disponible
        $hasDispos = $this->disponibilites && $this->disponibilites->count() > 0;
        
        \Log::info('Babysitter disponibilité vérifiée', [
            'babysitter_id' => $this->idBabysitter,
            'has_disponibilites' => $hasDispos,
            'disponibilites_count' => $this->disponibilites ? $this->disponibilites->count() : 0
        ]);
        
        return $hasDispos;
    }

    /**
     * Vérifie si la babysitter est disponible pour un jour spécifique
     */
    public function isAvailableOnDay($day)
    {
        if (!$this->disponibilites || $this->disponibilites->count() === 0) {
            return false;
        }

        return $this->disponibilites->contains('jourSemaine', $day);
    }

    // public function disponibilites()
    // {
    //     return $this->hasMany(Disponibilite::class, 'idIntervenant', 'idBabysitter');
    // }

    
    
}
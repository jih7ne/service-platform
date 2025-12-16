<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'heureDebut' => 'datetime:H:i',
        'heureFin' => 'datetime:H:i',
        'date_specifique' => 'date',
        'est_reccurent' => 'boolean',
    ];

    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idIntervenant', 'idIntervenant');
    }

    public function scopeForIntervenant($query, $intervenantId)
    {
        return $query->where('idIntervenant', $intervenantId);
    }

    public function scopeRecurrent($query)
    {
        return $query->where('est_reccurent', true);
    }

    public function scopeSpecific($query)
    {
        return $query->where('est_reccurent', false);
    }

    public function scopeForDay($query, $day)
    {
        return $query->where('jourSemaine', $day);
    }

    public function scopeForDate($query, $date)
    {
        $dayName = Carbon::parse($date)->format('l');
        $dayNameFr = match($dayName) {
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi', 
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
            default => $dayName
        };

        return $query->where(function($q) use ($date, $dayNameFr) {
            $q->where('est_reccurent', true)
              ->where('jourSemaine', $dayNameFr)
              ->orWhere(function($subQuery) use ($date) {
                  $subQuery->where('est_reccurent', false)
                           ->where('date_specifique', $date);
              });
        });
    }

    public function getHeureDebutAttribute($value)
    {
        return $value ? substr($value, 0, 5) : null;
    }

    public function getHeureFinAttribute($value)
    {
        return $value ? substr($value, 0, 5) : null;
    }

    public function isAvailableAt($dateTime)
    {
        $carbon = Carbon::parse($dateTime);
        $time = $carbon->format('H:i');
        $date = $carbon->format('Y-m-d');

        if ($this->est_reccurent) {
            $dayName = $carbon->format('l');
            $dayNameFr = match($dayName) {
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi', 
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche',
                default => $dayName
            };

            return $this->jourSemaine === $dayNameFr && 
                   $time >= $this->heureDebut && 
                   $time <= $this->heureFin;
        } else {
            return $this->date_specifique === $date && 
                   $time >= $this->heureDebut && 
                   $time <= $this->heureFin;
        }
    }
}

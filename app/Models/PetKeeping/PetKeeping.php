<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class PetKeeping extends Model
{
    protected $table = 'petkeeping';
    protected $primaryKey = 'id';

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_ARCHIVED = 'ARCHIVED';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_ARCHIVED,
    ];

    public const CATEGORIES = [
        'A_DOMICILE',
        'DEPLACEMENT',
        'PENSION',
        'PROMENADE',
        'GARDERIE',
        'DRESSAGE',
    ];


    protected $fillable = [
        'idPetKeeping',
        'idPetKeeper',
        'categorie_petkeeping',
        'accepts_aggressive_pets',
        'accepts_untrained_pets',
        'vaccination_required',
        'pet_type',
        'statut',
    ];

    public function services()
    {
        return $this->hasMany(\App\Models\Shared\Service::class, 'idService', 'idPetKeeping');
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Shared\Service::class, 'idPetKeeping', 'idService');
    }

    public function petKeeper()
    {
        return $this->belongsTo(\App\Models\PetKeeping\PetKeeper::class, 'idPetKeeper', 'idPetKeeper');
    }

    public function who(){
        return $this->idPetKeeper;
    }

    public function which(){
        return $this->idPetKeeping;
    }

    public function getCategory(){
        return $this->categorie_petkeeping;
    }

    public function getPetType(){
        return $this->pet_type;
    }

    public function getStatus(){
        return $this->statut;
    }

    public function isActive(): bool
    {
        return $this->statut === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->statut === self::STATUS_INACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->statut === self::STATUS_ARCHIVED;
    }

    public function requiresVaccination(){
        return $this->vaccination_required;
    }

    public function acceptsUntrainedPets(){
        return $this->accepts_untrained_pets;
    }

    public function acceptsAggressivePets(){
        return $this->accepts_aggressive_pets;
    }

    public function updateStatus(string $status): bool
    {
        if (!in_array($status, self::STATUSES)) {
            return false;
        }

        return $this->update(['statut' => $status]);
    }

    public function updateCategory(string $category): bool
    {
        if (!in_array($category, self::CATEGORIES)) {
            return false;
        }

        return $this->update(['categorie_petkeeping' => $category]);
    }
}

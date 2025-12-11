<?php

namespace App\Constants\PetKeeping;

class Constants
{
    public const DOG = 'Dog';
    public const CAT = 'Cat';
    public const BIRD = 'Bird';
    public const RABBIT = 'Rabbit';
    public const HORSE = 'Horse';
    public const TYPE_ALL = 'All';


    //Payment Criteria
    public const PER_HOUR = 'per hour';
    public const PER_DAY = 'per day';
    public const PER_VISIT = 'per visit';
    public const PER_WALK = 'per walk';
    public const PER_PET = 'per pet';
    public const PER_SPECIES = 'per species';
    public const PER_WEIGHT = 'per weight';
    public const PER_SERVICE = 'per service';
    public const PER_DISTANCE = 'per distance';


    public const OPTIONS_SUPP = [

    ];

    public const PET_TYPE = [
        self::BIRD,
        self::DOG,
        self::CAT,
        self::RABBIT,
        self::HORSE,
        self::TYPE_ALL,
    ];

    public const PAY_CRITERIA = [
        self::PER_HOUR,
        self::PER_DAY,
        self::PER_VISIT,
        self::PER_WALK,
        self::PER_PET,
        self::PER_SPECIES,
        self::PER_WEIGHT,
        self::PER_SERVICE,
        self::PER_DISTANCE,
    ];
}
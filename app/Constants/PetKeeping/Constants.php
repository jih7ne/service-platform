<?php

namespace App\Constants\PetKeeping;

class Constants
{

    public const ALL = 'tous/toutes';

    public const DOG = 'Chien';
    public const CAT = 'Chat';
    public const BIRD = 'Oiseau';
    public const RABBIT = 'Lapin';
    public const HORSE = 'Cheval';
    public const FISH = 'Poisson';
    public const REPTILE = 'Reptile';
    public const RODENT = 'Rongeur';
    public const FERRET = 'Furet';
    public const AMPHIBIAN = 'Amphibien';
    public const EXOTIC = 'Exotique';


    //Payment Criteria
    public const PER_HOUR = 'par heure';
    public const PER_DAY = 'par jour';
    public const PER_VISIT = 'par visite';
    public const PER_WALK = 'par promenade';
    public const PER_PET = 'par animal';
    public const PER_SPECIES = 'par espèce';
    public const PER_WEIGHT = 'par poids';
    public const PER_SERVICE = 'par service';
    public const PER_DISTANCE = 'par distance';

    public const LIST_PETS = [
        'all'       => ['label' => 'Tous',   'emoji' => '🐾', 'icon' => 'fa-paw'            ],
        'dog'       => ['label' => 'Chien',       'emoji' => '🐕', 'icon' => 'fa-dog'        ],
        'cat'       => ['label' => 'Chat',       'emoji' => '🐈', 'icon' => 'fa-cat'        ],
        'bird'      => ['label' => 'Oiseau',      'emoji' => '🐦', 'icon' => 'fa-dove'       ],
        'rabbit'    => ['label' => 'Lapin',    'emoji' => '🐇', 'icon' => 'fa-rabbit'     ],
        'small'     => ['label' => 'Small Pets', 'emoji' => '🐹', 'icon' => 'fa-hamster'    ],
        'horse'     => ['label' => 'Cheval',     'emoji' => '🐴', 'icon' => 'fa-horse'      ],
        'reptile'   => ['label' => 'Reptile',   'emoji' => '🦎', 'icon' => 'fa-dragon'     ],
        'fish'      => ['label' => 'Poisson',       'emoji' => '🐠', 'icon' => 'fa-fish'       ],
    ];

    public const CRITERIA = [
        'all' => ['label' => 'Toutes les critères', 'emoji' => '📋', 'key' => 'all'],
        'PER_HOUR' => ['label' => 'Par heure', 'emoji' => '⏰', 'key' => 'PER_HOUR', 'unit' => 'heure'],
        'PER_DAY' => ['label' => 'Par jour', 'emoji' => '📅', 'key' => 'PER_DAY', 'unit' => 'jour'],
        'PER_VISIT' => ['label' => 'Par visite', 'emoji' => '👁️', 'key' => 'PER_VISIT', 'unit' => 'visite'],
        'PER_WALK' => ['label' => 'Par promenade', 'emoji' => '🚶', 'key' => 'PER_WALK', 'unit' => 'promenade'],
        'PER_PET' => ['label' => 'Par animal', 'emoji' => '🐾', 'key' => 'PER_PET', 'unit' => 'animal'],
        'PER_SPECIES' => ['label' => 'Par espèce', 'emoji' => '🐕🐈', 'key' => 'PER_SPECIES', 'unit' => 'espèce'],
        'PER_WEIGHT' => ['label' => 'Par poids', 'emoji' => '⚖️', 'key' => 'PER_WEIGHT', 'unit' => 'poids'],
        'PER_SERVICE' => ['label' => 'Par service', 'emoji' => '🛠️', 'key' => 'PER_SERVICE', 'unit' => 'service'],
        'PER_DISTANCE' => ['label' => 'Par distance', 'emoji' => '📏', 'key' => 'PER_DISTANCE', 'unit' => 'km'],
        'PER_NIGHT' => ['label' => 'Par nuit', 'emoji' => '🌙', 'key' => 'PER_NIGHT', 'unit' => 'nuit'],
        'PER_KM' => ['label' => 'Par kilomètre', 'emoji' => '🛣️', 'key' => 'PER_KM', 'unit' => 'km'],
        'FIXED_PRICE' => ['label' => 'Prix fixe', 'emoji' => '💰', 'key' => 'FIXED_PRICE', 'unit' => 'forfait'],
        'PER_WEEK' => ['label' => 'Par semaine', 'emoji' => '🗓️', 'key' => 'PER_WEEK', 'unit' => 'semaine'],
        'PER_MONTH' => ['label' => 'Par mois', 'emoji' => '📆', 'key' => 'PER_MONTH', 'unit' => 'mois'],
    ];

    public const CATEGORIES = [
        'all' => ['label' => 'Toutes les catégories', 'emoji' => '📋', 'key' => 'all'],
        'PENSION' => ['label' => 'Pension/Boarding', 'emoji' => '🏠', 'key' => 'PENSION'],
        'A_DOMICILE' => ['label' => 'À domicile', 'emoji' => '🏡', 'key' => 'A_DOMICILE'],
        'PROMENADE' => ['label' => 'Promenade', 'emoji' => '🚶', 'key' => 'PROMENADE'],
        'GARDERIE' => ['label' => 'Garde de jour', 'emoji' => '🏢', 'key' => 'GARDERIE'],
        'DRESSAGE' => ['label' => 'Dressage', 'emoji' => '🎓', 'key' => 'DRESSAGE'],
        'DEPLACEMENT' => ['label' => 'Service mobile', 'emoji' => '🚗', 'key' => 'DEPLACEMENT'],
        'SOINS' => ['label' => 'Toilettage/Soins', 'emoji' => '💇', 'key' => 'SOINS'],
        'SANTE' => ['label' => 'Santé/Vétérinaire', 'emoji' => '🏥', 'key' => 'SANTE'],
        'URGENCE' => ['label' => 'Urgence', 'emoji' => '🚨', 'key' => 'URGENCE'],
        'VISITE' => ['label' => 'Visite', 'emoji' => '👁️', 'key' => 'VISITE'],
        'JARDINAGE' => ['label' => 'Jardinage animalier', 'emoji' => '🌿', 'key' => 'JARDINAGE'],
    ];


    


    public const PAY_CRITERIA = [
        self::ALL,
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


    public static function getTypes(): array
    {
        return self::LIST_PETS;
    }
    
    public static function getOptions(): array
    {
        return array_map(function($type) {
            return $type['emoji'] . ' ' . $type['label'];
        }, self::LIST_PETS);
    }
    
    public static function getSelectOptions(): array
    {
        $options = [];
        foreach (self::LIST_PETS as $key => $type) {
            $options[$key] = $type['emoji'] . ' ' . $type['label'];
        }
        return $options;
    }

    public static function forSelect(bool $includeAll = true): array
    {
        $options = [];
        
        foreach (self::CATEGORIES as $key => $category) {
            if (!$includeAll && $key === 'all') {
                continue;
            }
            $options[$category['key']] = $category['emoji'] . ' ' . $category['label'];
        }
        
        return $options;
    }

    public static function forSelectCriteria(): array
    {
        $options = [];
        
        foreach (self::CRITERIA as $key => $criterion) {
            $options[$criterion['key']] = $criterion['emoji'] . ' ' . $criterion['label'];
        }
        
        return $options;
    }

    public static function getCriteriaLabel(string $key): string
    {
        foreach (self::CRITERIA as $criterion) {
            if ($criterion['key'] === $key) {
                return $criterion['label'];
            }
        }
        return $key;
    }


    public static function forSelectArray(bool $includeAll = true): array
    {
        $options = [];
        
        foreach (self::CATEGORIES as $key => $category) {
            if (!$includeAll && $key === 'all') {
                continue;
            }
            $options[] = [
                'value' => $category['key'],
                'label' => $category['emoji'] . ' ' . $category['label'],
                'emoji' => $category['emoji'],
            ];
        }
        
        return $options;
    }
    
    public static function getLabel(string $key): string
    {
        return self::LIST_PETS[$key]['label'] ?? $key;
    }

    public static function getCategoryLabel(string $key): string
    {
        foreach (self::CATEGORIES as $category) {
            if ($category['key'] === $key) {
                return $category['label'];
            }
        }
        return $key;
    }
    
    public static function getEmoji(string $key): string
    {
        return self::LIST_PETS[$key]['emoji'] ?? '';
    }

    
}
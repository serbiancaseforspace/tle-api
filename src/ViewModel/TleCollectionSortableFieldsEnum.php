<?php

namespace App\ViewModel;

use MyCLabs\Enum\Enum;

class TleCollectionSortableFieldsEnum extends Enum
{
    public const ID = 'id';
    public const NAME = 'name';
    public const POPULARITY = 'popularity';
    public const INCLINATION = 'inclination';
    public const ECCENTRICITY = 'eccentricity';
    public const PERIOD = 'period';
    public const RAAN = 'raan';
    public const SEMI_MAJOR_AXIS = 'semi_major_axis';
}

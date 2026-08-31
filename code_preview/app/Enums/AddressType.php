<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AddressType: string implements  HasLabel
{
    case RESIDENTIAL = 'Residential';
    case REGISTERED = 'Registered';
    case CORRESPONDENCE = 'Correspondence';
    case WORK = 'Work';
    case OTHER = 'Other';

    public function getLabel(): string
    {
        return match ($this) {
            self::RESIDENTIAL => 'Residential',
            self::REGISTERED => 'Registered',
            self::CORRESPONDENCE => 'Correspondence',
            self::WORK => 'Work',
            self::OTHER => 'Other',
        };
    }
    public function getColor(): string|array|null
    {
        return match($this) {
            self::RESIDENTIAL => 'success',
            self::REGISTERED => 'primary',
            self::CORRESPONDENCE => 'warning',
            self::WORK => 'secondary',
            self::OTHER => 'danger',
            default => 'gray',
        };
    }
}

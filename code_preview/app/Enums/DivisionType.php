<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DivisionType: string implements HasLabel
{
    case STATE = 'state';
    case PROVINCE = 'province';
    case REGION = 'region';
    case DISTRICT = 'district';
    case COUNTY = 'county';
    case MUNICIPALITY = 'municipality';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::STATE => 'State',
            self::PROVINCE => 'Province',
            self::REGION => 'Region',
            self::DISTRICT => 'District',
            self::COUNTY => 'County',
            self::MUNICIPALITY => 'Municipality',
            self::OTHER => 'Other',
        };
    }
    public static function getLabelOptionsForCountry(?string $countryCode): array
    {
        // test: 'pl' and  'gb' are code iso 3166-1 alpha-2 country codes for Poland and United Kingdom respectively.
        return match ($countryCode) {
            'PL' => [
                self::COUNTY->value => 'Powiat',
                self::MUNICIPALITY->value => 'Gmina',
            ],
            'GB' => [
                self::COUNTY->value => 'County',
                self::MUNICIPALITY->value => 'District',
            ],
            default => [
                self::DISTRICT->value => self::DISTRICT->getLabel(),
                self::COUNTY->value => self::COUNTY->getLabel(),
                self::MUNICIPALITY->value => self::MUNICIPALITY->getLabel(),
            ],
        };
    }
}
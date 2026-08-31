<?php

namespace App\Filament\Clusters\Registry;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class RegistryCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ListBullet;
}

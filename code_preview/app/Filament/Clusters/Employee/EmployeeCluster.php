<?php

namespace App\Filament\Clusters\Employee;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class EmployeeCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;
}

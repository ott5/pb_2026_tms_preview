<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CountryRegion;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryRegionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CountryRegion');
    }

    public function view(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('View:CountryRegion');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CountryRegion');
    }

    public function update(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('Update:CountryRegion');
    }

    public function delete(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('Delete:CountryRegion');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CountryRegion');
    }

    public function restore(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('Restore:CountryRegion');
    }

    public function forceDelete(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('ForceDelete:CountryRegion');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CountryRegion');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CountryRegion');
    }

    public function replicate(AuthUser $authUser, CountryRegion $countryRegion): bool
    {
        return $authUser->can('Replicate:CountryRegion');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CountryRegion');
    }

}
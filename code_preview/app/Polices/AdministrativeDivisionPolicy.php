<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AdministrativeDivision;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdministrativeDivisionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AdministrativeDivision');
    }

    public function view(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('View:AdministrativeDivision');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AdministrativeDivision');
    }

    public function update(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('Update:AdministrativeDivision');
    }

    public function delete(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('Delete:AdministrativeDivision');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AdministrativeDivision');
    }

    public function restore(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('Restore:AdministrativeDivision');
    }

    public function forceDelete(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('ForceDelete:AdministrativeDivision');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AdministrativeDivision');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AdministrativeDivision');
    }

    public function replicate(AuthUser $authUser, AdministrativeDivision $administrativeDivision): bool
    {
        return $authUser->can('Replicate:AdministrativeDivision');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AdministrativeDivision');
    }

}
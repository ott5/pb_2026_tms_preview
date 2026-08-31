<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PostalCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostalCodePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PostalCode');
    }

    public function view(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('View:PostalCode');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PostalCode');
    }

    public function update(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('Update:PostalCode');
    }

    public function delete(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('Delete:PostalCode');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PostalCode');
    }

    public function restore(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('Restore:PostalCode');
    }

    public function forceDelete(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('ForceDelete:PostalCode');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PostalCode');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PostalCode');
    }

    public function replicate(AuthUser $authUser, PostalCode $postalCode): bool
    {
        return $authUser->can('Replicate:PostalCode');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PostalCode');
    }

}
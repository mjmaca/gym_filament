<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TrainingType;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_training::type');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingType $trainingType): bool
    {
        return $user->can('view_training::type');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_training::type');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingType $trainingType): bool
    {
        return $user->can('update_training::type');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingType $trainingType): bool
    {
        return $user->can('delete_training::type');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_training::type');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, TrainingType $trainingType): bool
    {
        return $user->can('force_delete_training::type');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_training::type');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, TrainingType $trainingType): bool
    {
        return $user->can('restore_training::type');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_training::type');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, TrainingType $trainingType): bool
    {
        return $user->can('replicate_training::type');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_training::type');
    }
}

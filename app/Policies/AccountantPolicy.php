<?php

namespace App\Policies;

use App\Models\Accountant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AccountantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Accountant $accountant
     * @return void
     */
    public function view(User $user, Accountant $accountant): void
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return void
     */
    public function create(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Accountant $accountant
     * @return void
     */
    public function update(User $user, Accountant $accountant): void
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Accountant $accountant
     * @return void
     */
    public function delete(User $user, Accountant $accountant): void
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Accountant $accountant
     * @return void
     */
    public function restore(User $user, Accountant $accountant): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Accountant $accountant
     * @return void
     */
    public function forceDelete(User $user, Accountant $accountant): void
    {
        //
    }
}

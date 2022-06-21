<?php

namespace App\Policies;

use App\Models\UsergroupThemes;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsergroupThemesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        return TRUE;

    }
    public function index(User $user)
    {
        //
        return TRUE;

    }
    public function browse(){
        return true;
    }

    public function add(){
        return true;
    }

    public function edit(){
        return true;
    }

    public function read(){
        return true;
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tours  $tours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UsergroupThemes $tours)
    {
        //
        return TRUE;

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return TRUE;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tours  $tours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UsergroupThemes $tours)
    {
        //
        return TRUE;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tours  $tours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UsergroupThemes $tours)
    {
        //
        return TRUE;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tours  $tours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UsergroupThemes $tours)
    {
        //
        return TRUE;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tours  $tours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UsergroupThemes $tours)
    {
        //
        return TRUE;

    }
}

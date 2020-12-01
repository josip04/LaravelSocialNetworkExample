<?php

namespace App\Policies;

use App\Comments;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comments  $comments
     * @return mixed
     */
    public function view(User $user, Comments $comments)
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user || $user->is_admin) return true;
    }

    /**
     * Determine whether the user can update the comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comments  $comments
     * @return mixed
     */
    public function update(User $user, Comments $comment)
    {
        if($user->is_admin) return true;
        return $comment->user->is($user);
    }

    /**
     * Determine whether the user can delete the comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comments  $comments
     * @return mixed
     */
    public function delete(User $user, Comments $comment)
    {
        if($user->is_admin) return true;
        return $comment->user->is($user);
    }

    /**
     * Determine whether the user can restore the comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comments  $comments
     * @return mixed
     */
    public function restore(User $user, Comments $comments)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comments  $comments
     * @return mixed
     */
    public function forceDelete(User $user, Comments $comments)
    {
        return $user->is_admin;
    }
}

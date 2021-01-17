<?php

namespace App\Policies;

use App\Comments;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentsPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if ($user->isSuperAdmin($user)){
            return true;
        }
    }

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
        return true;
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
        //
    }
}

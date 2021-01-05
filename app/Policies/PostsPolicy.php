<?php

namespace App\Policies;

use App\Posts;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if ($user->isSuperAdmin($user)){
            return true;
        }
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the posts.
     *
     * @param  \App\User  $user
     * @param  \App\Posts  $posts
     * @return mixed
     */
    public function view(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //if($user || $user->is_admin) return true;
    }

    /**
     * Determine whether the user can update the posts.
     *
     * @param  \App\User  $user
     * @param  \App\Posts  $posts
     * @return mixed
     */
    public function update(User $user, Posts $post)
    {  
        return $post->author->is($user);
    }

    /**
     * Determine whether the user can delete the posts.
     *
     * @param  \App\User  $user
     * @param  \App\Posts  $posts
     * @return mixed
     */
    public function delete(User $user,Posts $post)
    {
        return $post->author->is($user);
    }

    /**
     * Determine whether the user can restore the posts.
     *
     * @param  \App\User  $user
     * @param  \App\Posts  $posts
     * @return mixed
     */
    public function restore(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the posts.
     *
     * @param  \App\User  $user
     * @param  \App\Posts  $posts
     * @return mixed
     */
    public function forceDelete(User $user, Posts $posts)
    {
        return $user->is_admin;
    }
}

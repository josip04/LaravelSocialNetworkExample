<?php

namespace App\Observers;

use App\Posts;

class PostsObserver
{
    /**
     * Handle the posts "created" event.
     *
     * @param  \App\Posts  $posts
     * @return void
     */
    public function created(Posts $posts)
    {
        //
    }

    /**
     * Handle the posts "updated" event.
     *
     * @param  \App\Posts  $posts
     * @return void
     */
    public function updated(Posts $posts)
    {
        //
    }


    public function deleting(Posts $post)
    {
        $post->comments()->delete();
        $post->likes()->delete();
    }

    /**
     * Handle the posts "deleted" event.
     *
     * @param  \App\Posts  $posts
     * @return void
     */
    public function deleted(Posts $posts)
    {
        //
    }

    /**
     * Handle the posts "restored" event.
     *
     * @param  \App\Posts  $posts
     * @return void
     */
    public function restored(Posts $posts)
    {
        //
    }

    /**
     * Handle the posts "force deleted" event.
     *
     * @param  \App\Posts  $posts
     * @return void
     */
    public function forceDeleted(Posts $posts)
    {
        //
    }
}

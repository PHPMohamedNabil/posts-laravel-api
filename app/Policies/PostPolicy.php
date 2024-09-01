<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id ?Response::allow()
                : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id? Response::allow()
                : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return bool
     */
    public function restore(User $user, Post $post)
    {
        return $user->id === $post->user_id? Response::allow()
                : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return bool
     */
    public function forceDelete(User $user, Post $post)
    {
        return $user->id === $post->user_id? Response::allow()
                : Response::deny('You do not own this post.');
    }
}

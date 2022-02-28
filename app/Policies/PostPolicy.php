<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Post $post)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function updateStatus(User $user, Post $post)
    {
        return $user->is_admin;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}

<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        $hasPermission = $user->id === $comment->user_id || $user->hasRole(['admin', 'moderator']);

        return $hasPermission;
    }

    public function delete(User $user, Comment $comment): bool
    {
        $hasPermission = $user->id === $comment->user_id || $user->hasRole(['admin', 'moderator']);

        return $hasPermission;
    }
}

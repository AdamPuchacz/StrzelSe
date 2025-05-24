<?php

namespace App\Policies;

use App\Models\ForumTopic;
use App\Models\User;

class TopicPolicy
{
    /**
     * Sprawdza, czy użytkownik może edytować post.
     */
    public function update(User $user, ForumTopic $post): bool
    {

        return $user->id === $post->user_id || $user->hasRole(['admin', 'moderator']);
    }

    /**
     * Sprawdza, czy użytkownik może usunąć post.
     */
    public function delete(User $user, ForumTopic $post): bool
    {

        return $user->id === $post->user_id || $user->hasRole(['admin', 'moderator']);
    }
}

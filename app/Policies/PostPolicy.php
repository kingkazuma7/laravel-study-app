<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    // edit() - 編集フォーム表示
    public function edit(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // update() - 編集実行
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // destroy() - 削除実行
    public function destroy(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}

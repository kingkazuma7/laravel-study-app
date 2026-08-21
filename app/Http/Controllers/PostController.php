<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        Post::create($validated);
        return redirect('/posts')->with('message', '記事を作成しました');
    }

    public function show(Post $post)
    {
        $post->increment('views');
        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update($validated);
        return redirect('/posts')->with('message', '記事を更新しました!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('message', '記事を削除しました！');
    }
}

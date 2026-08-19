<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 全記事を一覧表示
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]); // ビューに渡す
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('posts.create');
    }

    // フォーム送信時のデータ保存
    public function store(Request $request)
    {
        $validated = $request->validate(([
          'title' => 'required|string|max:255',
          'body' => 'required|string',
          'author' => 'required|string|max:255',
        ]));

        Post::create($validated); // dbに保存
        return redirect('/posts')->with('message', '記事を作成しました');
    }

    // 記事詳細を表示＆閲覧数をカウント
    public function show(Post $post)
    {
        $post->increment('views');
        return view('posts.show', ['post' => $post]);
    }

    // 編集フォーム表示
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    // 更新処理
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
          'title' => 'required|string|max:255',
          'body' => 'required|string',
          'author' => 'required|string|max:255',
        ]);

        $post->update($validated); // db更新
        return redirect('/posts')->with('message', '記事を更新しました!');
    }

    // 削除処理
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('message', '記事を削除しました！');
    }
}

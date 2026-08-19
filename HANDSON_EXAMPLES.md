# Laravelハンズオン実例集

セットアップ完了後、実際にこれらのステップを実行して学びましょう。

---

## 例1: ブログシステムの構築

### Step 1: ファイル生成

```bash
# コンテナ内に入る
docker-compose exec app bash

# またはコマンドを直接実行（推奨）
docker-compose exec app php artisan make:model Post -m -c --resource
```

生成されるファイル：
- `app/Models/Post.php` - モデル
- `app/Http/Controllers/PostController.php` - コントローラー
- `database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php` - マイグレーション

### Step 2: マイグレーション編集

`database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php` を編集：

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('body');
        $table->string('author')->default('Anonymous');
        $table->integer('views')->default(0);
        $table->timestamps();
    });
}
```

### Step 3: マイグレーション実行

```bash
docker-compose exec app php artisan migrate
```

### Step 4: コントローラー実装

`app/Http/Controllers/PostController.php`：

```php
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

    public function show(Post $post)
    {
        $post->increment('views'); // 閲覧数を増やす
        return view('posts.show', ['post' => $post]);
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
            'author' => 'required|string|max:255',
        ]);

        Post::create($validated);

        return redirect('/posts')->with('message', '記事を作成しました！');
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
            'author' => 'required|string|max:255',
        ]);

        $post->update($validated);

        return redirect("/posts/{$post->id}")->with('message', '記事を更新しました！');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('message', '記事を削除しました！');
    }
}
```

### Step 5: ルート定義

`routes/web.php` に追加：

```php
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class);
```

### Step 6: ビュー作成

#### 1. 一覧ビュー（`resources/views/posts/index.blade.php`）

```blade
<!DOCTYPE html>
<html>
<head>
    <title>ブログ一覧</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>📝 ブログ一覧</h1>
    
    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <a href="/posts/create" style="background: #007bff; color: white; padding: 8px; text-decoration: none;">
        ➕ 新規作成
    </a>

    <table>
        <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>著者</th>
            <th>閲覧数</th>
            <th>作成日</th>
            <th>操作</th>
        </tr>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></td>
            <td>{{ $post->author }}</td>
            <td>{{ $post->views }}</td>
            <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
            <td>
                <a href="/posts/{{ $post->id }}/edit">編集</a> |
                <form action="/posts/{{ $post->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
```

#### 2. 詳細ビュー（`resources/views/posts/show.blade.php`）

```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $post->title }}</title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 800px; }
    </style>
</head>
<body>
    <a href="/posts">← 一覧に戻る</a>

    <h1>{{ $post->title }}</h1>
    <p>著者: {{ $post->author }} | 閲覧数: {{ $post->views }} | 
       作成日: {{ $post->created_at->format('Y-m-d H:i') }}</p>

    <hr>

    <p>{{ nl2br($post->body) }}</p>

    <hr>

    <a href="/posts/{{ $post->id }}/edit">✏️ 編集</a> |
    <a href="/posts">📋 一覧に戻る</a>
</body>
</html>
```

#### 3. 作成フォーム（`resources/views/posts/create.blade.php`）

```blade
<!DOCTYPE html>
<html>
<head>
    <title>新規作成</title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 800px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; }
        button { background: #28a745; color: white; padding: 10px 20px; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>📝 新しい記事を作成</h1>

    <form action="/posts" method="POST">
        @csrf

        <label>タイトル</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title')<p class="error">{{ $message }}</p>@enderror

        <label>著者</label>
        <input type="text" name="author" value="{{ old('author') }}" required>
        @error('author')<p class="error">{{ $message }}</p>@enderror

        <label>本文</label>
        <textarea name="body" rows="10" required>{{ old('body') }}</textarea>
        @error('body')<p class="error">{{ $message }}</p>@enderror

        <button type="submit">作成</button>
        <a href="/posts">キャンセル</a>
    </form>
</body>
</html>
```

#### 4. 編集フォーム（`resources/views/posts/edit.blade.php`）

```blade
<!DOCTYPE html>
<html>
<head>
    <title>編集</title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 800px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; }
        button { background: #ffc107; color: black; padding: 10px 20px; cursor: pointer; margin-right: 10px; }
    </style>
</head>
<body>
    <h1>✏️ 記事を編集</h1>

    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')

        <label>タイトル</label>
        <input type="text" name="title" value="{{ $post->title }}" required>

        <label>著者</label>
        <input type="text" name="author" value="{{ $post->author }}" required>

        <label>本文</label>
        <textarea name="body" rows="10" required>{{ $post->body }}</textarea>

        <button type="submit">更新</button>
        <a href="/posts/{{ $post->id }}">キャンセル</a>
    </form>
</body>
</html>
```

### Step 7: テスト

```bash
# ブラウザで以下にアクセス
http://localhost:8000/posts

# 以下の操作を試す
# 1. 「新規作成」をクリック
# 2. フォームに入力して「作成」
# 3. 記事が一覧に表示される
# 4. 記事をクリックすると詳細が表示される
# 5. 「編集」ボタンで内容を変更
# 6. 「削除」で削除
```

---

## 例2: ユーザー管理システム（応用）

### Step 1: ファイル生成

```bash
docker-compose exec app php artisan make:model User -m -c --resource
```

Laravelには `users` テーブルがデフォルトで用意されているため、既存マイグレーションを活用もできます。

### Step 2: モデルにリレーション追加

`app/Models/User.php`：

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // 1ユーザーが複数の投稿を持つ
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
```

`app/Models/Post.php`：

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'author', 'user_id', 'views'];

    // 複数の投稿が1つのユーザーに属する
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### Step 3: コントローラーでリレーション活用

```php
// ユーザーの全投稿を取得
$user = User::find(1);
$posts = $user->posts;

// 投稿からユーザーを取得
$post = Post::find(1);
$author = $post->user->name;
```

---

## 例3: よくあるエラーと解決方法

### エラー: "Target class does not exist"

**原因**: ルートでコントローラーを正しく指定していない

```php
// ❌ 間違い
Route::get('/posts', 'PostController@index');

// ✅ 正しい（Laravel 8以上）
use App\Http\Controllers\PostController;
Route::get('/posts', [PostController::class, 'index']);
```

### エラー: "Column not found"

**原因**: マイグレーションを実行していない

```bash
docker-compose exec app php artisan migrate
```

### エラー: "TokenMismatchException"

**原因**: POSTフォームに @csrf を入れていない

```blade
<form method="POST" action="/posts">
    @csrf  {{-- 必須 --}}
    <input type="text" name="title">
    <button type="submit">送信</button>
</form>
```

### エラー: "Undefined variable"

**原因**: コントローラーからビューに変数を渡していない

```php
// ✅ 正しい
return view('posts.show', ['post' => $post]);

// または
return view('posts.show', compact('post'));
```

---

## 例4: データベース操作（Tinker）

Laravelの対話型シェル **Tinker** を使ってデータベースを操作：

```bash
docker-compose exec app php artisan tinker

# ここで以下のコマンドが使える
>>> Post::all()
>>> Post::find(1)
>>> Post::where('author', '田中')->first()
>>> Post::create(['title' => 'テスト', 'body' => '本文', 'author' => '太郎'])
>>> $post = Post::find(1); $post->title = '更新'; $post->save();
>>> Post::find(1)->delete()
```

---

## 例5: よく使うArtisanコマンド

```bash
# マイグレーション関連
docker-compose exec app php artisan migrate             # 実行
docker-compose exec app php artisan migrate:rollback    # 取り消し
docker-compose exec app php artisan migrate:refresh     # リセット

# 生成関連
docker-compose exec app php artisan make:model User -m  # モデル + マイグレーション
docker-compose exec app php artisan make:controller UserController --resource  # リソースコントローラー
docker-compose exec app php artisan make:request StorePostRequest  # Form Request

# キャッシュ/ルート
docker-compose exec app php artisan cache:clear         # キャッシュクリア
docker-compose exec app php artisan route:list          # ルート一覧表示
docker-compose exec app php artisan tinker             # 対話型シェル

# データベース
docker-compose exec app php artisan db:seed             # Seeder実行
docker-compose exec app php artisan db:wipe             # 全テーブル削除
```

---

## 学習チェックリスト

- [ ] ブログシステムを最後まで構築できた
- [ ] POSTリクエストで新規作成ができた
- [ ] バリデーションエラーが表示されている
- [ ] PUTリクエストで編集ができた
- [ ] DELETEリクエストで削除ができた
- [ ] phpMyAdminでデータベースが確認できた
- [ ] Tinkerでデータを操作できた
- [ ] Laravelのファイル構成を理解した
- [ ] ルーティング → コントローラー → モデル → ビューの流れが理解できた
- [ ] マイグレーションの概念が理解できた

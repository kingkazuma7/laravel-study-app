# ブログシステム構築ハンズオン（駆け出し向け）

## 何をするのか？

Laravelを使ってブログシステムを一から構築します。  
ユーザーが記事を作成・読む・編集・削除できるシステムです。

---

## 基本概念（なぜこれをやるのか）

### Model（モデル）
**役割**: データベースとPHPコードを繋ぐ仲介役

- `Post.php` が「記事」を表すモデル
- データベースの `posts` テーブルと対応
- `Post::all()` でDB内の全記事を取得できる

### Migration（マイグレーション）
**役割**: データベースの構造（テーブル）を定義・管理する

- `create_posts_table.php` は「postsテーブルをこの構造で作る」という指示
- タイトル・本文・著者など、記事に必要なカラムを定義
- バージョン管理できる（変更履歴が追跡可能）

### Controller（コントローラー）
**役割**: ブラウザからのリクエストを処理する

- `/posts` にアクセス → `PostController@index` が実行
- DBから記事を取得 → ページに表示する流れを制御
- ビジネスロジックはここに書く

### Route（ルート）
**役割**: URLとコントローラーを紐付ける

- `/posts` → PostController の index メソッド
- `/posts/create` → create メソッド
- 「どのURLがどの処理を実行するか」を定義

### View（ビュー）
**役割**: ユーザーに見せるHTML画面

- `posts/index.blade.php` → 記事一覧ページ
- `posts/show.blade.php` → 記事詳細ページ
- `posts/create.blade.php` → 新規作成フォーム
- PHPと混ぜて動的なHTMLを生成

---

## 実装手順（ステップバイステップ）

### Step 1: ファイル自動生成

```bash
docker-compose exec app bash
php artisan make:model Post -m -c --resource
```

**何が起こるか**
- `app/Models/Post.php` → Modelファイル（自動生成）
- `database/migrations/XXXX_create_posts_table.php` → Migrationファイル
- `app/Http/Controllers/PostController.php` → Controllerファイル
- `--resource` フラグで、CRUD全てのメソッド雛形が自動生成

**なぜこうする？**  
手動で作ると時間がかかるので、Laravelが雛形を自動生成してくれる仕組み

---

### Step 2: Migrationファイルを編集

`database/migrations/XXXX_create_posts_table.php` を以下のように編集：

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();                           // ID: 自動採番（1, 2, 3...）
        $table->string('title');                // タイトル: 最大255文字
        $table->text('body');                   // 本文: 長い文章用
        $table->string('author')->default('Anonymous');  // 著者: デフォルト値あり
        $table->integer('views')->default(0);   // 閲覧数: 最初は0
        $table->timestamps();                   // created_at, updated_at: 自動管理
    });
}
```

**各カラムの説明**
| カラム | 型 | 用途 | 例 |
|--------|-----|------|-----|
| id | BIGINT | 記事の一意識別子 | 1, 2, 3... |
| title | STRING | 記事のタイトル | "Laravel入門" |
| body | TEXT | 記事の本文（長い） | "Laravelは..." |
| author | STRING | 著者名 | "Taro Yamada" |
| views | INT | 何回読まれたか | 100, 250... |
| created_at | TIMESTAMP | 作成日時（自動） | 2026-08-20 10:30:45 |
| updated_at | TIMESTAMP | 更新日時（自動） | 2026-08-20 15:20:30 |

**なぜこうする？**  
「記事」に必要なデータを定義している  
→ DBがどの形でデータを保存するか決める

---

### Step 3: Migrationを実行

```bash
php artisan migrate
```

**何が起こるか**
- `posts` テーブルがMySQL内に実際に作成される
- 後から `php artisan migrate` を実行すると「どの変更が未適用か」判定して自動適用

**なぜこうする？**  
Migrationファイルは「指示書」に過ぎない  
→ `migrate` コマンドで実際にDBに反映させる

---

### Step 4: Controllerを実装

`app/Http/Controllers/PostController.php` を編集：

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 全記事を一覧表示
    public function index()
    {
        $posts = Post::all();  // DBから全記事を取得
        return view('posts.index', ['posts' => $posts]);  // ビューに渡す
    }

    // 記事詳細を表示＆閲覧数をカウント
    public function show(Post $post)
    {
        $post->increment('views');  // 閲覧数を1増やす
        return view('posts.show', ['post' => $post]);
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('posts.create');
    }

    // フォーム送信時のデータ保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        Post::create($validated);  // DBに保存
        return redirect('/posts')->with('message', '記事を作成しました！');
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

        $post->update($validated);  // DBを更新
        return redirect('/posts')->with('message', '記事を更新しました！');
    }

    // 削除処理
    public function destroy(Post $post)
    {
        $post->delete();  // DBから削除
        return redirect('/posts')->with('message', '記事を削除しました！');
    }
}
```

**メソッド別説明**
- `index()` → 一覧ページ表示
- `show()` → 詳細ページ表示（閲覧数カウント）
- `create()` → 作成フォーム表示
- `store()` → フォーム送信時のDB保存
- `edit()` → 編集フォーム表示
- `update()` → 更新処理
- `destroy()` → 削除処理

**`$post->increment('views')`とは？**  
```
現在: views = 100
increment() 実行
結果: views = 101
```

**なぜこうする？**  
ユーザーリクエストを処理する中核ロジック  
→ これがないと、Laravelは何をするか分からない

---

### Step 5: ルートを設定

`routes/web.php` に以下を追加：

```php
use App\Http\Controllers\PostController;

Route::resource('posts', PostController::class);
```

**`Route::resource` が自動生成するルート一覧**
| HTTP | URL | メソッド | 役割 |
|------|-----|---------|------|
| GET | /posts | index | 一覧表示 |
| GET | /posts/create | create | 作成フォーム表示 |
| POST | /posts | store | データ保存 |
| GET | /posts/{id} | show | 詳細表示 |
| GET | /posts/{id}/edit | edit | 編集フォーム表示 |
| PUT/PATCH | /posts/{id} | update | データ更新 |
| DELETE | /posts/{id} | destroy | データ削除 |

**なぜ `resource` を使う？**  
7つのルートを手動で書く代わり、1行で自動生成  
→ コード量が減る & 慣例に従える

---

### Step 6: Viewテンプレートを作成

`resources/views/posts/` ディレクトリ内に以下を作成：

#### index.blade.php（一覧ページ）
```blade
<h1>ブログ記事一覧</h1>
<a href="/posts/create">新規作成</a>

<ul>
@foreach($posts as $post)
    <li>
        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
        （著者: {{ $post->author }}, 閲覧数: {{ $post->views }}）
    </li>
@endforeach
</ul>
```

**`@foreach` とは？**  
PHPの `foreach` をBladeの文法で書いたもの  
→ 全記事をループして表示

#### show.blade.php（詳細ページ）
```blade
<h1>{{ $post->title }}</h1>
<p>著者: {{ $post->author }}</p>
<p>閲覧数: {{ $post->views }}</p>
<div>{!! $post->body !!}</div>

<a href="/posts/{{ $post->id }}/edit">編集</a>
<a href="/posts/{{ $post->id }}" onclick="return confirm('削除しますか？')">削除</a>
<a href="/posts">戻る</a>
```

#### create.blade.php（新規作成フォーム）
```blade
<h1>新規記事作成</h1>

<form action="/posts" method="POST">
    @csrf
    
    <label>タイトル</label>
    <input type="text" name="title" required>
    
    <label>本文</label>
    <textarea name="body" required></textarea>
    
    <label>著者</label>
    <input type="text" name="author" required>
    
    <button type="submit">作成</button>
</form>
```

**`@csrf` とは？**  
セキュリティトークン（悪意のあるリクエスト防止）  
→ 必ず含める

#### edit.blade.php（編集フォーム）
```blade
<h1>記事編集</h1>

<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>タイトル</label>
    <input type="text" name="title" value="{{ $post->title }}" required>
    
    <label>本文</label>
    <textarea name="body" required>{{ $post->body }}</textarea>
    
    <label>著者</label>
    <input type="text" name="author" value="{{ $post->author }}" required>
    
    <button type="submit">更新</button>
</form>
```

**`@method('PUT')` とは？**  
HTMLフォームはPOST/GETしか使えない  
→ この記述でLaravelに「PUT請求」を伝える

**なぜこうする？**  
Controllerが処理するなら、ユーザーに見せるUIを作る必要がある

---

## 全体の流れ（初心者向け図解）

```
1. ユーザーが「/posts」にアクセス
   ↓
2. ルート（routes/web.php）が「PostController@index」にルーティング
   ↓
3. index() メソッドが実行
   ├─ Post::all() でDB内の全記事を取得
   └─ view('posts.index') でHTMLを生成・返す
   ↓
4. ブラウザに記事一覧ページが表示される
```

```
別シナリオ: 記事を作成する場合
1. ユーザーが「新規作成」ボタンをクリック → /posts/create
   ↓
2. PostController@create が実行 → フォームを表示
   ↓
3. ユーザーがフォーム送信 → POST /posts
   ↓
4. PostController@store が実行 → $request->validate() でデータ検証
   ↓
5. Post::create() でDB保存
   ↓
6. /posts へリダイレクト（成功メッセージ付き）
```

---

## 実行コマンド一覧

```bash
# コンテナに入る
docker-compose exec app bash

# Modelなど自動生成
php artisan make:model Post -m -c --resource

# テーブル作成
php artisan migrate

# ローカルサーバー起動（オプション）
php artisan serve

# DBを確認（TablePlusなど外部ツールで http://localhost:3306 接続）
```

---

## 確認チェックリスト

- [ ] コンテナ内で `php artisan make:model Post -m -c --resource` 実行
- [ ] Migration ファイルを編集（カラム定義）
- [ ] `php artisan migrate` でテーブル作成
- [ ] PostController を実装（7つのメソッド）
- [ ] routes/web.php でルート定義
- [ ] View テンプレートを作成（4ファイル）
- [ ] `http://localhost:8000/posts` にアクセス
- [ ] 記事作成→表示→編集→削除が全て動作することを確認
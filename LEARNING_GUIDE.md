# Laravel学習ガイド（Docker環境）

## 0. 環境構築手順

### 1. Laravelプロジェクト初期化

```bash
# 1. コンテナをビルド
docker-compose build

# 2. Laravelをインストール（初回のみ）
docker-compose run --rm app composer create-project laravel/laravel .

# 3. コンテナを起動
docker-compose up -d

# 4. 動作確認
# ブラウザで http://localhost:8000 にアクセス
```

### 2. 環境ファイルの設定

```bash
# .envファイルをコピー
cp .env.example .env

# アプリケーションキーを生成
docker-compose exec app php artisan key:generate
```

### 3. データベース初期化

```bash
# マイグレーション実行
docker-compose exec app php artisan migrate
```

---

## 1. Laravel基礎概念

### MVC構成
- **Model**: データベースとやり取り
- **View**: ユーザーに表示する画面（Blade）
- **Controller**: リクエスト処理とModel/Viewの仲介

### 主要ディレクトリ
```
app/
  ├── Http/Controllers/    # コントローラー
  ├── Models/              # モデル
routes/
  └── web.php              # ルート定義
resources/
  └── views/               # ビュー（Blade）
database/
  ├── migrations/          # マイグレーション
  └── seeders/             # シード（初期データ）
```

---

## 2. ルーティング（routes/web.php）

### 基本的なルート定義

```php
// 単純なレスポンス
Route::get('/', function () {
    return view('welcome');
});

// コントローラーメソッドへのルーティング
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// リソースルート（CRUD全て）
Route::resource('posts', PostController::class);
```

---

## 3. コントローラー作成

```bash
# コントローラー作成
docker-compose exec app php artisan make:controller PostController --resource

# モデル付きで作成
docker-compose exec app php artisan make:controller PostController --model=Post --resource
```

### コントローラー例（app/Http/Controllers/PostController.php）

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 一覧表示
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    // 詳細表示
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    // 作成フォーム表示
    public function create()
    {
        return view('posts.create');
    }

    // データ保存
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect('/posts');
    }

    // 編集フォーム表示
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    // データ更新
    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect('/posts');
    }

    // データ削除
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts');
    }
}
```

---

## 4. モデル作成

```bash
# モデル作成
docker-compose exec app php artisan make:model Post

# マイグレーション付きで作成
docker-compose exec app php artisan make:model Post -m
```

### モデル例（app/Models/Post.php）

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];
    
    // タイムスタンプ自動管理（created_at, updated_at）
    public $timestamps = true;
}
```

---

## 5. マイグレーション（テーブル定義）

```bash
# マイグレーション作成
docker-compose exec app php artisan make:migration create_posts_table
```

### マイグレーション例（database/migrations/xxxx_xx_xx_create_posts_table.php）

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                    // id(自動インクリメント)
            $table->string('title');         // 文字列
            $table->text('body');            // テキスト
            $table->timestamps();            // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
```

### マイグレーション実行

```bash
# 実行
docker-compose exec app php artisan migrate

# ロールバック（最後のマイグレーション取り消し）
docker-compose exec app php artisan migrate:rollback

# リセット（全テーブル削除して再作成）
docker-compose exec app php artisan migrate:refresh
```

---

## 6. ビュー（Blade）

### ビューファイル作成（resources/views/posts/index.blade.php）

```blade
<h1>ブログ一覧</h1>

<a href="/posts/create">新規作成</a>

<table>
    <tr>
        <th>ID</th>
        <th>タイトル</th>
        <th>操作</th>
    </tr>
    @foreach($posts as $post)
    <tr>
        <td>{{ $post->id }}</td>
        <td><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></td>
        <td>
            <a href="/posts/{{ $post->id }}/edit">編集</a>
            <form action="/posts/{{ $post->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
```

### Bladeの基本構文

```blade
{{-- コメント --}}

{{ $variable }}           {{-- 変数表示 --}}
{!! $html !!}             {{-- HTMLエスケープなし --}}

@if($condition)
    ...
@elseif($another)
    ...
@else
    ...
@endif

@foreach($items as $item)
    {{ $item->name }}
@endforeach

@for($i = 0; $i < 10; $i++)
    {{ $i }}
@endfor

@while($condition)
    ...
@endwhile
```

---

## 7. 実践的なハンズオン

### Step 1: Postモデル・マイグレーション・コントローラー作成

```bash
docker-compose exec app php artisan make:model Post -m -c --resource
```

### Step 2: マイグレーション編集して実行

### Step 3: ルート設定（routes/web.php）

```php
Route::resource('posts', PostController::class);
```

### Step 4: コントローラー実装

### Step 5: ビュー作成（resources/views/posts/）

### Step 6: ブラウザでテスト

```
http://localhost:8000/posts         # 一覧
http://localhost:8000/posts/create  # 作成フォーム
```

---

## 8. よく使うコマンド

```bash
# サーバー起動（バックグラウンド）
docker-compose up -d

# サーバー停止
docker-compose down

# コンテナ内でコマンド実行
docker-compose exec app php artisan {command}

# ログ確認
docker-compose logs -f app

# データベース操作（phpMyAdmin）
# ブラウザで http://localhost:8080 にアクセス
# ユーザー: root
# パスワード: password
```

---

## 9. 次のステップ

- [ ] バリデーション（Request Validation）
- [ ] リレーションシップ（Eloquent Relations）
- [ ] シード（Database Seeding）
- [ ] テスト（PHPUnit, Feature Tests）
- [ ] キャッシング
- [ ] キュー（Job Queue）

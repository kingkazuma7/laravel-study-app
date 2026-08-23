<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $posts = auth()->user()->posts;
    return view('dashboard', ['posts' => $posts]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/demo/orm', function () {
    // Eloquent ORM
    $posts_orm = App\Models\Post::where('created_at', '>=', now()->startOfYear())
        ->with('user')
        ->get();

    return view('demo.orm', ['posts' => $posts_orm]);
});

Route::get('/demo/querybuilder', function() {
    // DB Query Builder
    $posts_qb = DB::table('posts')
        ->where('posts.created_at', '>=', now()->startOfYear())
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->select('posts.id', 'posts.title', 'posts.created_at', 'users.name as author')
        ->get();

    return view('demo.querybuilder', ['posts' => $posts_qb]);
});

require __DIR__.'/auth.php';

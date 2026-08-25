<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\BookController;
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
Route::get('/person', [PersonController::class, 'index'])->name('person.index');
Route::get('/person/{person}', [PersonController::class, 'show'])->name('person.show');
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

Route::get('/book', [BookController::class, 'index'])->name('book.index');
Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
Route::post('/book', [BookController::class, 'store'])->name('book.store');
Route::get('/book/{id}/edit', [BookController::class, 'edit'])->name('book.edit');
Route::put('/book/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('/book/{id}', [BookController::class, 'destroy'])->name('book.destroy');

require __DIR__.'/auth.php';

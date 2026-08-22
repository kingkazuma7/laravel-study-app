<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        \App\Models\Post::create([
            'user_id' => $user->id,
            'title' => '初めてのブログ記事',
            'body' => 'これは Laravel での最初のブログ記事です。',
        ]);

        \App\Models\Post::create([
            'user_id' => $user->id,
            'title' => 'Laravel の認証機能について',
            'body' => 'Laravel には認証・認可機能が組み込まれています。Breeze、Sanctum、Passport などのツールが利用できます。',
        ]);

        \App\Models\Post::create([
            'user_id' => $user->id,
            'title' => 'データベースマイグレーション',
            'body' => 'マイグレーションを使用するとバージョン管理された方法でデータベーススキーマを管理できます。',
        ]);
    }
}

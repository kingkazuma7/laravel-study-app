<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ようこそ</title>
    </head>
    <body style="font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background: #f9fafb;">
        <div style="text-align: center; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 2rem 0; color: #1f2937;">Laravel 学習用リポジトリ</h1>

            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.25rem; color: #6b7280; margin: 0 0 1.5rem 0;">ブログシステム</h2>
                <p>
                    <a href="/posts" style="display: inline-block; padding: 0.75rem 1.5rem; margin: 0.5rem; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.2s;">
                        📝 ブログを見る
                    </a>
                </p>
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 2rem 0;">

            <div>
                <h2 style="font-size: 1.25rem; color: #6b7280; margin: 0 0 1.5rem 0;">データベースアクセス方法の比較</h2>
                <p style="color: #6b7280; margin: 0 0 1rem 0; font-size: 0.95rem;">
                    同じデータを異なる方法で取得するデモ。ORM と Query Builder の違いを体験できます。
                </p>
                <p>
                    <a href="/demo/orm" style="display: inline-block; padding: 0.75rem 1.5rem; margin: 0.5rem; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.2s;">
                        📦 Eloquent ORM デモ
                    </a>
                    <a href="/demo/querybuilder" style="display: inline-block; padding: 0.75rem 1.5rem; margin: 0.5rem; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.2s;">
                        📋 Query Builder デモ
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>

#!/bin/bash

echo "=== Laravel Docker環境セットアップ ==="

echo "1. Dockerコンテナをビルド中..."
docker-compose build

echo "2. Laravelプロジェクトを初期化中..."
docker-compose run --rm app composer create-project laravel/laravel . --no-interaction --prefer-dist

echo "3. 環境ファイルをコピー中..."
cp .env.example .env

echo "4. コンテナを起動中..."
docker-compose up -d

echo "5. アプリケーションキーを生成中..."
docker-compose exec app php artisan key:generate

echo "6. データベースをセットアップ中..."
docker-compose exec app php artisan migrate

echo "✅ セットアップ完了！"
echo ""
echo "アクセスURL:"
echo "  - アプリケーション: http://localhost:8000"
echo "  - phpMyAdmin: http://localhost:8080"
echo ""
echo "次のステップ:"
echo "  1. LEARNING_GUIDE.md を読む"
echo "  2. docker-compose exec app php artisan を使ってコマンド実行"
echo "  3. routes/web.php でルート定義"
echo "  4. app/Http/Controllers でコントローラー作成"

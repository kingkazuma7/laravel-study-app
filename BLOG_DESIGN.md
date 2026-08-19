# ブログシステム設計（ミニマム）

## 要件
- 記事一覧表示
- 記事詳細表示（閲覧数カウント）
- 記事作成
- 記事編集
- 記事削除

## DB スキーマ

### posts テーブル
| カラム | 型 | 説明 |
|--------|-----|------|
| id | BIGINT | PK |
| title | STRING | 記事タイトル |
| body | TEXT | 本文 |
| author | STRING | 著者（デフォルト: Anonymous） |
| views | INT | 閲覧数 |
| created_at | TIMESTAMP | 作成日時 |
| updated_at | TIMESTAMP | 更新日時 |

## API ルート

| メソッド | ルート | 説明 |
|---------|--------|------|
| GET | /posts | 一覧 |
| GET | /posts/{id} | 詳細 |
| GET | /posts/create | 作成フォーム |
| POST | /posts | 保存 |
| GET | /posts/{id}/edit | 編集フォーム |
| PUT | /posts/{id} | 更新 |
| DELETE | /posts/{id} | 削除 |

## 実装順序
1. Model / Migration 生成
2. Migration 編集 & 実行
3. Controller 実装
4. Routes 設定
5. View 作成（簡潔なBladeテンプレート）

## 成功条件
- 記事作成→表示→編集→削除が全て動作
- 閲覧数が正しくカウント
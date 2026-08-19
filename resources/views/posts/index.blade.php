<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laravel posts</title>
</head>
<body>
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
</body>
</html>
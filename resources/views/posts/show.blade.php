<h1>{{ $post->title }}</h1>
<p>著者: {{ $post->author }}</p>
<p>閲覧数: {{ $post->views }}</p>
<div>{!! $post->body !!}</div>

<a href="/posts/{{ $post->id }}/edit">編集</a>
<form action="/posts/{{ $post->id }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
</form>
<a href="/posts">戻る</a>
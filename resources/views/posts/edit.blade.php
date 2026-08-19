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

<h1>新規記事作成</h1>

<form action="/posts" method="POST">
    @csrf

    <label>タイトル</label>
    <input type="text" name="title" required>

    <label>本文</label>
    <textarea name="body" required></textarea>

    <label>著者</label>
    <input type="text" name="author" required>

    <button type="submit">作成</button>
</form>

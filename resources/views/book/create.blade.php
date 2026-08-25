<head>
  <title>Laravel Sample</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<div class="container ops-main">
  <div class="row">
    <div class="col-md-8 col-md-offset-1">
      <h3 class="ops-title">書籍新規作成</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-1">
      <form action="/book" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label for="name">書籍名</label>
          <input type="text" class="form-control" name="name" value="">
        </div>
        <div class="form-group">
          <label for="price">価格</label>
          <input type="text" class="form-control" name="price" value="">
        </div>
        <div class="form-group">
          <label for="author">著者</label>
          <input type="text" class="form-control" name="author" value="">
        </div>
        <button type="submit" class="btn btn-default">作成</button>
        <a href="/book">戻る</a>
      </form>
    </div>
  </div>
</div>

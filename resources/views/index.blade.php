<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movies</title>
  <style>
    .movies__container {
      border: #000 solid 0.5px;
      margin: 4px;
      padding: 4px;
    }
  </style>
</head>
<body>
  <h1>映画一覧ページ</h1>

  <form action="{{route('movies.index')}}">
    <input type="text" name="keyword" placeholder="タイトルや概要で検索" value="{{$request->keyword?? ''}}" />
    <label>
      <input type="radio" name="is_showing" value="" {{is_null($request->is_showing) ? 'checked' : ''}} />すべて
    </lavel>
    <label>
      <input type="radio" name="is_showing" value="0" {{$request->is_showing === '0' ? 'checked' : ''}} />公開予定
    </label>
    <label>
      <input type="radio" name="is_showing" value="1" {{$request->is_showing === '1' ? 'checked' : ''}} />公開中
    </label>
    <button type="submit">検索</button>
  </form>
  <div style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
    @foreach ($movies as $movie)
      <div class="movies__container">
        <p>{{$movie->title}}</p>
        <img src={{$movie->image_url}} style="width: 250px">
        <p>{{$movie->description}}</p>
        <p>{{$movie->is_showing ? '公開中' : '公開予定'}}</p>
      </div>
    @endforeach
  </div>
  <div>
    {{$movies->appends(request()->query())->links()}}
  </div>
</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movies</title>
</head>
<body>
  <h1>映画一覧ページ</h1>
  <div style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
    @foreach ($movies as $movie)
      <div>
        <p>{{$movie->title}}</p>
        <img src={{$movie->image_url}} style="width: 250px">
      </div>
    @endforeach
  </div>
</body>
</html>
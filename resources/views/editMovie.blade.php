<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>映画情報編集画面</title>
</head>
<body>
  <h1>映画情報編集画面</h1>
  <form action="{{route('admin.movies.update', ['id' => $movie->id])}}" method="POST">
    @csrf
    @method('PATCH')
    <p>ID: {{$movie->id}}</p>
    <label for="title">映画タイトル:</label>
    <input type="text" name="title" value="{{ old('title', $movie->title) }}" required><br>

    <label for="image_url">画像URL:</label>
    <input type="text" name="image_url" value="{{ old('image_url', $movie->image_url) }}" required><br>

    <label for="published_year">公開年:</label>
    <input type="number" name="published_year" value="{{ old('published_year', $movie->published_year) }}" required><br>

    <label for="is_showing">上映中かどうか:</label>
    <select name="is_showing">
      <option value="1" {{ $movie->is_showing ? 'selected' : '' }}>上映中</option>
      <option value="0" {{ !$movie->is_showing ? 'selected' : '' }}>上映予定</option>
    </select><br>

    <label for="description">概要:</label>
    <textarea name="description" required>{{ old('description', $movie->description) }}</textarea><br>

    <button type="submit">更新</button>
  </form>
</body>
</html>
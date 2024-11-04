<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>映画新規登録画面</title>
</head>
<body>
  <h1>映画新規登録画面</h1>
  @if (session('error'))
    <p style="color:red">{{session('error')}}</p>
  @endif

  <form action="{{route('admin.movies.store')}}" method="POST">
    @csrf

    <label for="title">映画タイトル:</label>
    <input type="text" name="title" value="{{ old('title') }}" required>
    @error('title')<p style="color:red;">{{ $message }}</p>@enderror
    <br>

    <label for="image_url">画像URL:</label>
    <input type="text" name="image_url" value="{{ old('image_url') }}" required>
    @error('image_url')<p style="color:red;">{{ $message }}</p>@enderror
    <br>

    <label for="published_year">公開年:</label>
    <input type="number" name="published_year" value="{{ old('published_year') }}" required>
    @error('published_year')<p style="color:red;">{{ $message }}</p>@enderror
    <br>

    <label for="is_showing">上映中かどうか:</label>
    <input type="checkbox" name="is_showing" {{ old('is_showing') ? 'checked' : '' }}>
    <br>

    <label for="description">概要:</label>
    <textarea name="description" required>{{ old('description') }}</textarea>
    @error('description')<p style="color:red;">{{ $message }}</p>@enderror
    <br>

    <button type="submit">登録</button>
  </form>

  <a href="/admin/movies">管理ページへ戻る</a>
</body>
</html>
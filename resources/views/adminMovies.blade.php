<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Page</title>
</head>
<body>
  <h1>映画リスト管理画面</h1>
  <a href={{route('admin.movies.create')}}>新規投稿</a>
  <table border="1">
    <thread>
      <tr><th>ID</th><th>映画タイトル</th><th>画像URL</th><th>公開年</th><th>上映中かどうか</th><th>概要</th><th>登録日時</th><th>更新日時</th></tr>
    </thread>
    <tbody>
      @foreach ($movies as $movie)
      <tr>
        <td>{{$movie->id}}</td>
        <td>{{$movie->title}}</td>
        <td>{{$movie->image_url}}</td>
        <td>{{$movie->published_year}}</td>
        @if ($movie->is_showing)
          <td>上映中</td>
        @else
          <td>上映予定</td>
        @endif
        <td>{{$movie->description}}</td>
        <td>{{$movie->created_at}}</td>
        <td>{{$movie->updated_at}}</td>
        <td><a href="{{route('admin.movies.edit', ['id' => $movie->id])}}">編集</a></td>
        <td>
          <form id="delete-form-{{$movie->id}}" action="{{route('admin.movies.destroy', ['id' => $movie->id])}}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete({{$movie->id}})">削除</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <a href="/movies">一覧ページへ戻る</a>
  <script>
    const confirmDelete = (id) => {
      if (confirm("この映画を削除しますか？")) {
        const elem = document.getElementById(`delete-form-${id}`);
        elem.submit();
      }
    }
  </script>
</body>
</html>
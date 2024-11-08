<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Practice;
use App\Models\Movie;

class PracticeController extends Controller
{
    public function sample() {
      return view('practice');
    }

    public function sample2() {
      $test = 'practice2';
      return view('practice2', ['testParam' => $test]);
    }

    public function sample3() {
      $test = "test";
      return view("practice3", ["testParam" => $test]);
    }

    public function getPractice() {
      $practices = Practice::all();
      return view('getPractice', ['practices' => $practices]);
    }

    public function index(Request $request) {
      $query = Movie::query();

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // 公開状態のフィルタリング
        if ($request->filled('is_showing')) {
            $isShowing = $request->input('is_showing');
            $query->where('is_showing', $isShowing);
        }

      // 20件ごとのページネーション
      $movies = $query->paginate(20);
      return view('index', ['movies' => $movies, 'request' => $request]);
    }

    public function admin() {
      $movies = Movie::orderBy('updated_at', 'desc')->get();
      return view('adminMovies', ['movies' => $movies]);
    }

    public function createMovie() {
      return view('createMovie');
    }

    public function storeMovie(Request $request) {
      // バリデーションルールの定義
      $validated = $request->validate([
        'title' => 'required|unique:movies,title',
        'image_url' => 'required|url',
        'published_year' => 'required|integer',
        'is_showing' => 'boolean',
        'description' => 'required',
      ], [
        'title.required' => 'タイトルは必須です',
        'image_url.required' => 'イメージURLは必須です',
        'image_url.url' => 'イメージURLはURL形式で入力してください',
        'published_year.required' => '公開年は入力必須です',
        'published_year.integer' => '公開年は数値で入力してください',
        'description.required' => '内容は入力必須です',
      ]);

      try {
        // 新しい映画レコードを作成
        Movie::create([
          'title' => $validated['title'],
          'image_url' => $validated['image_url'],
          'published_year' => $validated['published_year'],
          'is_showing' => $request->has('is_showing') ? 1 : 0, # チェックボックスのon/off
          'description' => $validated['description'],
        ]);
        return redirect()->route('admin.movies')->with('success', '映画が正常に登録されました。');
      } catch (\Exception $e) {
        return back()->withInput()->with('error', '登録中にエラーが発生しました。再度お試しください。');
      }
    }

    public function editMovie($id) {
      $movie = Movie::findOrFail($id);
      return view('editMovie', ['movie' => $movie]);
    }

    public function updateMovie(Request $request, $id) {
      $validated = $request->validate([
        'title' => 'required|unique:movies,title,' . $id,
        'image_url' => 'required|url',
        'published_year' => 'required|integer',
        'is_showing' => 'required|boolean',
        'description' => 'required',
      ]);
      $movie = Movie::findOrFail($id);
      $movie->update($validated);
      return redirect('/admin/movies')->with('success', '映画情報が更新されました');
    }

    public function destroyMovie($id) {
      try {
        // 指定されたIDの映画レコードを削除
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies')->with('success', '映画が正常に削除されました。');
      } catch (\Exception $e) {
        return redirect()->route('admin.movies')->with('error', '削除中にエラーが発生しました。');
      }
    }
}
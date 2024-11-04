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

    public function index() {
      $movies = Movie::all();
      return view('index', ['movies' => $movies]);
    }

    public function admin() {
      $movies = Movie::all();
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
        'is_showing' => 'required|nullable',
        'description' => 'required',
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

    public function editMovie($id = 1) {
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
}
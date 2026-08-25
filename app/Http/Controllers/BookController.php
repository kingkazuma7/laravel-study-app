<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
      // DBよりBookテーブルの値を全て取得
      $books = Book::all();

      // 取得した値をビュー「book/index」に渡す
      return view('book/index', compact('books'));
    }

    public function edit($id) {
      // DBよりURIパラメータと同じIDを持つBookの情報を取得
      $book = Book::findOrFail($id);

      // 取得した値をビュー「book/edit」に渡す
      return view('book/edit', compact('book'));
    }

    public function create() {
      // 新規作成フォームを表示
      return view('book/create');
    }

    public function store(Request $request) {
      // フォームからの入力値をBookテーブルに保存
      Book::create([
        'name' => $request->name,
        'price' => $request->price,
        'author' => $request->author,
      ]);

      // 一覧ページにリダイレクト
      return redirect('/book');
    }

    public function update(Request $request, $id) {
      // URIパラメータと同じIDを持つBookの情報を更新
      $book = Book::findOrFail($id);
      $book->name = $request->name;
      $book->price = $request->price;
      $book->author = $request->author;
      $book->save();

      // 一覧ページにリダイレクト
      return redirect('/book');
    }

    public function destroy($id) {
      // URIパラメータと同じIDを持つBookの情報を削除
      $book = Book::findOrFail($id);
      $book->delete();

      // 一覧ページにリダイレクト
      return redirect('/book');
    }
}

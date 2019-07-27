<?php
use Illuminate\Http\Request;

Route::get('/', function () {
  return view('home');
});

Route::get('/manga/categories/{catSlug?}', function (Request $request) {
  return view('categories', ['slug' => isset($request->catSlug) ? $request->catSlug : 'all']);
});

Route::get('/manga/{slug?}', function (Request $request) {
  return view('manga_page', ['slug' => $request->slug]);
});

Route::get('/manga/{slug}/chapter/{chapterNo}', function (Request $request) {
  return view('chapter_page', ['slug' => $request->slug, 'chapterNo' => $request->chapterNo]);
});

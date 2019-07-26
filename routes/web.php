<?php
use Illuminate\Http\Request;

Route::get('/', function () {
  return view('home');
});

Route::get('/manga/categories/{catSlug?}', function (Request $request) {
  return view('categories', ['slug' => isset($request->catSlug) ? $request->catSlug : 'all']);
});

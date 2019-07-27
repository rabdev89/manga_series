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

Route::get('/advanced-search', function(Request $requet) {
  return view('advanced_search');
});

Route::get('/advanced-search/results/{param1?}/{val1?}/{param2?}/{val2?}/{param3?}/{val3?}/{param4?}/{val4?}/{param5?}/{val5?}', function(Request $request) {
  $params = collect([]);
  if(isset($request->param1)) {
    $params->push([$request->param1 => $request->val1]);
  }
  if(isset($request->param2)) {
    $params->push([$request->param2 => $request->val2]);
  }
  if(isset($request->param3)) {
    $params->push([$request->param3 => $request->val3]);
  }
  if(isset($request->param4)) {
    $params->push([$request->param4 => $request->val4]);
  }
  if(isset($request->param5)) {
    $params->push([$request->param5 => $request->val5]);
  }
  return view('categories', 
  ['slug' => 'Search Results', 'params' => $params]);
});
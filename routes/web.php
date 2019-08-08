<?php
use Illuminate\Http\Request;


Route::get('/manga/categories/{catSlug?}', 'CategoriesController@getCategoryBySlug');
Route::get('/manga/{slug?}', 'MangaChapterController@getBySlug');
Route::get('/manga/{slug}/chapter/{chapterNo}', 'MangaChapterController@getAllPages');
Route::get('/manga/{slug}/chapter/{chapterNo}/all-pages', 'MangaChapterController@getAllPages');
Route::get('/advanced-search/results', 'CategoriesController@getResults');



// Route::group(['prefix' => 'api/v1'], function () {
//     Route::get('chapter/{mangaId}', ['as' => 'chapter.id', 'uses' => 'MangaChapterController@getChapter']);
// });

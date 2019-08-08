<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategoryBySlug($catSlug)
    {
        return view('categories', ['slug' => isset($request->catSlug) ? $request->catSlug : 'all']);
    }
}

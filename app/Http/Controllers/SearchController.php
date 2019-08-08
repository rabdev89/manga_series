<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index() {
        return view('advanced_search');
    }

    public function getResults(Request $request)
    {
        $params = collect([]);
        if (isset($request->param1)) {
            $params->push([$request->param1 => $request->val1]);
        }
        if (isset($request->param2)) {
            $params->push([$request->param2 => $request->val2]);
        }
        if (isset($request->param3)) {
            $params->push([$request->param3 => $request->val3]);
        }
        if (isset($request->param4)) {
            $params->push([$request->param4 => $request->val4]);
        }
        if (isset($request->param5)) {
            $params->push([$request->param5 => $request->val5]);
        }
        return view('categories', ['slug' => 'Search Results', 'params' => $params]);
    }
}

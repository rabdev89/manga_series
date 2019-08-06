<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class MangaChapterController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChapter($mangaId)
    {

        $endpoint = "https://www.mangaeden.com/api/chapter/".$mangaId;

        $contents = file_get_contents($endpoint);

        $data = json_decode($contents, true);

        // Write File
        $newJsonString = json_encode($data);

        file_put_contents(public_path('data/'.$mangaId.'.json'), stripslashes($newJsonString));

        $file = \File::get(public_path('data/'.$mangaId.'.json'));

        return $file;
    }
}

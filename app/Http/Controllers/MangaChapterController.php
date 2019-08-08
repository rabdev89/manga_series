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

    public function getLatest()
    {
        $url = 'https://www.mangaeden.com/api/list/0/';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function getBySlug(Request $request, $slug)
    {
       return view('manga_page', ['slug' => $request->slug]);
    }

    public function getAllPages(Request $request)
    {
        return view('chapter_page', ['slug' => $request->slug, 'chapterNo' => $request->chapterNo, 'allPages'=>true]);
    }

}

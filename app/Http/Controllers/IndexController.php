<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    public function show(Request $request)
    {
        $keywords = DB::table('hot_keyword')->get();
        $authors = DB::table('hot_author')->get();
        return view('myhome', compact('keywords', 'authors'));
    }

    public function keyword_authors(Request $request)
    {
        $word = $request['word'];
         
        $client = new Client();
        $res = $client->request('GET', 'localhost:8000/keyword_authors', [
            'query' => [
                'word' => $word,
            ]
        ]);
        $list =  json_decode($res->getBody(), true);
        
        return $list;
    }

    public function author_keywords(Request $request)
    {
        $word = $request['word'];
         
        $client = new Client();
        $res = $client->request('GET', 'http://localhost:8000/author_keywords', [
            'query' => [
                'word' => $word,
            ],
            'timeout' => 300
        ]);
        

        $list =  json_decode($res->getBody(), true);
        
        return $list;
    }

}

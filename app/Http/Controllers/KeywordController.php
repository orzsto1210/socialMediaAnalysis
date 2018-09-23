<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class KeyWordController extends Controller
{
    public function index()
    {
        // return view('search');
    }
    


  public function search(Request $request) 
  {
        $word = $request->input('search');
        if( $word == "" ){
            $word = 'ai';
        }

	    $client = new Client();
        $res = $client->request('GET', 'http://localhost:8000/api/keyword', [
            'query' => [
                'word' => $word,
            ]
        ]);
        // echo $res->getStatusCode();
        // "200"
        // echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        // echo $res->getBody();
        // {"type":"User"...'
        // $keywords = $res->getBody();
        $keywords = json_decode($res->getBody(), true);

        return view('search-keyword', compact('keywords'));

    }
}

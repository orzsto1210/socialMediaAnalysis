<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show()
    {
        $keywords = DB::table('hot_keyword')->get();
        $authors = DB::table('pagerank')->get();
        return view('index', compact('keywords', 'authors'));
    }

    public function filter(Request $request)
    {
        $keywords = DB::table('hot_keyword')->get();
        $authors = DB::table('pagerank')->get();
        $twitter_keywords = DB::table('hot_keyword')->where('group', 'twitter')->get();
        // sort
        // $twitter_keywords = DB::table('hot_keyword')->where('group', 'twitter')->orderBy('time', 'asc')->orderBy('count', 'desc')->get();
        $reddit_keywords = DB::table('hot_keyword')->where('group', 'reddit')->get();
        $timefilter = $request->input('timefilter');

        return view('index', compact('twitter_keywords', 'reddit_keywords', 'keywords', 'authors'));
    }
}

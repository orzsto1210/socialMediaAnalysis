<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedditDataController extends Controller
{
	public function filter(Request $request)
    {
        $keywords = DB::table('hot_keyword')->get();
        $reddit_keywords = DB::table('hot_keyword')->where('group', 'reddit')->get();
        return view('reddit', compact('reddit_keywords', 'keywords'));
    }


	public function search(Request $request)
	{
		$search = $request->input('search');

		if( $search == ""){
			$datas = DB::table('reddit_data')->paginate(5);
			return view('search-reddit', compact('datas'));
		}
		else{
			$datas = DB::table('reddit_data')->where('author', 'like', '%' .$search. '%')->paginate(5);
			return view('search-reddit', compact('datas'));
		}
    }
}

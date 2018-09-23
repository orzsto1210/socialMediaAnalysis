<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TwitterDataController extends Controller
{
	public function filter(Request $request)
    {
		$keywords = DB::table('hot_keyword')->get();
		$twitter_keywords = DB::table('hot_keyword')
										->where('group', 'twitter')
										->get();
		$timefilter = $request->input('timefilter');
		$kwds = collect();
		$timefilter = "a_week" ;

		if ( $timefilter == "a_week" ){
			$from = date('2018-07-01');
			$to = date('2018-07-07');
			$kwds1 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds1 as $kwd1)
				$kwd1->time = $to;
	
			$from = date('2018-07-08');
			$to = date('2018-07-14');
			$kwds2 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds2 as $kwd2)
				$kwd2->time = $to;
	
			$from = date('2018-07-15');
			$to = date('2018-07-21');
			$kwds3 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds3 as $kwd3)
				$kwd3->time = $to;
	
			$from = date('2018-07-22');
			$to = date('2018-07-31');
			$kwds4 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds4 as $kwd4)
				$kwd4->time = $to;
	
			$kwds = $kwds->merge($kwds1);
			$kwds = $kwds->merge($kwds2);
			$kwds = $kwds->merge($kwds3);
			$kwds = $kwds->merge($kwds4);
	
		}
		else if ( $timefilter == "two_weeks" ){
			$from = date('2018-07-01');
			$to = date('2018-07-14');
			$kwds1 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds1 as $kwd1)
				$kwd1->time = $to;
	
			$from = date('2018-07-15');
			$to = date('2018-07-31');
			$kwds2 = DB::table('hot_keyword')
								->where('group', 'twitter')
								->whereBetween('time', [$from, $to])
								->get();
			foreach($kwds2 as $kwd2)
				$kwd2->time = $to;
			
			$kwds = $kwds->merge($kwds1);
			$kwds = $kwds->merge($kwds2);
		}
		else if ( $timefilter == "a_month") {

		}


        return view('twitter', compact('twitter_keywords', 'keywords', 'kwds1', 'kwds2', 'kwds'));
    }

	public function search(Request $request)
	{
		$search = $request->input('search');

		if( $search == ""){
			$datas = DB::table('twitter_data_n')->paginate(5);
			return view('search-twitter', compact('datas'));
		}
		else{
			$datas = DB::table('twitter_data_n')->where('author', 'like', '%' .$search. '%')->paginate(5);
			return view('search-twitter', compact('datas'));
		}
    }
}

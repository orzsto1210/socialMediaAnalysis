<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class KeyWordController extends Controller
{
    public function searchEvent(Request $request)
	{
        $event = $request->input('event');
        $group = $request->input('group');
        $datas = DB::table("reddit_data")->where('title', 'like', '%' .$event. '%')->get();
		return view('data_show', compact('datas', 'event'));
    }

    public function searchAuthor(Request $request)
    {
        $author = $request->input('author');
        $tag = $request->input('tag') ;
        $datas = DB::table($tag . "_data")->where('author', '=', $author)->get();
        return view('data_show', compact('datas', 'author'));
    }

    public function searchFromAPI(Request $request) 
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

    public function detail(Request $request) // show keyword_detail
    {
        $keyword = $request->input('keyword');
        $filter = $request->input('filter');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        
        $month_time = DB::table('senti_keyword')
                        ->where('MWD', '=', 'M')
                        ->select('time')
                        ->groupBy('time')
                        ->get();
        $week_time = DB::table('senti_keyword')
                        ->where('MWD', '=', 'W')
                        ->select('time')
                        ->groupBy('time')
                        ->get();
        $day_time = DB::table('senti_keyword')
                        ->where('MWD', '=', 'D')
                        ->select('time')
                        ->groupBy('time')
                        ->get();
        // 預設值 以月來看
        if ( $filter == '' )
            $filter = 'M';
        if ( $start_time == '' )
            $start_time = $month_time{0}->time;
        if ( $end_time == '' )
            $end_time = $month_time{count($month_time) - 1}->time;

        $senti_twitter_datas = DB::table('senti_keyword')
                                ->where('keyword', '=', $keyword)
                                ->where('tag', '=', 'twitter')
                                ->where('MWD', '=', $filter)
                                ->where('time', '>=', $start_time)
                                ->where('time', '<=', $end_time)
                                ->get();
        $senti_reddit_datas = DB::table('senti_keyword')
                                ->where('keyword', '=', $keyword)
                                ->where('tag', '=', 'reddit')
                                ->where('MWD', '=', $filter)
                                ->where('time', '>=', $start_time)
                                ->where('time', '<=', $end_time)
                                ->get();
        $event_datas = DB::table('event_data')
                        ->where('keyword', '=', $keyword)
                        ->where('MWD', '=', $filter)
                        ->where('time', '>=', $start_time)
                        ->where('time', '<=', $end_time)
                        ->get();

        
        return view('keyword_show', compact('keyword', 'senti_twitter_datas', 'senti_reddit_datas' ,'event_datas',
                    'filter', 'month_time', 'week_time', 'day_time', 'start_time', 'end_time'));
    }

}

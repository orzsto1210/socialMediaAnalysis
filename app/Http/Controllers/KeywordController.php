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
        $keyword = $request['keyword'];
        $filter = $request->input('filter');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        
        $month_time = DB::table('senti_keyword_per')
                        ->where('MWD', '=', 'M')
                        ->select('time')
                        ->groupBy('time')
                        ->get();
        $week_time = DB::table('senti_keyword_per')
                        ->where('MWD', '=', 'W')
                        ->select('time')
                        ->groupBy('time')
                        ->get();
        $day_time = DB::table('senti_keyword_per')
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

        $senti_twitter_datas = DB::table('senti_keyword_per')
                                ->where('keyword', '=', $keyword)
                                ->where('tag', '=', 'twitter')
                                ->where('MWD', '=', $filter)
                                ->where('time', '>=', $start_time)
                                ->where('time', '<=', $end_time)
                                ->get();
        $senti_reddit_datas = DB::table('senti_keyword_per')
                                ->where('keyword', '=', $keyword)
                                ->where('tag', '=', 'reddit')
                                ->where('MWD', '=', $filter)
                                ->where('time', '>=', $start_time)
                                ->where('time', '<=', $end_time)
                                ->get();
        $twitterhight = DB::table('event_data')
                        ->select(DB::raw('max(Discussion) MAXNUM'))
                        ->where('keyword', '=', $keyword)
                        ->where('MWD', '=', $filter)
                        ->where('time', '>=', $start_time)
                        ->where('time', '<=', $end_time)
                        ->where('tag', '=' , 'twitter')
                        ->get();

        $reddithight = DB::table('event_data')
                        ->select(DB::raw('max(Discussion) MAXNUM'))
                        ->where('keyword', '=', $keyword)
                        ->where('MWD', '=', $filter)
                        ->where('time', '>=', $start_time)
                        ->where('time', '<=', $end_time)
                        ->where('tag', '=' , 'reddit')
                        ->get();


        // $event_datas = DB::select('SELECT Discussion / (SELECT MAX(Discussion) MAXNUM  FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'reddit\') Discussion , tag , time , top_event , keyword, MWD FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'reddit\' UNION SELECT Discussion / (SELECT MAX(Discussion) MAXNUM  FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'twitter\') Discussion , tag , time , top_event , keyword, MWD FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'twitter\'', [$keyword,$filter,$start_time,$end_time,$keyword,$filter,$start_time,$end_time,$keyword,$filter,$start_time,$end_time,$keyword,$filter,$start_time,$end_time]) ;

        $reddit_datas = DB::select('SELECT Discussion / (SELECT MAX(Discussion) MAXNUM  FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'reddit\') Discussion , tag , time , top_event , keyword, MWD FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'reddit\'', [$keyword,$filter,$start_time,$end_time,$keyword,$filter,$start_time,$end_time]) ;

        $twitter_datas = DB::select('SELECT Discussion / (SELECT MAX(Discussion) MAXNUM  FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'twitter\') Discussion , tag , time , top_event , keyword, MWD FROM event_data where keyword = ? and MWD = ? and time >= ? and time <= ? and tag = \'twitter\'', [$keyword,$filter,$start_time,$end_time,$keyword,$filter,$start_time,$end_time]) ;

        if ( empty($reddit_datas)){
            $reddit_datas = [] ;
        }
        else {
            if ( $reddit_datas[0]->MWD == 'W' ){
            }
            else {
                $i = 0 ;
                $RScheduleDate = $reddit_datas[$i]->time ;
                $CurrentDate = $start_time ; 
                $starttime = $start_time ;
                $endtime = $end_time ;
                
                while ( strtotime($endtime) >= strtotime( $CurrentDate ) ){

                    if(strtotime($RScheduleDate) !=  strtotime($CurrentDate)) {
                    //do something
                        if ( $reddit_datas[0]->MWD == 'D' ) { //資料是日
                            $adata =(object) [ 'Discussion' => 0 , 'tag' => $reddit_datas[0]->tag, 'time'  => $CurrentDate, 'top_event'  => "NA", 'keyword'  => $keyword, 'MWD'  => $reddit_datas[0]->MWD ] ;    
                        }
                        else if ( $reddit_datas[0]->MWD == 'M' ) {  //資料是月
                            $adata = (object) [ 'Discussion' => 0 , 'tag' => $reddit_datas[0]->tag, 'time'  => substr( $CurrentDate ,  0, 7 )  , 'top_event'  => "NA", 'keyword'  => $keyword, 'MWD'  => $reddit_datas[0]->MWD ] ;      
                        }

                        array_push($reddit_datas, $adata ) ;
                    }
                    else {
                        $i ++ ;
                        if (!empty($reddit_datas[$i]->time))
                            $RScheduleDate = $reddit_datas[$i]->time ;
                    }

                    if ( $twitter_datas[0]->MWD == 'D' ) { //資料是日
                        $CurrentDate = strtotime($CurrentDate); 
                        $CurrentDate = strtotime('+1 day',$CurrentDate) ;
                        $CurrentDate= date('Y-m-d',$CurrentDate);
                    }
                    else if ( $twitter_datas[0]->MWD == 'M' ) {  //資料是月
                        $CurrentDate = strtotime($CurrentDate); 
                        $CurrentDate = strtotime('+1 month',$CurrentDate) ;
                        $CurrentDate= date('Y-m-d',$CurrentDate);
                    }
                }

            }    
        }

        if ( empty($twitter_datas)) {
            $twitter_datas =[] ;
        }
        else {
            if ( $twitter_datas[0]->MWD == 'W' ){
            }
            else {
                $i = 0 ;
                $TScheduleDate = $twitter_datas[$i]->time ;
                $CurrentDate = $start_time ; 
                $starttime = $start_time ;
                $endtime = $end_time ;
                
                while ( strtotime($endtime) >= strtotime( $CurrentDate ) ){
                    if (strtotime($TScheduleDate) !=  strtotime($CurrentDate)) {
                        if ( $twitter_datas[0]->MWD == 'D' ) { //資料是日
                            $adata =(object) [ 'Discussion' => 0 , 'tag' => $twitter_datas[0]->tag, 'time'  => $CurrentDate, 'top_event'  => "NA", 'keyword'  => $keyword, 'MWD'  => $twitter_datas[0]->MWD ] ;    
                        }
                        else if ( $twitter_datas[0]->MWD == 'M' ) {  //資料是月
                            $adata =(object) [ 'Discussion' => 0 , 'tag' => $twitter_datas[0]->tag, 'time'  => substr( $CurrentDate ,  0, 7 )  , 'top_event'  => "NA", 'keyword'  => $keyword, 'MWD'  => $twitter_datas[0]->MWD ] ;      
                        }
                        array_push($twitter_datas, $adata ) ;
                    }
                    else {
                        $i ++ ;
                        if (!empty($twitter_datas[$i]->time))
                            $TScheduleDate = $twitter_datas[$i]->time ;
                    }

                    if ( $twitter_datas[0]->MWD == 'D' ) { //資料是日
                        $CurrentDate = strtotime($CurrentDate); 
                        $CurrentDate = strtotime('+1 day',$CurrentDate) ;
                        $CurrentDate= date('Y-m-d',$CurrentDate);
                    }
                    else if ( $twitter_datas[0]->MWD == 'M' ) {  //資料是月
                        $CurrentDate = strtotime($CurrentDate); 
                        $CurrentDate = strtotime('+1 month',$CurrentDate) ;
                        $CurrentDate= date('Y-m-d',$CurrentDate);
                    }
            
                    
                }

            }   
        }
        usort($reddit_datas, function($a, $b)
        {
            return strcmp($a->time, $b->time);
        });

        usort($twitter_datas, function($a, $b)
        {
            return strcmp($a->time, $b->time);
        });
        $event_datas = array_merge($reddit_datas,$twitter_datas);
        usort($event_datas, function($a, $b)
        {
            return strcmp($a->time, $b->time);
        });

        $client = new Client();
        $res = $client->request('GET', 'http://localhost:8000/google_trend', [
            'query' => [
                'word' => $keyword,
                'start' => $start_time,
                'end' => $end_time,
                'model' => $filter,
            ]
        ]);
        $google_data = (array) json_decode($res->getBody(), true);
        $event_datas = array_merge($google_data,$event_datas);

        $event_datas = json_encode($event_datas) ;

        // $event_datas = DB::table('event_data')
        //                 ->where('keyword', '=', $keyword)
        //                 ->where('MWD', '=', $filter)
        //                 ->where('time', '>=', $start_time)
        //                 ->where('time', '<=', $end_time)
        //                 ->get();

        
        return view('keyword_show', compact('keyword', 'senti_twitter_datas', 'senti_reddit_datas' ,'event_datas',
                    'filter', 'month_time', 'week_time', 'day_time', 'start_time', 'end_time','twitterhight', 'reddithight'));
    }

}

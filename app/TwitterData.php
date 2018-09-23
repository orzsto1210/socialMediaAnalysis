<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TwitterData extends Model
{
	protected $table = 'twitter_datas';
	
	public $incrementing = false;
    protected $primaryKey = 'created_at';
    public $timestamps = false;
    protected $guarded = [];
}

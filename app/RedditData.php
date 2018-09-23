<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RedditData extends Model
{
	public $incrementing = false;
    protected $primaryKey = 'author';
    public $timestamps = false;
}

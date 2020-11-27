<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $fillable = [
        'content', 'user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function answers(){
    	return $this->hasOne('App\Answer');
    }

    public static function getPaginated($num)
    {
    	return static::paginate($num);
    }

}

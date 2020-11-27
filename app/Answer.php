<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
		'content', 'post_id', 'user_id'
	];

    public function posts(){
    	return $this->belongsTo('App\Post');
    }

    public function users(){
    	return $this->belongsTo('App\User');
    }
}

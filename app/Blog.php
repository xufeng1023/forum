<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
	protected $fillable = ['title', 'body'];

    public function getRouteKeyName()
    {
    	return 'title';
    }
}
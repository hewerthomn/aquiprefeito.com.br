<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* Like Model
*/
class Like extends Model
{
	protected $table = 'likes';

	 protected $fillable = ['facebook_id', 'issue_id'];
}

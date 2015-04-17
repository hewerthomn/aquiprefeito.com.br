<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* Comment Model
*/
class Comment extends Model
{
	protected $table = 'comments';

	protected $fillable = ['issue_id', 'facebook_id', 'username', 'comment'];
}

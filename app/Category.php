<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* Category Model
*/
class Category extends Model
{
	protected $table = 'categories';

	public $timestamps = false;
}

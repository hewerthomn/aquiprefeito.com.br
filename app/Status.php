<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* Status Model
*/
class Status extends Model
{
	protected $table = 'status';

	public $timestamps = false;

	public static $OPEN = 1;

	public static $DONE = 2;

	public static $CANCEL = 3;
}

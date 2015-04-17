<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* City Model
*/
class City extends Model
{
	protected $table = 'cities';

	 protected $fillable = ['name'];
}

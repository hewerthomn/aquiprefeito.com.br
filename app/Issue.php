<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Image;
use DB;

/**
* Issue Model
*/
class Issue extends Model
{
	protected $table = 'issues';

	/**
	 * Belongs to City
	 */
	public function city()
	{
		return $this->belongsTo('App\City');
	}

	/**
	 * Belongs to Category
	 */
	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	/**
	 * Belongs to Status
	 */
	public function status()
	{
		return $this->belongsTo('App\Status');
	}

	/**
	 * Has many Like
	 */
	public function likes()
	{
		return $this->hasMany('App\Like');
	}

	/**
	 * Has many Comment
	 */
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	public function getPointAttribute($value)
	{
		$row = DB::table('issues')->whereId($this->attributes['id'])->first([DB::raw('ST_AsText(issues.geom) as point')]);
		return $row ? $row->point : null;
	}

	public function getXAttribute()
	{
		$row = DB::table('issues')->whereId($this->attributes['id'])->first([DB::raw('ST_X(issues.geom) as x')]);
		return $row ? $row->x : null;
	}

	public function getYAttribute()
	{
		$row = DB::table('issues')->whereId($this->attributes['id'])->first([DB::raw('ST_Y(issues.geom) as y')]);
		return $row ? $row->y : null;
	}

	public static function upload($file)
	{
		if(!$file) return false;

		$image = new Image;
		return $image->upload($file, 'issue', true);
	}
}

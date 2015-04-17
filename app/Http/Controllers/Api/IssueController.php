<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIssuePostRequest;
use App\City;
use App\Issue;
use App\Like;
use App\Status;
use DB, Input;

/**
* Issue Controller
*/
class IssueController extends Controller
{
	public function __construct(City $city, Issue $issue, Like $like)
	{
		$this->city = $city;
		$this->issue = $issue;
		$this->like = $like;
	}

	public function index()
	{
		$categories = $this->issue->join('categories', 'issues.category_id', '=', 'categories.id')
															->join('status', 'issues.status_id', '=', 'status.id')
															->join('cities', 'issues.city_id', '=', 'cities.id')
															->select(
																'issues.id',
																'issues.category_id',
																'issues.status_id',
																'issues.city_id',
																'issues.image_path AS photo',
																'issues.username',
																'issues.comment',
																'issues.created_at',
																'categories.name AS category_name',
																'categories.icon AS category_icon',
																'status.name AS status_name',
																'cities.name AS city_name',
																DB::raw('ST_X(issues.geom) AS lon'),
																DB::raw('ST_Y(issues.geom) AS lat')
															)
															->get();

		return response()->json($categories);
	}

	public function show($id)
	{
		$issue = $this->issue->find($id);
		$issue->photo = $issue->image_path;

		$issue->likes = $issue->likes()->count();
		$issue->comments = $issue->comments()->count();
		$issue->status;
		$issue->category;
		$issue->lonlat = [
			'lon' => $issue->x,
			'lat' => $issue->y
		];

		unset($issue->geom);
		unset($issue->image_path);

		return response()->json($issue);
	}

	public function map()
	{
		$city_name = Input::get('city_name');

		$points = $this->issue->join('categories', 'issues.category_id', '=', 'categories.id')
													->join('cities', 'issues.city_id', '=', 'cities.id')
													->where('cities.name', '=', $city_name)
													->select(
														'issues.id',
														'categories.icon AS icon',
														DB::raw('ST_X(issues.geom) AS lon'),
														DB::raw('ST_Y(issues.geom) AS lat')
													)
													->get();

		return response()->json($points);
	}

	public function upload(StoreIssuePostRequest $request)
	{
		try {
			$city = $this->city->firstOrCreate(['name' => Input::get('city')]);

			$issue = new Issue;
			$issue->city_id 		= $city->id;
			$issue->email 			= Input::get('email');
			$issue->comment 		= Input::get('comment');
			$issue->username 		= Input::get('username');
			$issue->status_id 	= Status::$OPEN;
			$issue->facebook_id = Input::get('facebook_id');
			$issue->category_id = Input::get('category_id');

			$lonlat = Input::get('lonlat');
			$issue->geom = DB::raw("ST_GeomFromText('POINT({$lonlat})', 4326)");

			$issue->image_path = $issue->upload(Input::file('file'));

			return $issue->save() ?  'Parabéns! Problema reportado.' : 'Ops, saiu algo errado... x_x';
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function checkLike($id)
	{
		$uuid = Input::get('uuid');
		$count = $this->like->where('uuid', '=', $uuid)
												->where('issue_id', '=', $id)
												->count();

		return ($count > 0) ? 1 : 0;
	}

	public function saveLike($id)
	{
		$uuid = Input::get('uuid');
		$like = new Like;
		$like->uuid = $uuid;
		$like->issue_id = $id;
		$like->save();
	}
}

<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIssuePostRequest;
use App\City;
use App\Issue;
use App\Status;
use DB, Input;

/**
* Issue Controller
*/
class IssueController extends Controller
{
	public function __construct(City $city, Issue $issue)
	{
		$this->city = $city;
		$this->issue = $issue;
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
																'issues.username',
																'issues.comment',
																'issues.likes',
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

		$issue->status;
		$issue->category;
		$issue->lonlat = [
			'lon' => $issue->x,
			'lat' => $issue->y
		];
		$issue->comments = 3;

		unset($issue->geom);
		unset($issue->image_path);

		return response()->json($issue);
	}

	public function store(StoreIssuePostRequest $request)
	{
		try {
			$city = $this->city->firstOrCreate(['name' => Input::get('city')]);

			$issue = new Issue;
			$issue->city_id = $city->id;
			$issue->status_id = Status::$OPEN;
			$issue->category_id = Input::get('category_id');
			$issue->username = Input::get('username');
			$issue->comment = Input::get('comment');

			$lonlat = Input::get('lonlat');
			$issue->geom = DB::raw("ST_GeomFromText('POINT({$lonlat})', 4326)");

			$issue->image_path = $issue->upload(Input::file('file'));

			return $issue->save() ?  'Parabéns! Problema reportado.' : 'Ops, saiu algo errado... x_x';
		} catch (Exception $e) {
			return $e;
		}
	}
}

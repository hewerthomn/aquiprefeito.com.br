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
		$categories = $this->issue->all();

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

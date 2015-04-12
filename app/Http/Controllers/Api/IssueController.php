<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Issue;
/**
* Issue Controller
*/
class IssueController extends Controller
{
	public function __construct(Issue $issue)
	{
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

		$issue->status;
		$issue->category;
		$issue->lonlat = [
			'lon' => $issue->x,
			'lat' => $issue->y
		];

		unset($issue->geom);

		return response()->json($issue);
	}
}

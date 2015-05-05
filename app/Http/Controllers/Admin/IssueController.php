<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\City;
use App\Issue;
use App\Status;

/**
* Admin Issue Controller
*/
class IssueController extends Controller
{
	public function __construct(City $city, Issue $issue)
	{
		$this->city = $city;
		$this->issue = $issue;
	}

	public function getIndex()
	{
		$v['title'] = 'Problemas';

		$issues = $this->issue;

		$v['count'] = $issues->count();
		$v['issues'] = $issues->paginate(6);

		return view('admin.issue.index', $v);
	}
}

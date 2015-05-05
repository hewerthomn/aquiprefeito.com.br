<?php namespace App\Http\Controllers\Mayor;

use App\Http\Controllers\Controller;
use App\City;
use App\Issue;
use App\Status;

/**
* Mayor Issue Controller
*/
class IssueController extends Controller
{
	private $city_id;

	public function __construct(City $city, Issue $issue)
	{
		$this->city_id = 1;

		$this->city = $city;
		$this->issue = $issue;
	}

	public function index()
	{
		$v['title'] = 'Painel de controle';
		$v['city'] = $this->city->find($this->city_id);

		$issues_open = $this->issue->where('city_id', '=', $this->city_id)
															 ->where('status_id', '=', Status::$OPEN)
															 ->get();

		$v['issues_open'] = $issues_open;

		return view('mayor.dashboard', $v);
	}

	public function show($id)
	{
		$v['title'] = 'Informações do problema';
		$v['issue'] = $this->issue->find($id);

		return view('mayor.issue.show', $v);
	}
}

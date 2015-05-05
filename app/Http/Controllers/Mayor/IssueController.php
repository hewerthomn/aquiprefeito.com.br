<?php namespace App\Http\Controllers\Mayor;

use App\Http\Controllers\Controller;
use App\City;
use App\Issue;
use App\Status;
use Auth, Session;

/**
* Mayor Issue Controller
*/
class IssueController extends Controller
{
	private $city_id;

	public function __construct(City $city, Issue $issue)
	{
		$this->city_id = Auth::user()->city_id != null ? Auth::user()->city_id : Session::get('city_id');

		$this->city = $city;
		$this->issue = $issue;
	}

	public function getSelect($city_id = null)
	{
		if(Auth::user()->city_id !=  null)
		{
			return redirect(url('/prefeitura'));
		}

		if($city_id)
		{
			$city = $this->city->find($city_id);
			Session::set('city', $city);
			Session::set('city_id', $city_id);

			return redirect(url('/prefeitura'));
		}

		$v['title'] = 'Selecione uma cidade';
		$v['cities'] = $this->city->get();

		return view('mayor.select', $v);
	}

	public function index()
	{
		$v['title'] = 'Painel de controle';

		if($this->city_id == null)
		{
			return redirect(url('/prefeitura/select'));
		}

		$issues_open = $this->issue->where('city_id', '=', $this->city_id)
															 ->where('status_id', '=', Status::$OPEN);

		$v['issues_open'] = $issues_open->paginate(6);

		return view('mayor.dashboard', $v);
	}

	public function getShow($id)
	{
		$v['title'] = 'Informações do problema';
		$v['issue'] = $this->issue->find($id);

		return view('mayor.issue.show', $v);
	}
}

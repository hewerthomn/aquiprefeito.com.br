<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\City;
use App\Issue;
use App\User;
use Auth, Input;

/**
* Admin Controller
*/
class AdminController extends Controller
{
	private $city_id;

	public function __construct(City $city, Issue $issue, User $user)
	{
		$this->city_id = 1;

		$this->city = $city;
		$this->issue = $issue;
		$this->user = $user;
	}

	public function dashboard()
	{
		$v['title'] = 'Painel de controle';

		return view('admin.dashboard', $v);
	}

	public function profile()
	{
		$v['title'] = 'Perfil';
		$v['user']  = $this->user->find(Auth::user()->id);

		return view('admin.profile', $v);
	}

	public function profileUpdate()
	{
		dd(Input::all());
	}

	public function changePassword()
	{
		dd(Input::all());
	}
}

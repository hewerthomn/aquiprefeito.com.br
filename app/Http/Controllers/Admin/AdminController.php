<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\City;
use App\Issue;
use App\User;
use Auth, Hash, Input, Notification;

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

	public function profileUpdate(UpdateProfileRequest $request)
	{
		$user = $this->user->find(Auth::user()->id);
		$user->name = Input::get('name');
		$user->email = Input::get('email');

		if($user->save())
		{
			Notification::success('Perfil salvo com sucesso.');
		}
		else
		{
			Notification::error('Ops, erro ao salvar...');
		}

		return redirect()->route('admin.profile');
	}

	public function changePassword(ChangePasswordRequest $request)
	{
		$credentials = ['email' => Auth::user()->email, 'password' => Input::get('password')];
		if(!Auth::attempt($credentials))
		{
			Notification::error('A senha atual está incorreta. Tente novamente.');
		}
		else
		{
			$user = $this->user->find(Auth::user()->id);
			$user->password = Hash::make(Input::get('new_password'));
			if($user->save())
			{
				Notification::success('Senha alterada com sucesso.');
			}
			else
			{
				Notification::error('Ops, erro ao alterar senha...');
			}
		}

		return redirect()->route('admin.profile');
	}
}

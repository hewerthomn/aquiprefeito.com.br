<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\City;
use App\Issue;
use App\Status;
use File, Input, Notification;

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

	public function getShow($id)
	{
		$v['title'] = 'Detalhes de Problema';
		$v['issue'] = $this->issue->find($id);

		return view('admin.issue.show', $v);
	}

	public function postDelete()
	{
		$id = Input::get('id');
		$issue = $this->issue->find($id);

		if ($issue && $issue->delete())
		{
			$files = [];
			$path = public_path() . '/img/issues/';
			$folders = ['', 'sm/', 'md/', 'lg/', 'big/'];

			foreach ($folders as $folder) {
				$files[] = "{$path}{$folder}{$issue->image_path}";
			}

			File::delete($files);

			Notification::success("Problema #{$id} excluído com sucesso.");
		}
		else
		{
			Notification::error("Ops, erro ao excluir problema #{$id}...");
		}

		return redirect(url('/admin/issue/'));
	}
}
